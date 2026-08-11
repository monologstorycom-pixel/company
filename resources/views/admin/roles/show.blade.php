<x-admin-layout>
    <x-slot name="title">Role Details</x-slot>

    <div class="mb-6">
        <a href="{{ route('admin.roles.index') }}" class="text-green-600 hover:text-green-700">&larr; Back to Roles</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Role Information</h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Role Name</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $role->name }}</p>
                    @if(in_array($role->name, ['Super Admin', 'Admin', 'Marketing']))
                    <p class="mt-1 text-xs text-gray-500">Built-in role</p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Users with this role</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $role->users->count() }} users</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Total Permissions</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $role->permissions->count() }} permissions</p>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <a href="{{ route('admin.roles.edit', $role) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                    Edit Role
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Assigned Permissions</h3>
            <div class="space-y-2 max-h-96 overflow-y-auto">
                @foreach($role->permissions as $permission)
                <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                    <span class="text-sm text-gray-700">{{ $permission->name }}</span>
                </div>
                @endforeach
                @if($role->permissions->isEmpty())
                <p class="text-sm text-gray-500">No permissions assigned</p>
                @endif
            </div>
        </div>
    </div>

    @if($role->users->count() > 0)
    <div class="mt-6 bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Users with this Role</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($role->users as $user)
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                        <span class="text-green-800 font-medium">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</x-admin-layout>



