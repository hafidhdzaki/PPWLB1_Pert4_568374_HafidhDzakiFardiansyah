<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <x-stat-card label="Projects" :value="$totalProjects" />
                <x-stat-card label="Categories" :value="$totalCategories" color="text-green-600" />
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-lg">{{ __('Project Terbaru') }}</h3>
                        <a href="{{ route('projects.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                            {{ __('Lihat Semua') }}
                        </a>
                    </div>

                    @if ($latestProjects->isEmpty())
                        <p class="text-sm text-gray-500">{{ __('Belum ada project.') }}</p>
                    @else
                        <ul class="divide-y divide-gray-100">
                            @foreach ($latestProjects as $project)
                                <li class="py-2 flex items-center justify-between gap-4">
                                    <a href="{{ route('projects.show', $project->slug) }}" class="text-sm text-gray-800 hover:text-indigo-600">
                                        {{ $project->title }}
                                    </a>
                                    <span class="text-xs text-gray-500">{{ $project->category->name ?? __('Tanpa Kategori') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    @if ($isAdmin)
                        <div class="mt-4">
                            <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                {{ __('+ Tambah Project') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
