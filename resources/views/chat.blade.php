<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat') }}
        </h2>
    </x-slot>
<p>My ID: {{ auth()->id() }}</p>
<p>Receiver ID: {{ $receiver->id ?? "N/A" }}</p>

<h2>Chat With {{ $receiver->name ?? "N/A" }}</h2>

<hr>

@foreach($messages ?? [] as $message)

    @if($message->sender_id == auth()->id())

        <p>
            <strong>Me:</strong>
            {{ $message->message }}
        </p>

    @else

        <p>
            <strong>{{ $receiver->name ?? "N/A" }}:</strong>
            {{ $message->message }}
        </p>

    @endif

@endforeach

<form method="POST" action="/send-message"  enctype="multipart/form-data">

    @csrf

    <input
        type="hidden"
        name="receiver_id"
        value="{{ $receiver->id ?? '' }}"
    >

    <input
        type="text"
        name="message"
        placeholder="Type Message"
    >
     <input
        type="file"
        name="photo"
    > 
    
    <button type="submit">
        Send
    </button>

</form>
</x-app-layout>