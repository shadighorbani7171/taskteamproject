<!-- resources/views/users/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">{{ $user->name }} ({{ $user->email }})</h3>
                    
                    <div class="mt-4">
                        <h4 class="text-md font-semibold text-gray-700">Teams</h4>
                        <ul class="list-disc pl-5">
                            @forelse ($user->teams as $team)
                                <li>{{ $team->name }}</li>
                            @empty
                                <li>No teams found.</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="mt-4">
                        <h4 class="text-md font-semibold text-gray-700">Tasks</h4>
                        <ul class="list-disc pl-5">
                            @forelse ($user->tasks as $task)
                                <li>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="font-medium text-gray-900">{{ $task->name }}</span>
                                            <span class="text-gray-600">- {{ $task->description }}</span>
                                        </div>
                                        @if($task->project)
                                        <div class="text-sm text-gray-500">
                                            Project: {{ $task->project->name }}
                                        </div>
                                        @endif
                                    </div>
                                </li>
                            @empty
                                <li>No tasks found.</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="mt-4">
                        <h4 class="text-md font-semibold text-gray-700">Projects</h4>
                        <ul class="list-disc pl-5">
                            @forelse ($user->projects as $project)
                                <li>{{ $project->name }} - {{ $project->description }}</li>
                            @empty
                                <li>No projects found.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
