<x-admin-layout>
    <x-slot name="title">Edit Role</x-slot>

    <div class="mb-6">
        <a href="{{ route('admin.roles.index') }}" class="text-green-600 hover:text-green-700">&larr; Back to Roles</a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Edit Role: {{ $role->name }}</h2>

        @if(in_array($role->name, ['Super Admin', 'Admin', 'Marketing']))
        <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
            <p class="text-sm text-yellow-800">Note: This is a built-in role. The name cannot be changed, but permissions can be modified.</p>
        </div>
        @endif

        <form action="{{ route('admin.roles.update', $role) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Role Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" required
                       {{ in_array($role->name, ['Super Admin', 'Admin', 'Marketing']) ? 'readonly' : '' }}
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 {{ in_array($role->name, ['Super Admin', 'Admin', 'Marketing']) ? 'bg-gray-100' : '' }}">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">Permissions</label>
                <div class="border border-gray-300 rounded-lg p-4 max-h-96 overflow-y-auto">
                    <div class="space-y-4">
                        @foreach($permissions as $group => $groupPermissions)
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-2 capitalize">{{ $group }}</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                @foreach($groupPermissions as $permission)
                                <label class="flex items-center">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                           {{ $role->hasPermissionTo($permission) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                    <span class="ml-2 text-sm text-gray-700">{{ $permission->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @error('permissions')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                    Update Role
                </button>
                <a href="{{ route('admin.roles.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>



