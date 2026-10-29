<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('My Posts') }}</h2>
            <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                {{ __('New post +') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{{ session('status') }}</div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @forelse ($posts as $post)
                        <article class="flex flex-col gap-4 border-b border-gray-200 py-5 first:pt-0 last:border-0 last:pb-0 sm:flex-row sm:items-center sm:justify-between">
                            <div class="min-w-0">
                                <h3 class="font-semibold text-lg">
                                    <a href="{{ route('posts.show', $post) }}" class="hover:text-indigo-700">{{ $post->title }}</a>
                                </h3>
                                <p class="mt-1 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($post->body, 180) }}</p>
                                <p class="mt-2 text-xs text-gray-500">{{ $post->created_at->format('M j, Y') }}</p>
                            </div>
                            <div class="flex shrink-0 items-center gap-4 text-sm">
                                <a href="{{ route('posts.edit', $post) }}" class="text-indigo-700 hover:text-indigo-900">{{ __('Edit') }}</a>
                                <form method="POST" action="{{ route('posts.destroy', $post) }}" onsubmit="return confirm('Delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-700 hover:text-red-900">{{ __('Delete') }}</button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <div class="py-8 text-center">
                            <p class="text-gray-600">{{ __('You have not written any posts yet.') }}</p>
                            <a href="{{ route('posts.create') }}" class="mt-4 inline-block text-sm font-medium text-indigo-700 hover:text-indigo-900">{{ __('Create your first post') }}</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-6">{{ $posts->links() }}</div>
        </div>
    </div>
</x-app-layout>
