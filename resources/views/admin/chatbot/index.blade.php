<x-admin-layout>
    <x-slot name="title">Chatbot Rules</x-slot>

    <!-- Enhanced Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Chatbot Rules</h1>
            <p class="text-gray-600 mt-1">Configure automated responses for your chatbot</p>
        </div>
        @can('create chatbot')
            <a href="{{ route('admin.chatbot.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-cyan-600 to-cyan-700 text-white rounded-xl hover:from-cyan-700 hover:to-cyan-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                <i data-lucide="plus-circle" class="w-5 h-5 mr-2"></i>
                Add Rule
            </a>
        @endcan
    </div>

    <!-- Stats Cards -->
    @php
        $totalRules = $rules->total();
        $activeRules = \App\Models\ChatbotRule::where('status', 'active')->count();
        $inactiveRules = \App\Models\ChatbotRule::where('status', 'inactive')->count();
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-br from-white to-cyan-50 p-4 rounded-xl shadow-lg border border-cyan-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Rules</p>
                    <p class="text-2xl font-bold text-cyan-600">{{ $totalRules }}</p>
                </div>
                <div class="p-3 bg-cyan-100 rounded-xl">
                    <i data-lucide="bot" class="w-6 h-6 text-cyan-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-green-50 p-4 rounded-xl shadow-lg border border-green-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Active</p>
                    <p class="text-2xl font-bold text-green-600">{{ $activeRules }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-xl">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-gray-50 p-4 rounded-xl shadow-lg border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Inactive</p>
                    <p class="text-2xl font-bold text-gray-600">{{ $inactiveRules }}</p>
                </div>
                <div class="p-3 bg-gray-100 rounded-xl">
                    <i data-lucide="pause-circle" class="w-6 h-6 text-gray-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Banner -->
    <div class="bg-gradient-to-r from-cyan-50 to-blue-50 border border-cyan-200 rounded-xl p-4 mb-6">
        <div class="flex items-start">
            <i data-lucide="info" class="w-5 h-5 text-cyan-600 mr-3 mt-0.5"></i>
            <div>
                <p class="text-sm font-medium text-cyan-800">How Priority Works</p>
                <p class="text-sm text-cyan-700 mt-1">Rules are matched by priority (higher number = checked first). When a user message matches multiple rules, the one with higher priority will be used.</p>
            </div>
        </div>
    </div>

    <!-- Rules Table -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">All Rules</h3>
                <div class="text-sm text-gray-600">
                    <span class="font-medium">{{ $totalRules }}</span> rules configured
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Keyword</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Response</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Priority</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($rules as $rule)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-cyan-100 rounded-lg flex items-center justify-center mr-3">
                                    <i data-lucide="message-circle" class="w-4 h-4 text-cyan-600"></i>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ $rule->keyword }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-600 max-w-md">{{ \Illuminate\Support\Str::limit($rule->response, 80) }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $typeColors = [
                                    'text' => 'bg-blue-100 text-blue-800',
                                    'link' => 'bg-purple-100 text-purple-800',
                                    'product' => 'bg-green-100 text-green-800',
                                ];
                                $typeClass = $typeColors[$rule->type] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ $typeClass }}">
                                {{ ucfirst($rule->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <span class="text-sm font-bold text-gray-700">{{ $rule->priority }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                {{ $rule->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                <span class="w-2 h-2 rounded-full mr-2 {{ $rule->status === 'active' ? 'bg-green-500' : 'bg-gray-500' }}"></span>
                                {{ ucfirst($rule->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                @can('edit chatbot')
                                    <a href="{{ route('admin.chatbot.edit', $rule) }}"
                                       class="p-2 text-cyan-600 hover:text-cyan-800 hover:bg-cyan-50 rounded-lg transition-colors"
                                       title="Edit">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                @endcan
                                @can('delete chatbot')
                                    <form method="POST" action="{{ route('admin.chatbot.destroy', $rule) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this rule?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Delete">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i data-lucide="bot" class="w-16 h-16 text-gray-300 mb-4"></i>
                                <p class="text-gray-500 text-lg font-medium mb-2">No chatbot rules yet</p>
                                <p class="text-gray-400 text-sm mb-4">Create rules to enable automated responses</p>
                                @can('create chatbot')
                                    <a href="{{ route('admin.chatbot.create') }}"
                                       class="inline-flex items-center px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors">
                                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                        Create First Rule
                                    </a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($rules->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
            <div class="text-sm text-gray-600">
                Showing <span class="font-medium">{{ $rules->firstItem() }}</span> to
                <span class="font-medium">{{ $rules->lastItem() }}</span> of
                <span class="font-medium">{{ $rules->total() }}</span> rules
            </div>
            <div>
                {{ $rules->links() }}
            </div>
        </div>
        @endif
    </div>

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        lucide.createIcons();
        setInterval(() => lucide.createIcons(), 1000);
    </script>
</x-admin-layout>
