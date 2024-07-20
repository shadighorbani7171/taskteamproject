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
                            @foreach ($user->teams as $team)
                                <li>{{ $team->name }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-4">
                        <h4 class="text-md font-semibold text-gray-700">Tasks</h4>
                        <ul class="list-disc pl-5">
                            @foreach ($user->tasks as $task)
                                <li>{{ $task->name }} - {{ $task->description }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
