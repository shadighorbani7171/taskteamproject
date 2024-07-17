<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Projects</h3>
                    @if(isset($projects) && $projects->count())
                        @foreach ($projects as $project)
                            <div class="mt-4">
                                <h4 class="text-md font-semibold text-gray-700">{{ $project->name }}</h4>
                                <p>{{ $project->description }}</p>
                                <p><strong>Start Date:</strong> {{ $project->start_date }}</p>
                                <p><strong>End Date:</strong> {{ $project->end_date }}</p>
                                <p><strong>Status:</strong> {{ $project->status }}</p>
                                <div class="flex space-x-2 mb-4">
                                    <a href="{{ route('projects.show', $project) }}" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-800 disabled:opacity-25 transition">View Details</a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No projects found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
