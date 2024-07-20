<!-- resources/views/tasks/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">{{ $task->name }}</h3>
                    <p class="text-gray-600">{{ $task->description }}</p>

                    <div class="flex items-center mt-4">
                        @foreach($task->users as $user)
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-full border-2 border-white -ml-2">
                        @endforeach
                        <button class="bg-gray-200 text-gray-800 px-2 py-1 rounded-full ml-2">+</button>
                    </div>

                    <div class="mt-4">
                        @if($task->total_subtasks > 0)
                            <div class="flex items-center">
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                    <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ ($task->completed_subtasks / $task->total_subtasks) * 100 }}%"></div>
                                </div>
                                <span class="ml-2 text-gray-600">{{ $task->completed_subtasks }}/{{ $task->total_subtasks }}</span>
                            </div>
                        @else
                            <span class="text-gray-600">No subtasks available</span>
                        @endif
                        <span class="text-sm text-gray-500">Due in {{ $task->due_time }}</span>
                    </div>

                    <div class="mt-6">
                        <div class="flex space-x-4">
                            <button class="text-gray-600 border-b-2 border-gray-800 pb-1">Tasks</button>
                            <button class="text-gray-600 pb-1">Files</button>
                            <button class="text-gray-600 pb-1">Activity</button>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="text-lg font-medium text-gray-900">{{ __('Comments') }}</h4>
                        <div>
                            @foreach($task->comments as $comment)
                                <div class="flex items-start mt-4">
                                    <img src="{{ $comment->user->profile_photo_url }}" alt="{{ $comment->user->name }}" class="w-10 h-10 rounded-full">
                                    <div class="ml-4">
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium text-gray-900">{{ $comment->user->name }}</span> 
                                            {{ $comment->content }}
                                            @if($comment->file_path)
                                                <a href="{{ Storage::url($comment->file_path) }}" target="_blank" class="text-blue-500 underline">View File</a>
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-6">
                        <form method="POST" action="{{ route('tasks.addComment', $task) }}" enctype="multipart/form-data">
                            @csrf
                            <textarea name="content" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Add a new comment..."></textarea>
                            <input type="file" name="file" class="mt-2">
                            <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Add Comment</button>
                        </form>
                    </div>

                    <div class="mt-6">
                        <form method="POST" action="{{ route('tasks.complete', $task) }}">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Complete Task</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
