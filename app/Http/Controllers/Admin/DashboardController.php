<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Article;
use App\Models\Contact;
use App\Models\ChatHistory;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Cache TTL for dashboard stats (1 hour).
     */
    const CACHE_TTL = 3600;

    /**
     * Display the dashboard based on user role.
     */
    public function index()
    {
        // Authorization is handled by route middleware

        $user = auth()->user();

        // Determine dashboard view based on role
        if ($user->hasRole('Super Admin')) {
            return $this->superAdminDashboard();
        } elseif ($user->hasRole('Admin')) {
            return $this->adminDashboard();
        } elseif ($user->hasRole('Marketing')) {
            return $this->marketingDashboard();
        }

        // Default fallback
        return $this->adminDashboard();
    }

    /**
     * Super Admin Dashboard (optimized with single query for stats).
     */
    protected function superAdminDashboard()
    {
        $stats = Cache::remember('superadmin_dashboard_stats', self::CACHE_TTL, function () {
            $today = today();
            
            // Use optimized queries with selectRaw for aggregation
            // Get multiple counts in parallel using DB::select
            $result = DB::select("
                SELECT 
                    (SELECT COUNT(*) FROM users) as total_users,
                    (SELECT COUNT(*) FROM products WHERE deleted_at IS NULL) as total_products,
                    (SELECT COUNT(*) FROM products WHERE is_active = 1 AND deleted_at IS NULL) as active_products,
                    (SELECT COUNT(*) FROM articles WHERE deleted_at IS NULL) as total_articles,
                    (SELECT COUNT(*) FROM articles WHERE is_published = 1 AND deleted_at IS NULL) as published_articles,
                    (SELECT COUNT(*) FROM contacts WHERE deleted_at IS NULL) as total_contacts,
                    (SELECT COUNT(*) FROM contacts WHERE status = 'unread' AND deleted_at IS NULL) as unread_contacts,
                    (SELECT COUNT(*) FROM chat_histories WHERE DATE(created_at) = ?) as today_chats,
                    (SELECT COUNT(*) FROM chat_histories) as total_chats
            ", [$today->toDateString()]);

            $data = (array) $result[0];

            return [
                'total_users' => (int) ($data['total_users'] ?? 0),
                'total_products' => (int) ($data['total_products'] ?? 0),
                'active_products' => (int) ($data['active_products'] ?? 0),
                'total_articles' => (int) ($data['total_articles'] ?? 0),
                'published_articles' => (int) ($data['published_articles'] ?? 0),
                'total_contacts' => (int) ($data['total_contacts'] ?? 0),
                'unread_contacts' => (int) ($data['unread_contacts'] ?? 0),
                'today_chats' => (int) ($data['today_chats'] ?? 0),
                'total_chats' => (int) ($data['total_chats'] ?? 0),
            ];
        });

        // Get recent data with eager loading
        $recentContacts = Contact::orderBy('created_at', 'desc')->limit(5)->get();
        $recentArticles = Article::with('author')->orderBy('created_at', 'desc')->limit(5)->get();
        $recentUsers = User::orderBy('created_at', 'desc')->limit(5)->get();

        return view('superadmin.dashboard', compact('stats', 'recentContacts', 'recentArticles', 'recentUsers'));
    }

    /**
     * Admin Dashboard (optimized with single query for stats).
     */
    protected function adminDashboard()
    {
        $stats = Cache::remember('admin_dashboard_stats', self::CACHE_TTL, function () {
            $today = today();
            
            // Use optimized queries with selectRaw for aggregation
            $result = DB::select("
                SELECT 
                    (SELECT COUNT(*) FROM products WHERE deleted_at IS NULL) as total_products,
                    (SELECT COUNT(*) FROM products WHERE is_active = 1 AND deleted_at IS NULL) as active_products,
                    (SELECT COUNT(*) FROM products WHERE is_featured = 1 AND is_active = 1 AND deleted_at IS NULL) as featured_products,
                    (SELECT COUNT(*) FROM articles WHERE deleted_at IS NULL) as total_articles,
                    (SELECT COUNT(*) FROM articles WHERE is_published = 1 AND deleted_at IS NULL) as published_articles,
                    (SELECT COUNT(*) FROM contacts WHERE deleted_at IS NULL) as total_contacts,
                    (SELECT COUNT(*) FROM contacts WHERE status = 'unread' AND deleted_at IS NULL) as unread_contacts,
                    (SELECT COUNT(*) FROM chat_histories WHERE DATE(created_at) = ?) as today_chats
            ", [$today->toDateString()]);

            $data = (array) $result[0];

            return [
                'total_products' => (int) ($data['total_products'] ?? 0),
                'active_products' => (int) ($data['active_products'] ?? 0),
                'featured_products' => (int) ($data['featured_products'] ?? 0),
                'total_articles' => (int) ($data['total_articles'] ?? 0),
                'published_articles' => (int) ($data['published_articles'] ?? 0),
                'total_contacts' => (int) ($data['total_contacts'] ?? 0),
                'unread_contacts' => (int) ($data['unread_contacts'] ?? 0),
                'today_chats' => (int) ($data['today_chats'] ?? 0),
            ];
        });

        // Get recent data with eager loading
        $recentContacts = Contact::orderBy('created_at', 'desc')->limit(5)->get();
        $recentArticles = Article::with('author')->orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentContacts', 'recentArticles'));
    }

    /**
     * Marketing Dashboard (optimized with single query for stats).
     */
    protected function marketingDashboard()
    {
        $user = auth()->user();
        
        $stats = Cache::remember("marketing_dashboard_stats_{$user->id}", self::CACHE_TTL, function () use ($user) {
            $today = today();
            
            // Use optimized queries with selectRaw for aggregation
            $result = DB::select("
                SELECT 
                    (SELECT COUNT(*) FROM articles WHERE author_id = ? AND deleted_at IS NULL) as my_articles,
                    (SELECT COUNT(*) FROM articles WHERE author_id = ? AND is_published = 1 AND deleted_at IS NULL) as published_articles,
                    (SELECT COUNT(*) FROM articles WHERE author_id = ? AND is_published = 0 AND deleted_at IS NULL) as draft_articles,
                    (SELECT COUNT(*) FROM chat_histories WHERE DATE(created_at) = ?) as today_chats,
                    (SELECT COUNT(*) FROM chat_histories) as total_chats
            ", [$user->id, $user->id, $user->id, $today->toDateString()]);

            $data = (array) $result[0];

            return [
                'my_articles' => (int) ($data['my_articles'] ?? 0),
                'published_articles' => (int) ($data['published_articles'] ?? 0),
                'draft_articles' => (int) ($data['draft_articles'] ?? 0),
                'today_chats' => (int) ($data['today_chats'] ?? 0),
                'total_chats' => (int) ($data['total_chats'] ?? 0),
            ];
        });

        // Get recent data with eager loading
        $myRecentArticles = Article::where('author_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $recentChats = ChatHistory::with('rule')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('marketing.dashboard', compact('stats', 'myRecentArticles', 'recentChats'));
    }
}
