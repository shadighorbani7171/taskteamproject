<!-- resources/views/teams/show.blade.php -->
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
                    <p><strong>Owner:</strong> {{ $team->owner->name }}</p>

                    <h4 class="mt-6 text-md font-semibold text-gray-700">Members</h4>
                    <ul>
                        @foreach ($team->users as $user)
                            <li>{{ $user->name }} ({{ $user->email }})</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
