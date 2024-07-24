<!-- resources/views/projects/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white bg-blue-500 p-4 rounded-md shadow-md leading-tight text-center">
            {{ __('Projects') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 p-6 min-h-screen flex flex-col items-center justify-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 w-full">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-300">
                <div class="p-6 bg-white border-b border-gray-300 text-center">
                    <h3 class="text-2xl font-medium text-gray-900 mb-6">Project List</h3>
                    @if($projects->count())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($projects as $project)
                                <div class="bg-white p-6 rounded-lg shadow border border-gray-300">
                                    <h2 class="text-xl font-bold mb-2">
                                        <a href="{{ route('projects.show', $project) }}" class="text-blue-500 underline">{{ $project->name }}</a>
                                    </h2>
                                    <p class="text-gray-600 mb-4">{{ $project->teams->count() }} teams</p>
                                  
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-lg text-gray-600">No projects found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
