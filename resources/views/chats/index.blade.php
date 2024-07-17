<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chats') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Create New Chat Room</h3>
                    <form action="{{ route('chats.store') }}" method="POST" class="mt-4">
                        @csrf
                        <div class="flex">
                            <input type="text" name="name" class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="Chat Room Name" required>
                        </div>
                        <div class="flex mt-4">
                            <select name="users[]" multiple class="form-select rounded-md shadow-sm mt-1 block w-full" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex mt-4">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Create</button>
                        </div>
                    </form>
                </div>
                <div class="p-6 bg-white border-b border-gray-200 mt-4">
                    <h3 class="text-lg font-medium text-gray-900">Chat Rooms</h3>
                    @if($chatRooms->count())
                        <ul>
                            @foreach ($chatRooms as $chatRoom)
                                <li class="mt-2 flex justify-between items-center">
                                    <span>{{ $chatRoom->name }}</span>
                                    <div>
                                        <a href="{{ route('chats.show', $chatRoom->id) }}" class="ml-4 bg-blue-500 text-white px-4 py-2 rounded-md">Enter Chat Room</a>
                                        <a href="{{ route('chats.edit', $chatRoom->id) }}" class="ml-4 bg-yellow-500 text-white px-4 py-2 rounded-md">Edit</a>
                                        <form action="{{ route('chats.destroy', $chatRoom->id) }}" method="POST" class="inline-block ml-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No chat rooms found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
