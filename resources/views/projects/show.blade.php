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

                    <h4 class="mt-4 text-md font-semibold text-gray-700">Teams</h4>
                    <ul class="list-disc pl-5">
                        @foreach ($project->teams as $team)
                            <li>{{ $team->name }}</li>
                        @endforeach
                    </ul>

                    <h4 class="mt-4 text-md font-semibold text-gray-700">Comments</h4>
                    <ul class="list-disc pl-5">
                        @foreach ($project->comments as $comment)
                            <li>{{ $comment->content }} - <strong>{{ $comment->user->name }}</strong></li>
                        @endforeach
                    </ul>

                    <form action="{{ route('comments.store', $project) }}" method="POST" class="mt-4">
                        @csrf
                        <div>
                            <textarea name="content" rows="3" class="w-full border rounded-md" placeholder="Add a comment..."></textarea>
                            @error('content')
                                <div class="text-red-600">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add Comment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
