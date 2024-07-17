<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">{{ $project->name }}</h3>
                    <p>{{ $project->description }}</p>
                    <p><strong>Start Date:</strong> {{ $project->start_date }}</p>
                    <p><strong>End Date:</strong> {{ $project->end_date }}</p>
                    <p><strong>Status:</strong> {{ $project->status }}</p>
                    
                    <h4 class="mt-6 text-md font-semibold text-gray-700">{{ __('Teams') }}</h4>
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

                    <h4 class="mt-6 text-md font-semibold text-gray-700">{{ __('Comments') }}</h4>
                    <ul>
                        @foreach($project->comments as $comment)
                            <li class="mb-2">
                                <strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}
                                <br>
                                @if($comment->url)
                                    <a href="{{ $comment->url }}" class="text-blue-600 underline" target="_blank">View URL</a>
                                @endif
                                @if($comment->file_path)
                                    <a href="{{ Storage::url($comment->file_path) }}" class="text-blue-600 underline" target="_blank">View File</a>
                                @endif
                                <br>
                                <small>{{ $comment->created_at->diffForHumans() }}</small>
                            </li>
                        @endforeach
                    </ul>

                    <form method="POST" action="{{ route('comments.store', $project) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-4">
                            <label for="content" class="block font-medium text-sm text-gray-700">{{ __('Add a comment') }}</label>
                            <textarea id="content" class="form-input rounded-md shadow-sm mt-1 block w-full" name="content" required></textarea>
                        </div>
                        <div class="mt-4">
                            <label for="url" class="block font-medium text-sm text-gray-700">{{ __('URL') }}</label>
                            <input id="url" class="form-input rounded-md shadow-sm mt-1 block w-full" type="url" name="url" />
                        </div>
                        <div class="mt-4">
                            <label for="file" class="block font-medium text-sm text-gray-700">{{ __('File') }}</label>
                            <input id="file" class="form-input rounded-md shadow-sm mt-1 block w-full" type="file" name="file" />
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-800 disabled:opacity-25 transition">
                                {{ __('Post Comment') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
