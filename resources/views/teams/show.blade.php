<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Team Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">{{ $team->name }}</h3>
                    <p>Owner: {{ $team->owner->name }}</p>
                    
                    <h4 class="mt-6 text-md font-semibold text-gray-700">{{ __('Members') }}</h4>
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
            </div>
        </div>
    </div>
</x-app-layout>
