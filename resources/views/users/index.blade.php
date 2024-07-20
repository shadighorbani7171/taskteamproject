<!-- resources/views/users/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">User List</h3>
                    @if($users->count())
                        <ul>
                            @foreach ($users as $user)
                                <li class="mt-2">
                                    <a href="{{ route('users.show', $user) }}" class="text-blue-500 underline">{{ $user->name }} ({{ $user->email }})</a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No users found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
