<?php

namespace App\Repositories;

use App\Models\ChatHistory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ChatHistoryRepository extends BaseRepository
{
    /**
     * Cache TTL for analytics data (15 minutes).
     */
    const ANALYTICS_CACHE_TTL = 900;

    /**
     * Create a new repository instance.
     */
    public function __construct(ChatHistory $model)
    {
        parent::__construct($model);
    }

    /**
     * Get chat history by session ID (with caching).
     *
     * @param string $sessionId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getBySession(string $sessionId)
    {
        $cacheKey = "chat_history:session:{$sessionId}";
        
        return Cache::remember(
            $cacheKey,
            300, // 5 minutes cache
            function () use ($sessionId) {
                return $this->newQuery()
                    ->where('session_id', $sessionId)
                    ->orderBy('created_at', 'asc')
                    ->get();
            }
        );
    }

    /**
     * Get recent chat history.
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecent(int $limit = 50)
    {
        return $this->newQuery()
            ->with('rule') // Eager load rule relationship
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get analytics data (optimized with single query and caching).
     *
     * @param int $days
     * @return array
     */
    public function getAnalytics(int $days = 30)
    {
        $startDate = now()->subDays($days);
        $cacheKey = "chat_history:analytics:{$days}:" . $startDate->format('Y-m-d');
        
        return Cache::remember(
            $cacheKey,
            self::ANALYTICS_CACHE_TTL,
            function () use ($startDate) {
                // Use single query with subqueries for better performance
                $baseQuery = $this->newQuery()->where('created_at', '>=', $startDate);
                
                // Get messages by day in a single query
                $messagesByDay = DB::table('chat_histories')
                    ->where('created_at', '>=', $startDate)
                    ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->groupBy('date')
                    ->orderBy('date', 'asc')
                    ->get();

                // Get total messages count
                $totalMessages = $baseQuery->count();

                // Get unique sessions count (optimized with distinct)
                $uniqueSessions = DB::table('chat_histories')
                    ->where('created_at', '>=', $startDate)
                    ->distinct()
                    ->count('session_id');

                // Get top rules used
                $topRules = DB::table('chat_histories')
                    ->where('created_at', '>=', $startDate)
                    ->whereNotNull('rule_id')
                    ->select('rule_id', DB::raw('COUNT(*) as count'))
                    ->groupBy('rule_id')
                    ->orderBy('count', 'desc')
                    ->limit(10)
                    ->get();

                // Get messages by hour (for hourly analytics)
                $messagesByHour = DB::table('chat_histories')
                    ->where('created_at', '>=', $startDate)
                    ->selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
                    ->groupBy('hour')
                    ->orderBy('hour', 'asc')
                    ->get();

                return [
                    'total_messages' => $totalMessages,
                    'unique_sessions' => $uniqueSessions,
                    'messages_by_day' => $messagesByDay,
                    'messages_by_hour' => $messagesByHour,
                    'top_rules' => $topRules,
                    'start_date' => $startDate->toDateString(),
                    'end_date' => now()->toDateString(),
                ];
            }
        );
    }

    /**
     * Clear cache for chat history.
     *
     * @return void
     */
    public function clearCache(): void
    {
        // Clear analytics cache for common day ranges
        foreach ([7, 14, 30, 60, 90] as $days) {
            $startDate = now()->subDays($days);
            Cache::forget("chat_history:analytics:{$days}:" . $startDate->format('Y-m-d'));
        }
    }

    /**
     * Clear cache for specific session.
     *
     * @param string $sessionId
     * @return void
     */
    public function clearSessionCache(string $sessionId): void
    {
        $cacheKey = "chat_history:session:{$sessionId}";
        Cache::forget($cacheKey);
    }
}

