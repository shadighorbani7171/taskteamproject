<!-- resources/views/teams/index.blade.php -->
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
                    <h3 class="text-lg font-medium text-gray-900">Team List</h3>
                    @if($teams->count())
                        <ul>
                            @foreach ($teams as $team)
                                <li class="mt-2">
                                    <a href="{{ route('teams.show', $team) }}" class="text-blue-500 underline">{{ $team->name }}</a>
                                    @if($role === 'super_admin' || ($role === 'owner' && $team->owner_id == auth()->id()))
                                        <a href="{{ route('teams.edit', $team) }}" class="text-yellow-500 underline ml-2">Edit</a>
                                        <form action="{{ route('teams.destroy', $team) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 underline ml-2">Delete</button>
                                        </form>
                                    @endif
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
