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

                    <div class="mt-4">
                        <span class="text-sm font-medium text-gray-700">Team Members:</span>
                        <div class="flex items-center">
                            @foreach($task->users as $user)
                                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-full border-2 border-white -ml-2">
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-4">
                        <span class="text-sm font-medium text-gray-700">Project:</span>
                        <p class="text-gray-600">{{ $task->project ? $task->project->name : 'No project assigned' }}</p>
                    </div>

                    <div class="mt-4">
                        <span class="text-sm font-medium text-gray-700">Start Time:</span>
                        <p class="text-gray-600">{{ $task->start_time }}</p>
                    </div>

                    <div class="mt-4">
                        <span class="text-sm font-medium text-gray-700">End Time:</span>
                        <p class="text-gray-600">{{ $task->end_time ?? 'Not set' }}</p>
                    </div>

                    <div class="mt-4">
                        <span class="text-sm font-medium text-gray-700">Status:</span>
                        <p class="text-gray-600">{{ $task->is_completed ? 'Completed' : 'In Progress' }}</p>
                    </div>

                    <div class="mt-4">
                        @if($task->subtasks->count() > 0)
                            <div class="flex items-center">
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                    <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ ($task->subtasks->where('is_completed', true)->count() / $task->subtasks->count()) * 100 }}%"></div>
                                </div>
                                <span class="ml-2 text-gray-600">{{ $task->subtasks->where('is_completed', true)->count() }}/{{ $task->subtasks->count() }}</span>
                            </div>
                        @else
                            <span class="text-gray-600">No subtasks available</span>
                        @endif
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
                                            <strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}
                                            @if($comment->files->count() > 0)
                                                <br>
                                                <strong>Attachments:</strong>
                                                <ul>
                                                    @foreach($comment->files as $file)
                                                        <li><a href="{{ $file->url }}" target="_blank">{{ $file->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="text-lg font-medium text-gray-900">{{ __('Files') }}</h4>
                        <ul>
                            @foreach($task->files as $file)
                                <li>
                                    <a href="{{ $file->url }}" target="_blank">{{ $file->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-6">
                        <form id="uploadForm" action="{{ route('tasks.uploadFolder', $task) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <label for="picker">Select folder to upload:</label>
                            <input type="file" id="picker" webkitdirectory multiple class="mt-2">
                            <input type="submit" value="Upload Folder" name="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">
                        </form>
                    </div>

                    <div class="mt-6">
                        <form id="commentUploadForm" action="{{ route('tasks.addComment', $task) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <label for="commentPicker">Select file to upload with comment:</label>
                            <input type="file" id="commentPicker" multiple class="mt-2">
                            <textarea name="content" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Add a new comment..."></textarea>
                            <input type="submit" value="Add Comment" name="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('picker').addEventListener('change', function(e) {
            const form = document.getElementById('uploadForm');
            const formData = new FormData(form);
            
            for (let i = 0; i < this.files.length; i++) {
                let file = this.files[i];
                formData.append('files[]', file, file.webkitRelativePath);
            }
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(response => {
                  location.reload(); // Reload the page to show the uploaded files
              }).catch(error => {
                  console.error(error);
              });
            
            e.preventDefault();
        });

        document.getElementById('commentPicker').addEventListener('change', function(e) {
            const form = document.getElementById('commentUploadForm');
            const formData = new FormData(form);
            
            for (let i = 0; i < this.files.length; i++) {
                let file = this.files[i];
                formData.append('files[]', file);
            }
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(response => {
                  location.reload(); // Reload the page to show the uploaded files and comments
              }).catch(error => {
                  console.error(error);
              });
            
            e.preventDefault();
        });
    </script>
</x-app-layout>
