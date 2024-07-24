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
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($users as $user)
                                <li class="py-3 sm:py-4">
                                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                        <div class="flex-shrink-0">
                                            <img class="w-8 h-8 rounded-full" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 truncate dark:text-white">
                                                {{ $user->name }}
                                            </p>
                                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                {{ $user->email }}
                                            </p>
                                        </div>
                                        <a href="{{ route('users.show', $user) }}" class="text-blue-500 underline text-sm font-medium">View</a>
                                    </div>
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
