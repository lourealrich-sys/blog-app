<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Post report') }}</h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('posts.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">{{ __('Back to posts') }}</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 rounded-lg bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                    <form method="GET" action="{{ route('posts.reports.index') }}" class="flex flex-col gap-4 md:flex-row md:items-end">
                        <div>
                            <label for="start_date" class="mb-1 block text-sm font-medium text-gray-700">{{ __('Start date') }}</label>
                            <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label for="end_date" class="mb-1 block text-sm font-medium text-gray-700">{{ __('End date') }}</label>
                            <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-600">
                            {{ __('Apply filters') }}
                        </button>
                    </form>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('posts.reports.pdf', request()->query()) }}" class="inline-flex items-center px-4 py-2 bg-red-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600">
                            {{ __('Download PDF') }}
                        </a>
                        <a href="{{ route('posts.reports.csv', request()->query()) }}" class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600">
                            {{ __('Download CSV') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 flex flex-col gap-2 text-sm text-gray-600 sm:flex-row sm:items-center sm:justify-between">
                        <p>{{ __('Showing :count posts', ['count' => $totalPosts]) }}</p>
                        @if ($startDate || $endDate)
                            <p>{{ __('Date range: :start to :end', ['start' => $startDate ?: 'Earliest', 'end' => $endDate ?: 'Latest']) }}</p>
                        @endif
                    </div>

                    @if ($posts->isEmpty())
                        <div class="py-8 text-center text-gray-600">
                            <p>{{ __('No posts match the selected dates.') }}</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-left">
                                <thead>
                                    <tr class="bg-gray-50 text-sm text-gray-700">
                                        <th class="px-4 py-3 font-semibold">{{ __('ID') }}</th>
                                        <th class="px-4 py-3 font-semibold">{{ __('Title') }}</th>
                                        <th class="px-4 py-3 font-semibold">{{ __('Body') }}</th>
                                        <th class="px-4 py-3 font-semibold">{{ __('Created at') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($posts as $post)
                                        <tr class="text-sm text-gray-700">
                                            <td class="px-4 py-3">{{ $post->id }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $post->title }}</td>
                                            <td class="px-4 py-3 max-w-md">{{ Str::limit($post->body, 120) }}</td>
                                            <td class="px-4 py-3">{{ $post->created_at->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
