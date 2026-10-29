<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Post') }}</h2>
            <div class="flex items-center gap-4">
                <a href="{{ route('posts.edit', $post) }}" class="text-sm text-indigo-700 hover:text-indigo-900">{{ __('Edit') }}</a>
                <a href="{{ route('posts.index') }}" class="text-sm text-gray-600 hover:text-gray-900">{{ __('All posts') }}</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <article class="bg-white p-6 shadow-sm sm:rounded-lg">
                @if (session('status'))
                    <div class="mb-6 rounded-md bg-green-50 p-4 text-sm text-green-800">{{ session('status') }}</div>
                @endif
                <h1 class="text-3xl font-bold text-gray-900">{{ $post->title }}</h1>
                <p class="mt-2 text-sm text-gray-500">{{ $post->created_at->format('M j, Y') }}</p>
                <div class="mt-8 whitespace-pre-line leading-7 text-gray-800">{{ $post->body }}</div>
            </article>
        </div>
    </div>
</x-app-layout>
