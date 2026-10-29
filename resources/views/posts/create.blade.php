<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Write a post') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('posts.store') }}" class="space-y-6">
                    @csrf
                    @include('posts.partials.form')

                    <div class="flex items-center gap-4">
                        <x-primary-button button style="background-color: #3b82f6; border-color: #3b82f6;">{{ __('Publish post') }}</x-primary-button>
                        <a href="{{ route('posts.index') }}" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
