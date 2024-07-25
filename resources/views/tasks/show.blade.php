<!-- resources/views/tasks/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white bg-blue-500 p-4 rounded-md shadow-md leading-tight">
            {{ __('Task Details') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-r from-blue-50 via-purple-50 to-pink-50 min-h-screen flex flex-col items-center justify-center relative">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full mx-auto lg:max-w-7xl mb-8">
            <h2 class="text-4xl font-bold text-gray-800 mb-4 text-center">{{ $task->name }}</h2>
            <p class="text-lg text-gray-600 mt-2 text-center">{{ $task->description }}</p>
            
            <div class="flex flex-col lg:flex-row mt-6 space-y-8 lg:space-y-0 lg:space-x-4">
                <!-- Project Information -->
                <div class="w-full lg:w-1/2 lg:flex lg:items-center lg:justify-center -mt-4">
                    <div class="w-full lg:w-4/5 text-left">
                        <h4 class="text-xl font-medium text-gray-900 mb-4">{{ __('Project Information') }}</h4>
                        <table class="min-w-full divide-y divide-gray-200">
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <div class="mt-8">
                                        <h3 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('Team Members') }}</h3>
                                        <div class="flex items-center space-x-4">
                                            @foreach($task->team->users as $user)
                                            <div class="relative group">
                                                <div class="absolute z-10 invisible group-hover:visible px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300 dark:bg-gray-700">
                                                    {{ $user->name }}
                                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                                </div>
                                                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-full border-2 border-white shadow-lg">
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </tr>
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Project</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $task->project ? $task->project->name : 'No project assigned' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Start Time</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $task->start_time }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">End Time</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $task->end_time ?? 'Not set' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Status</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $task->is_completed ? 'Completed' : 'In Progress' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Subtasks with priorities and IDs -->
                <div class="w-full lg:w-1/2 relative lg:pl-8">
                    <div class="absolute top-0 left-0 transform -translate-x-full w-0.5 h-full bg-gray-300"></div> <!-- Line moved to the left side -->
                    <h4 class="text-xl font-medium text-gray-900 mb-4">{{ __('Sub Tasks') }}</h4>
                    @foreach ($task->subtasks as $index => $subtask)
                    <div class="relative z-10 flex items-center mb-8">
                        <div class="flex items-center justify-center w-8 h-8 bg-purple-500 text-white rounded-full">{{ $index + 1 }}</div>
                        <div class="ml-4 text-gray-700">{{ $subtask->name }} with {{ $subtask->user->name }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="bg-white p-8 rounded-lg shadow-lg w-full mx-auto lg:max-w-7xl mb-8">
            <h4 class="text-xl font-medium text-gray-900 mb-4">{{ __('Progress') }}</h4>
            <div class="flex justify-between mb-1">
                <span class="text-base font-medium text-blue-700 dark:text-white">{{ $task->name }}</span>
                <span class="text-sm font-medium text-blue-700 dark:text-white">{{ $task->progress }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $task->progress }}%"></div>
            </div>
        </div>
                <a href="{{ route('tasks.files', $task) }}" class="absolute bottom-4 right-4 bg-orange-500 text-white px-4 py-2 rounded-md">Files</a> <!-- Positioned Files section with URL -->


        <!-- Activity Logs -->
       
</x-app-layout>
