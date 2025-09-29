<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if (isset($tag))
                    {{ __('Posts tagged with: ') . $tag->name }}
                @else
                    {{ __('Latest Posts') }}
                @endif
            </h2>
            
            {{-- ปุ่มสำหรับไปหน้าสร้างโพสต์ --}}
            @auth
                <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Create Post') }}
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="space-y-8">
                        @forelse ($posts as $post)
                            <div class="flex flex-col" id="post-{{ $post->id }}">
                                {{-- Post Content --}}
                                <div class="p-4 border rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <p class="font-bold">{{ $post->user->name }}</p>
                                        <p class="ml-2 text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                    </div>
                                    <a href="{{ route('posts.show', $post) }}" class="hover:underline">
                                        <p class="text-gray-800">{{ $post->body }}</p>
                                    </a>
                                    @if ($post->image)
                                        <div class="mt-4">
                                            <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" class="rounded-lg max-w-full lg:max-w-md">
                                        </div>
                                    @endif
                                    <div class="mt-4">
                                        @foreach($post->tags as $tag)
                                            <a href="{{ route('tags.show', $tag) }}" class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2 hover:bg-gray-300">#{{ $tag->name }}</a>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- ส่วนล่างของโพสต์: จำนวนคอมเมนต์ + ปุ่ม --}}
                                <div class="mt-4 flex justify-between items-center text-sm">
                                    <div class="text-gray-500">
                                        {{ $post->comments->count() }} {{ Str::plural('Comment', $post->comments->count()) }}
                                    </div>
                                    <a href="{{ route('posts.show', $post) }}" class="text-indigo-600 hover:underline font-semibold">
                                        View Post & Comments &rarr;
                                    </a>
                                </div>

                                {{-- แสดงคอมเมนต์ --}}
                                @if ($post->comments->count())
                                    <div class="mt-4 space-y-2">
                                        @foreach ($post->comments as $comment)
                                            <div class="p-2 bg-gray-50 rounded-lg text-sm">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <strong>{{ $comment->user->name }}:</strong>
                                                        <p class="inline">{{ $comment->body }}</p>
                                                    </div>
                                                    @can('update', $comment)
                                                        <div class="flex space-x-2 text-xs">
                                                            <a href="{{ route('comments.edit', $comment) }}" class="text-blue-600">Edit</a>
                                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-red-600">Delete</button>
                                                            </form>
                                                        </div>
                                                    @endcan
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-gray-500">No posts available.</p>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
