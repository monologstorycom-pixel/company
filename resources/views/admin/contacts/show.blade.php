<x-admin-layout>
    <x-slot name="title">Contact Message</x-slot>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Contact Message</h1>
        <div class="flex gap-2">
            @can('delete contacts')
            <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" onsubmit="return confirm('Are you sure you want to delete this message?')" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                    Delete
                </button>
            </form>
            @endcan
            <a href="{{ route('admin.contacts.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                Back to Messages
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-6 pb-4 border-b">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $contact->subject }}</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ $contact->created_at->format('F d, Y, h:i A') }}</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $contact->status === 'unread' ? 'bg-yellow-100 text-yellow-800' :
                           ($contact->status === 'read' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                        {{ ucfirst($contact->status) }}
                    </span>
                </div>

                <div class="prose prose-gray max-w-none">
                    <p class="whitespace-pre-wrap text-gray-700">{{ $contact->message }}</p>
                </div>
            </div>

            @if($contact->ip_address || $contact->user_agent)
            <div class="bg-gray-50 rounded-lg shadow-md p-6">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Technical Details</h3>
                <dl class="space-y-2 text-sm">
                    @if($contact->ip_address)
                    <div>
                        <dt class="text-gray-500">IP Address</dt>
                        <dd class="text-gray-900 font-mono">{{ $contact->ip_address }}</dd>
                    </div>
                    @endif
                    @if($contact->user_agent)
                    <div>
                        <dt class="text-gray-500">User Agent</dt>
                        <dd class="text-gray-900 text-xs break-all">{{ $contact->user_agent }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Contact Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h2>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $contact->name }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <a href="mailto:{{ $contact->email }}" class="text-green-600 hover:text-green-700">{{ $contact->email }}</a>
                        </dd>
                    </div>

                    @if($contact->phone)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Phone</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <a href="tel:{{ $contact->phone }}" class="text-green-600 hover:text-green-700">{{ $contact->phone }}</a>
                        </dd>
                    </div>
                    @endif

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Submitted</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $contact->created_at->diffForHumans() }}</dd>
                    </div>

                    @if($contact->read_at)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Read At</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $contact->read_at->format('M d, Y H:i') }}</dd>
                    </div>
                    @endif
                </dl>
            </div>

            <!-- Update Status -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Update Status</h2>
                <form method="POST" action="{{ route('admin.contacts.update', $contact) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="unread" {{ $contact->status == 'unread' ? 'selected' : '' }}>Unread</option>
                            <option value="read" {{ $contact->status == 'read' ? 'selected' : '' }}>Read</option>
                            <option value="replied" {{ $contact->status == 'replied' ? 'selected' : '' }}>Replied</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        Update Status
                    </button>
                </form>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                <div class="space-y-2">
                    <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="block w-full bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Reply via Email
                    </a>
                    @if($contact->phone)
                    <a href="tel:{{ $contact->phone }}" class="block w-full bg-green-600 text-white text-center px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        Call
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

