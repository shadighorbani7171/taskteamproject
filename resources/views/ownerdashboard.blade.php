<!-- resources/views/ownerdashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Owner Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Your Teams</h3>
                    @if($teams->count())
                        <ul>
                            @foreach ($teams as $team)
                                <li class="mt-2">
                                    <strong>{{ $team->name }}</strong>
                                    <!-- Add more details about the team if needed -->
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No teams found.</p>
                    @endif

                    <h3 class="text-lg font-medium text-gray-900 mt-6">Your Projects</h3>
                    @if($projects->count())
                        <ul>
                            @foreach ($projects as $project)
                                <li class="mt-2">
                                    <strong>{{ $project->name }}</strong>
                                    <p>{{ $project->description }}</p>
                                    <!-- Add more details about the project if needed -->
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
