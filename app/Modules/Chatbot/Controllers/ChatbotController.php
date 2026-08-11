<?php

namespace App\Modules\Chatbot\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ChatbotService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function __construct(
        protected ChatbotService $chatbotService
    ) {}

    /**
     * Handle GET request to chatbot endpoint (returns error message).
     */
    public function handleGet(): JsonResponse
    {
        return response()->json([
            'error' => 'This endpoint only accepts POST requests. Please use the chatbot interface.',
            'message' => 'Use POST method with a JSON body containing {"message": "your message"}'
        ], 405);
    }

    /**
     * Handle POST request with chatbot message (optimized with service layer).
     */
    public function handleMessage(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:500'
        ]);

        try {
            // Get session ID from session or request
            $sessionId = session()->getId() ?? $request->input('session_id');
            
            // Get user ID (can be null for unauthenticated users)
            $userId = auth()->id();
            
            // Get IP address and user agent
            $ipAddress = $request->ip();
            $userAgent = $request->userAgent() ?? 'Unknown';

            // Process message using service (handles rate limiting, caching, and rule matching)
            $result = $this->chatbotService->processMessage(
                $request->input('message'),
                $sessionId,
                $ipAddress,
                $userAgent,
                $userId
            );

            // Check if rate limit was exceeded
            if (isset($result['error']) && $result['error'] === 'rate_limit_exceeded') {
                return response()->json([
                    'error' => 'rate_limit_exceeded',
                    'message' => $result['response'],
                    'rate_limit' => $result['rate_limit'] ?? null,
                    'retry_after' => $result['rate_limit']['retry_after_minute'] ?? 60,
                ], 429);
            }

            // Return successful response
            return response()->json([
                'response' => $result['response'],
                'session_id' => $result['session_id'],
                'timestamp' => $result['timestamp'] ?? now()->toISOString(),
                'type' => $result['type'] ?? 'text',
                'extra' => $result['extra'] ?? [],
            ]);

        } catch (\Exception $e) {
            // Log the error
            Log::error('Chatbot error: ' . $e->getMessage(), [
                'exception' => $e,
                'message' => $request->input('message'),
                'ip' => $request->ip(),
            ]);

            // Return error response
            return response()->json([
                'error' => 'An error occurred while processing your message.',
                'response' => 'I apologize, but I encountered an error. Please try again later.',
                'timestamp' => now()->toISOString(),
            ], 500);
        }
    }
}
