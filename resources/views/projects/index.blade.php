<!-- resources/views/projects/index.blade.php -->
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
                    <h3 class="text-lg font-medium text-gray-900">Project List</h3>
                    @if($projects->count())
                        <ul>
                            @foreach ($projects as $project)
                                <li class="mt-2">
                                    <a href="{{ route('projects.show', $project) }}" class="text-blue-500 underline">{{ $project->name }}</a>
                                    @if($role === 'super_admin' || ($role === 'owner' && $project->teams->contains('owner_id', auth()->id())))
                                        <a href="{{ route('projects.edit', $project) }}" class="text-yellow-500 underline ml-2">Edit</a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No projects found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
