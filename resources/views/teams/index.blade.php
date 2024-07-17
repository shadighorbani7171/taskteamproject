<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teams') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Teams</h3>
                    @if(isset($teams) && $teams->count())
                        <ul>
                            @foreach ($teams as $team)
                                <li class="mt-4">
                                    <a href="{{ route('teams.show', $team) }}" class="text-blue-600 underline">
                                        {{ $team->name }} - Owner: {{ $team->owner->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No teams found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
