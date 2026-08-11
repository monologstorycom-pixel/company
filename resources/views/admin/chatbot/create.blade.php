<x-admin-layout>
    <x-slot name="title">Create Chatbot Rule</x-slot>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Create New Chatbot Rule</h1>
        <a href="{{ route('admin.chatbot.index') }}" class="text-gray-600 hover:text-gray-900">
            ← Back to Rules
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 max-w-3xl">
        <form action="{{ route('admin.chatbot.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <div>
                    <label for="keyword" class="block text-sm font-medium text-gray-700 mb-2">
                        Keyword <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="keyword" name="keyword" value="{{ old('keyword') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('keyword') border-red-500 @enderror"
                           placeholder="e.g., herbal, price, contact"
                           required>
                    <p class="mt-1 text-xs text-gray-500">The keyword to match in user messages (case-insensitive)</p>
                    @error('keyword')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="response" class="block text-sm font-medium text-gray-700 mb-2">
                        Response <span class="text-red-500">*</span>
                    </label>
                    <textarea id="response" name="response" rows="5"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('response') border-red-500 @enderror"
                              placeholder="The response message to send to users"
                              required>{{ old('response') }}</textarea>
                    @error('response')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                            Response Type <span class="text-red-500">*</span>
                        </label>
                        <select id="type" name="type"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('type') border-red-500 @enderror"
                                required>
                            <option value="text" {{ old('type', 'text') == 'text' ? 'selected' : '' }}>Text</option>
                            <option value="link" {{ old('type') == 'link' ? 'selected' : '' }}>Link</option>
                            <option value="product" {{ old('type') == 'product' ? 'selected' : '' }}>Product Reference</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Type of response to return</p>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                            Priority <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="priority" name="priority" value="{{ old('priority', 1) }}" min="1" max="10"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('priority') border-red-500 @enderror"
                               required>
                        <p class="mt-1 text-xs text-gray-500">Higher priority = checked first (1-10)</p>
                        @error('priority')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select id="status" name="status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('status') border-red-500 @enderror"
                            required>
                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="mt-8 flex gap-4">
                <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                    Create Rule
                </button>
                <a href="{{ route('admin.chatbot.index') }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-600 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>

