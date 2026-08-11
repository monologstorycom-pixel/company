<x-admin-layout>
    <x-slot name="title">Role & Permission Management</x-slot>

    <!-- Enhanced Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Roles & Permissions</h1>
            <p class="text-gray-600 mt-1">Manage user roles and access permissions</p>
        </div>
        <a href="{{ route('admin.roles.create') }}"
           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
            <i data-lucide="shield-plus" class="w-5 h-5 mr-2"></i>
            Create Role
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-br from-white to-indigo-50 p-4 rounded-xl shadow-lg border border-indigo-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Roles</p>
                    <p class="text-2xl font-bold text-indigo-600">{{ $roles->count() }}</p>
                </div>
                <div class="p-3 bg-indigo-100 rounded-xl">
                    <i data-lucide="shield" class="w-6 h-6 text-indigo-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-green-50 p-4 rounded-xl shadow-lg border border-green-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Built-in Roles</p>
                    <p class="text-2xl font-bold text-green-600">3</p>
                </div>
                <div class="p-3 bg-green-100 rounded-xl">
                    <i data-lucide="lock" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-purple-50 p-4 rounded-xl shadow-lg border border-purple-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Permissions</p>
                    <p class="text-2xl font-bold text-purple-600">{{ \Spatie\Permission\Models\Permission::count() }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-xl">
                    <i data-lucide="key" class="w-6 h-6 text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Roles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($roles as $role)
            @php
                $roleColors = [
                    'Super Admin' => ['bg' => 'from-red-500 to-red-600', 'light' => 'red', 'icon' => 'shield'],
                    'Admin' => ['bg' => 'from-green-500 to-green-600', 'light' => 'green', 'icon' => 'user-cog'],
                    'Marketing' => ['bg' => 'from-purple-500 to-purple-600', 'light' => 'purple', 'icon' => 'megaphone'],
                ];
                $colors = $roleColors[$role->name] ?? ['bg' => 'from-gray-500 to-gray-600', 'light' => 'gray', 'icon' => 'users'];
            @endphp
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <!-- Role Header -->
                <div class="bg-gradient-to-r {{ $colors['bg'] }} p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                <i data-lucide="{{ $colors['icon'] }}" class="w-6 h-6 text-white"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-bold text-white">{{ $role->name }}</h3>
                                @if(in_array($role->name, ['Super Admin', 'Admin', 'Marketing']))
                                    <span class="text-xs text-white/80">Built-in Role</span>
                                @else
                                    <span class="text-xs text-white/80">Custom Role</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Role Stats -->
                <div class="p-4 border-b border-gray-100">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ $role->users_count }}</div>
                            <div class="text-xs text-gray-500">Users</div>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-900">{{ $role->permissions_count }}</div>
                            <div class="text-xs text-gray-500">Permissions</div>
                        </div>
                    </div>
                </div>

                <!-- Role Actions -->
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.roles.show', $role) }}"
                           class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors"
                           title="View Details">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('admin.roles.edit', $role) }}"
                           class="p-2 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded-lg transition-colors"
                           title="Edit Role">
                            <i data-lucide="edit" class="w-4 h-4"></i>
                        </a>
                        @if(!in_array($role->name, ['Super Admin', 'Admin', 'Marketing']))
                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this role?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Delete Role">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                    <a href="{{ route('admin.roles.show', $role) }}"
                       class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors">
                        View Details
                        <i data-lucide="arrow-right" class="w-4 h-4 inline ml-1"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-12 text-center">
                    <i data-lucide="shield-off" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                    <p class="text-gray-500 text-lg font-medium mb-2">No roles found</p>
                    <p class="text-gray-400 text-sm mb-4">Start by creating your first role</p>
                    <a href="{{ route('admin.roles.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                        Create Role
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        lucide.createIcons();
        setInterval(() => lucide.createIcons(), 1000);
    </script>
</x-admin-layout>
