<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Your Teams</h3>
                    @if(isset($teams) && $teams->count())
                        <ul>
                            @foreach ($teams as $team)
                                <li class="mt-2">
                                    <strong>{{ $team->name }}</strong>
                                    <ul class="list-disc pl-5">
                                        @foreach ($team->projects as $project)
                                            <li>{{ $project->name }}</li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>You have no teams assigned.</p>
                    @endif

                    <h3 class="text-lg font-medium text-gray-900 mt-6">Your Tasks</h3>
                    @if(isset($tasks) && $tasks->count())
                        <ul>
                            @foreach ($tasks as $task)
                                <li class="mt-2">
                                    <strong>{{ $task->name }}</strong>
                                    <p>{{ $task->description }}</p>
                                    <p><strong>Team:</strong> {{ optional($task->team)->name }}</p>
                                    <p><strong>Project:</strong> {{ optional($task->project)->name }}</p>
                                    <p><strong>Due Date:</strong> {{ $task->due_date }}</p>
                                    <p><strong>Status:</strong> {{ $task->status }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>You have no tasks assigned.</p>
                    @endif

                    <h3 class="text-lg font-medium text-gray-900 mt-6">Your Projects</h3>
                    @if(isset($projects) && $projects->count())
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
                        <p>You have no projects assigned.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
