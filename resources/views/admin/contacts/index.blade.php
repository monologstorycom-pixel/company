<x-admin-layout>
    <x-slot name="title">Contact Messages</x-slot>

    <!-- Enhanced Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Contact Messages</h1>
            <p class="text-gray-600 mt-1">Manage customer inquiries and messages</p>
        </div>
        <div class="flex items-center space-x-3">
            <span class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium">
                <i data-lucide="mail" class="w-4 h-4 mr-2"></i>
                {{ $contacts->total() }} Messages
            </span>
        </div>
    </div>

    <!-- Stats Cards -->
    @php
        $totalContacts = $contacts->total();
        $unreadCount = \App\Models\Contact::where('status', 'unread')->count();
        $readCount = \App\Models\Contact::where('status', 'read')->count();
        $repliedCount = \App\Models\Contact::where('status', 'replied')->count();
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-white to-purple-50 p-4 rounded-xl shadow-lg border border-purple-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Messages</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $totalContacts }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-xl">
                    <i data-lucide="mail" class="w-6 h-6 text-purple-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-yellow-50 p-4 rounded-xl shadow-lg border border-yellow-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Unread</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $unreadCount }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-xl">
                    <i data-lucide="mail-warning" class="w-6 h-6 text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-blue-50 p-4 rounded-xl shadow-lg border border-blue-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Read</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $readCount }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-xl">
                    <i data-lucide="mail-open" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-green-50 p-4 rounded-xl shadow-lg border border-green-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Replied</p>
                    <p class="text-2xl font-bold text-green-600">{{ $repliedCount }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-xl">
                    <i data-lucide="mail-check" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-6">
        <div class="flex items-center mb-4">
            <i data-lucide="filter" class="w-5 h-5 text-gray-600 mr-2"></i>
            <h3 class="text-lg font-semibold text-gray-900">Filter Messages</h3>
        </div>
        <form method="GET" action="{{ route('admin.contacts.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <div class="relative">
                    <select name="status" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent appearance-none transition-all duration-200">
                        <option value="">All Status</option>
                        <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                        <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Replied</option>
                    </select>
                    <i data-lucide="inbox" class="w-4 h-4 absolute left-3 top-3 text-gray-400 pointer-events-none"></i>
                </div>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-xl hover:from-purple-700 hover:to-purple-800 transition-all duration-200 font-medium">
                <i data-lucide="search" class="w-4 h-4 inline mr-2"></i>
                Filter
            </button>
            @if(request('status'))
                <a href="{{ route('admin.contacts.index') }}" class="px-6 py-2.5 bg-gray-500 text-white rounded-xl hover:bg-gray-600 transition-colors font-medium">
                    <i data-lucide="x" class="w-4 h-4 inline mr-2"></i>
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Messages Table -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Message Inbox</h3>
                <div class="text-sm text-gray-600">
                    Showing {{ $contacts->firstItem() ?? 0 }} - {{ $contacts->lastItem() ?? 0 }} of {{ $contacts->total() }}
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Sender</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Subject & Message</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Received</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($contacts as $contact)
                    <tr class="hover:bg-gray-50 transition-colors duration-150 {{ $contact->status == 'unread' ? 'bg-purple-50/50' : '' }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-bold text-white">{{ strtoupper(substr($contact->name, 0, 1)) }}</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900 {{ $contact->status == 'unread' ? 'font-bold' : '' }}">
                                        {{ $contact->name }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $contact->email }}</div>
                                    @if($contact->phone)
                                        <div class="text-xs text-gray-400 flex items-center mt-1">
                                            <i data-lucide="phone" class="w-3 h-3 mr-1"></i>
                                            {{ $contact->phone }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="max-w-md">
                                <div class="text-sm font-medium text-gray-900 {{ $contact->status == 'unread' ? 'font-bold' : '' }}">
                                    {{ \Illuminate\Support\Str::limit($contact->subject, 50) }}
                                </div>
                                <div class="text-sm text-gray-500 mt-1">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($contact->message), 80) }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($contact->status === 'unread')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    <span class="w-2 h-2 rounded-full bg-yellow-500 mr-2 animate-pulse"></span>
                                    Unread
                                </span>
                            @elseif($contact->status === 'read')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                    <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span>
                                    Read
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                                    Replied
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $contact->created_at->format('M d, Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $contact->created_at->format('H:i') }}</div>
                            <div class="text-xs text-gray-400 mt-1">{{ $contact->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.contacts.show', $contact) }}"
                                   class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors"
                                   title="View Message">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                @can('delete contacts')
                                    <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this message?')">
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
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i data-lucide="inbox" class="w-16 h-16 text-gray-300 mb-4"></i>
                                <p class="text-gray-500 text-lg font-medium mb-2">No messages found</p>
                                <p class="text-gray-400 text-sm">When customers contact you, their messages will appear here</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($contacts->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
            <div class="text-sm text-gray-600">
                Showing <span class="font-medium">{{ $contacts->firstItem() }}</span> to
                <span class="font-medium">{{ $contacts->lastItem() }}</span> of
                <span class="font-medium">{{ $contacts->total() }}</span> messages
            </div>
            <div>
                {{ $contacts->appends(request()->query())->links() }}
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
