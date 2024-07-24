<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white bg-blue-500 p-4 rounded-md shadow-md leading-tight">
            {{ __('Task Files and Comments') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-r from-blue-50 via-purple-50 to-pink-50 min-h-screen flex flex-col items-center justify-center relative">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full mx-auto lg:max-w-7xl mb-8">
            <h2 class="text-4xl font-bold text-gray-800 mb-4 text-center">{{ $task->name }}</h2>
            <p class="text-lg text-gray-600 mt-2 text-center">{{ $task->description }}</p>

            <div class="mt-8">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('Comments') }}</h3>
                @foreach($comments as $comment)
                    <div class="mb-4 p-4 border rounded-md bg-gray-50">
                        <p>{{ $comment->content }}</p>
                        <small>by {{ $comment->user->name }} at {{ $comment->created_at }}</small>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('Files') }}</h3>
                @foreach($files as $file)
                    <div class="mb-4 p-4 border rounded-md bg-gray-50">
                        <a href="{{ $file->url }}" target="_blank">{{ $file->name }}</a>
                        <small>uploaded by {{ $file->user->name }} at {{ $file->created_at }}</small>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('Add Comment') }}</h3>
                <form action="{{ route('tasks.addComment', $task) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <textarea name="content" class="w-full p-2 border rounded-md" rows="4" placeholder="Add your comment here..."></textarea>
                    </div>
                    <div class="mb-4">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Submit</button>
                    </div>
                </form>
            </div>

            <div class="mt-8">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('Upload File') }}</h3>
                <form action="{{ route('tasks.uploadFile', $task) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <input type="file" name="file" class="w-full p-2 border rounded-md">
                    </div>
                    <div class="mb-4">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Upload</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="flex space-x-4">
            <a href="{{ route('tasks.show', $task) }}" class="absolute bottom-4 left-4 bg-gray-500 text-white px-4 py-2 rounded-md">Back to Task</a> <!-- Back to Task button -->
        </div>
    </div>
</x-app-layout>
