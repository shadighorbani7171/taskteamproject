<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Chat Room') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Edit Chat Room</h3>
                    <form action="{{ route('chats.update', $chatRoom->id) }}" method="POST" class="mt-4">
                        @csrf
                        @method('PUT')
                        <div class="flex">
                            <input type="text" name="name" value="{{ $chatRoom->name }}" class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="Chat Room Name" required>
                        </div>
                        <div class="flex mt-4">
                            <select name="users[]" multiple class="form-select rounded-md shadow-sm mt-1 block w-full" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @if(in_array($user->id, $chatRoom->users->pluck('id')->toArray())) selected @endif>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex mt-4">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
