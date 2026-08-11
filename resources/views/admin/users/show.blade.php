<x-admin-layout>
    <x-slot name="title">User Details</x-slot>

    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-green-600 hover:text-green-700">&larr; Back to Users</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">User Information</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email Verified</label>
                        <p class="mt-1 text-sm">
                            @if($user->email_verified_at)
                                <span class="text-green-600">Verified on {{ $user->email_verified_at->format('M d, Y') }}</span>
                            @else
                                <span class="text-red-600">Not verified</span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Created At</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('M d, Y H:i') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>

                <div class="mt-6 flex gap-4">
                    <a href="{{ route('admin.users.edit', $user) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        Edit User
                    </a>
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Roles</h3>
                <div class="space-y-2">
                    @foreach($user->roles as $role)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        {{ $role->name }}
                    </span>
                    @endforeach
                    @if($user->roles->isEmpty())
                    <p class="text-sm text-gray-500">No roles assigned</p>
                    @endif
                </div>

                <h3 class="text-lg font-semibold text-gray-900 mt-6 mb-4">Permissions</h3>
                <div class="space-y-1 max-h-64 overflow-y-auto">
                    @foreach($user->permissions as $permission)
                    <div class="text-sm text-gray-700">{{ $permission->name }}</div>
                    @endforeach
                    @if($user->permissions->isEmpty())
                    <p class="text-sm text-gray-500">No direct permissions</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>



