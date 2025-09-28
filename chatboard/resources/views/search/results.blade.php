<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Search Results for: ') }} <span class="italic">"{{ $query }}"</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($posts->count())
                        <div class="space-y-4">
                            @foreach ($posts as $post)
                                <div class="p-4 border rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <p class="font-bold">{{ $post->user->name }}</p>
                                        <p class="ml-2 text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                    </div>
                                    <a href="{{ route('posts.show', $post) }}" class="hover:underline">
                                        <p>{{ $post->body }}</p>
                                    </a>
                                    @if ($post->image)
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" class="mt-2 rounded-lg max-w-sm">
                                    @endif
                                    <div class="mt-2">
                                        @foreach($post->tags as $tag)
                                            <a href="{{ route('tags.show', $tag) }}" class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#{{ $tag->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $posts->appends(request()->input())->links() }}
                        </div>
                    @else
                        <p>No results found for your search.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>