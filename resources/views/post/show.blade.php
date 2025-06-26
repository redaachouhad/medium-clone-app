<x-app-layout>
    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 pb-10">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                {{-- title of the post --}}
                <h1 class="text-4xl mb-6 font-bold">{{ $post->title }}</h1>

                {{-- User avatar section --}}
                <div class="flex gap-4">
                    <x-user-avatar :user="$post->user" />
                    <x-follower-ctr :user="$post->user" class="flex-col justify-between">
                        <div class="flex gap-2">
                            <a href="{{ route('profile.show', ['user' => $post->user]) }}"
                                class="font-bold hover:underline">{{ $post->user->name }}</a>
                            &middot;
                            @if ($post->user->id !== auth()->user()?->id)
                                <button @click="follow()" :class="following ? 'text-red-500' : 'text-blue-500'"
                                    class="font-bold hover:underline" x-text="following?'Unfollow':'Follow'"></button>
                            @else
                                <span class="text-gray-500">(You're the author)</span>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            <span> {{ $post->readTime() }} min Read</span>
                            &middot;
                            <span>{{ $post->created_at->format('M d, Y') }}</span>
                        </div>
                    </x-follower-ctr>
                </div>

                {{-- User Avatar --}}
                @auth
                    @if (auth()->user()->id === $post->user->id)
                        <div class="pt-4 mt-4 flex flex-row justify-end border-t border-gray-200 gap-2">
                            <a href="{{ route('post.edit', ['post' => $post]) }}">
                                <x-primary-button>Edit
                                    Post</x-primary-button>
                            </a>
                            <form action="{{ route('post.destroy', ['post' => $post]) }}" method="post">
                                @csrf
                                @method('delete')
                                <x-danger-button>Delete Post</x-danger-button>
                            </form>
                        </div>
                    @endif
                @endauth

                {{-- Clap Section --}}
                <x-clap-button :post="$post" />

                {{-- Content Section --}}
                <div class="flex flex-col gap-4 mt-5">
                    @if ($post->imageUrl())
                        <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="w-full rounded-2xl">

                        <div>
                            {{ $post->content }}
                        </div>
                    @endif

                </div>

                {{-- Category --}}
                <div class="py-4  mt-4">
                    <span class="p-2 bg-gray-200 rounded-xl font-medium">{{ $post->category->name }}</span>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
