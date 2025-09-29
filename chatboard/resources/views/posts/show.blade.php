<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- ข้อมูลโพสต์ --}}
                    <div class="pb-6 border-b">
                        <div class="flex items-center mb-2">
                            <p class="font-bold">{{ $post->user->name }}</p>
                            <p class="ml-2 text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>

                            {{-- ปุ่มแก้ไข / ลบ --}}
                            @can('update', $post)
                                <div class="ml-auto flex space-x-2">
                                    <a href="{{ route('posts.edit', $post) }}" class="text-sm text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:underline">Delete</button>
                                    </form>
                                </div>
                            @endcan
                        </div>

                        <p class="text-lg text-gray-800">{{ $post->body }}</p>

                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" class="mt-4 rounded-lg max-w-full lg:max-w-xl">
                        @endif

                        <div class="mt-4">
                            @foreach($post->tags as $tag)
                                <a href="{{ route('tags.show', $tag) }}" class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2 hover:bg-gray-300">#{{ $tag->name }}</a>
                            @endforeach
                        </div>
                    </div>

                    {{-- ฟอร์มคอมเมนต์ --}}
                    @auth
                        <form action="{{ route('posts.comments.store', $post) }}" method="POST" enctype="multipart/form-data" class="mt-6">
                            @csrf
                            <textarea name="body" rows="2" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Add a comment..."></textarea>
                            <div class="mt-2 flex justify-between items-center">
                                <input type="file" name="image" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100"/>
                                <x-primary-button>{{ __('Comment') }}</x-primary-button>
                            </div>
                        </form>
                    @endauth

                    {{-- แสดงคอมเมนต์ --}}
                    <div class="mt-6 space-y-4">
                        <h3 class="text-lg font-semibold">Comments</h3>

                        @forelse ($post->comments as $comment)
                            <div class="p-3 bg-gray-50 rounded-lg text-sm">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p><strong>{{ $comment->user->name }}</strong> 
                                            <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                        </p>
                                        <p>{{ $comment->body }}</p>

                                        @if ($comment->image)
                                            <img src="{{ asset('storage/' . $comment->image) }}" alt="Comment image" class="mt-2 rounded-lg max-w-xs">
                                        @endif
                                    </div>

                                    @can('update', $comment)
                                        <div class="flex space-x-2 text-xs ml-4">
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
                        @empty
                            <p class="text-gray-500">No comments yet.</p>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
