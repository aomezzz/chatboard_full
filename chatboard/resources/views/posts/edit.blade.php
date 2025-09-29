<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="body" class="sr-only">Body</label>
                            <textarea name="body" id="body" rows="4" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('body', $post->body) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="tags" class="block text-sm font-medium text-gray-700">Tags (comma-separated)</label>
                            <input type="text" name="tags" id="tags" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('tags', $post->tags->pluck('name')->implode(', ')) }}">
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700">Change Image</label>
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Current image" class="my-2 max-w-xs rounded">
                            @endif
                            <input type="file" name="image" id="image">
                        </div>
                        
                        <x-primary-button>{{ __('Update Post') }}</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>