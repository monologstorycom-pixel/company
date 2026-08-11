<x-admin-layout>
    <x-slot name="title">User Management</x-slot>

    <!-- Enhanced Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">User Management</h1>
            <p class="text-gray-600 mt-1">Manage system users and their roles</p>
        </div>
        <a href="{{ route('admin.users.create') }}"
           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
            <i data-lucide="user-plus" class="w-5 h-5 mr-2"></i>
            Add User
        </a>
    </div>

    <!-- Stats Cards -->
    @php
        $totalUsers = $users->total();
        $adminCount = \App\Models\User::role('Admin')->count();
        $superAdminCount = \App\Models\User::role('Super Admin')->count();
        $marketingCount = \App\Models\User::role('Marketing')->count();
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-white to-blue-50 p-4 rounded-xl shadow-lg border border-blue-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalUsers }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-xl">
                    <i data-lucide="users" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-red-50 p-4 rounded-xl shadow-lg border border-red-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Super Admin</p>
                    <p class="text-2xl font-bold text-red-600">{{ $superAdminCount }}</p>
                </div>
                <div class="p-3 bg-red-100 rounded-xl">
                    <i data-lucide="shield" class="w-6 h-6 text-red-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-green-50 p-4 rounded-xl shadow-lg border border-green-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Admin</p>
                    <p class="text-2xl font-bold text-green-600">{{ $adminCount }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-xl">
                    <i data-lucide="user-cog" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-purple-50 p-4 rounded-xl shadow-lg border border-purple-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Marketing</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $marketingCount }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-xl">
                    <i data-lucide="megaphone" class="w-6 h-6 text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">All Users</h3>
                <div class="text-sm text-gray-600">
                    <span class="font-medium">{{ $totalUsers }}</span> registered users
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Roles</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-md">
                                        <span class="text-sm font-bold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                    @if($user->id === auth()->id())
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            You
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center text-sm text-gray-900">
                                <i data-lucide="mail" class="w-4 h-4 mr-2 text-gray-400"></i>
                                {{ $user->email }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @forelse($user->roles as $role)
                                    @php
                                        $roleColors = [
                                            'Super Admin' => 'bg-red-100 text-red-800',
                                            'Admin' => 'bg-green-100 text-green-800',
                                            'Marketing' => 'bg-purple-100 text-purple-800',
                                        ];
                                        $colorClass = $roleColors[$role->name] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $colorClass }}">
                                        {{ $role->name }}
                                    </span>
                                @empty
                                    <span class="text-xs text-gray-400 italic">No roles assigned</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors"
                                   title="View">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="p-2 text-green-600 hover:text-green-800 hover:bg-green-50 rounded-lg transition-colors"
                                   title="Edit">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Delete">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i data-lucide="users" class="w-16 h-16 text-gray-300 mb-4"></i>
                                <p class="text-gray-500 text-lg font-medium mb-2">No users found</p>
                                <p class="text-gray-400 text-sm mb-4">Start by creating your first user</p>
                                <a href="{{ route('admin.users.create') }}"
                                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
                                    Add User
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
            <div class="text-sm text-gray-600">
                Showing <span class="font-medium">{{ $users->firstItem() }}</span> to
                <span class="font-medium">{{ $users->lastItem() }}</span> of
                <span class="font-medium">{{ $users->total() }}</span> users
            </div>
            <div>
                {{ $users->links() }}
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
