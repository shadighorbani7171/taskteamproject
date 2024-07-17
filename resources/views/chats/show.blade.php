<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat Room: ') . $chatRoom->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="chat-box" id="chat-box" style="max-height: 400px; overflow-y: auto;">
                        @foreach($messages as $message)
                            <div class="message @if($message->user_id == Auth::id()) self @endif">
                                <strong>{{ $message->user->name }}:</strong> {{ $message->message }}
                            </div>
                        @endforeach
                    </div>
                    <form action="{{ route('messages.store', $chatRoom->id) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="flex">
                            <input type="text" name="message" id="chat-message" class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="Write a message" required>
                            <button type="submit" class="ml-4 bg-blue-500 text-white px-4 py-2 rounded-md">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const chatBox = document.getElementById('chat-box');
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    </script>
</x-app-layout>
