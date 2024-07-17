<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Projects and Teams</h3>
                    @if(isset($projects) && $projects->count())
                        @foreach ($projects as $project)
                            <div class="mt-4">
                                <h4 class="text-md font-semibold text-gray-700">{{ $project->name }}</h4>
                                <p>{{ $project->description }}</p>
                                @foreach ($project->teams as $team)
                                    <div class="mt-4">
                                        <h5 class="text-md font-semibold text-gray-700">{{ $team->name }} - Owner: {{ $team->owner->name }}</h5>
                                        <ul class="list-disc pl-5">
                                            @foreach ($team->users as $user)
                                                <li class="mt-2">
                                                    <div class="font-semibold text-gray-800">
                                                        {{ $user->name }} ({{ $user->email }})
                                                    </div>
                                                    <ul class="list-disc pl-5 ml-4">
                                                        @foreach ($user->tasks as $task)
                                                            <li>{{ $task->name }} - {{ $task->description }}</li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @else
                        <p>No projects found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout><x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Projects and Teams</h3>
                    @if(isset($projects) && $projects->count())
                        @foreach ($projects as $project)
                            <div class="mt-4">
                                <h4 class="text-md font-semibold text-gray-700">{{ $project->name }}</h4>
                                <p>{{ $project->description }}</p>
                                
                                <!-- Add buttons for project actions -->
                                <div class="flex space-x-2 mb-4">
                                    <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-800 disabled:opacity-25 transition">Edit</a>
                                    <a href="{{ route('projects.show', $project) }}" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-800 disabled:opacity-25 transition">View Details</a>
                                </div>

                                @foreach ($project->teams as $team)
                                    <div class="mt-4">
                                        <h5 class="text-md font-semibold text-gray-700">{{ $team->name }} - Owner: {{ $team->owner->name }}</h5>
                                        <ul class="list-disc pl-5">
                                            @foreach ($team->users as $user)
                                                <li class="mt-2">
                                                    <div class="font-semibold text-gray-800">
                                                        {{ $user->name }} ({{ $user->email }})
                                                    </div>
                                                    <ul class="list-disc pl-5 ml-4">
                                                        @foreach ($user->tasks as $task)
                                                            <li>{{ $task->name }} - {{ $task->description }}</li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
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

