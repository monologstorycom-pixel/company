<x-admin-layout>
    <x-slot name="title">Chatbot History</x-slot>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Chatbot History</h1>
        <div class="text-sm text-gray-600">
            {{ $histories->total() }} total conversations
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Chat Conversations</h2>
            <p class="text-sm text-gray-600 mt-1">All chatbot interactions are logged here for analysis</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Session</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Message</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bot Response</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Matched Rule</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($histories as $history)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-xs font-mono text-gray-500">{{ \Illuminate\Support\Str::limit($history->session_id, 20) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs">{{ \Illuminate\Support\Str::limit($history->user_message, 60) }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-700 max-w-xs">{{ \Illuminate\Support\Str::limit($history->bot_response, 80) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($history->rule)
                                <span class="text-xs text-gray-600">{{ $history->rule->keyword }}</span>
                            @else
                                <span class="text-xs text-gray-400">No match</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $history->created_at->format('M d, Y') }}<br>
                            <span class="text-xs">{{ $history->created_at->format('H:i') }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No chat history found yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($histories->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $histories->links() }}
        </div>
        @endif
    </div>

    <!-- Analytics Summary -->
    @php
        $todayCount = \App\Models\ChatHistory::whereDate('created_at', today())->count();
        $weekCount = \App\Models\ChatHistory::where('created_at', '>=', now()->subWeek())->count();
        $monthCount = \App\Models\ChatHistory::where('created_at', '>=', now()->subMonth())->count();
    @endphp

    <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-sm font-medium text-gray-600 mb-2">Today</h3>
            <p class="text-2xl font-bold text-green-600">{{ $todayCount }}</p>
            <p class="text-xs text-gray-500 mt-1">Chat sessions</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-sm font-medium text-gray-600 mb-2">This Week</h3>
            <p class="text-2xl font-bold text-blue-600">{{ $weekCount }}</p>
            <p class="text-xs text-gray-500 mt-1">Chat sessions</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-sm font-medium text-gray-600 mb-2">This Month</h3>
            <p class="text-2xl font-bold text-purple-600">{{ $monthCount }}</p>
            <p class="text-xs text-gray-500 mt-1">Chat sessions</p>
        </div>
    </div>
</x-admin-layout>

