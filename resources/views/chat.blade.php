<p>My ID: {{ auth()->id() }}</p>
<p>Receiver ID: {{ $receiver->id }}</p>

<h2>Chat With {{ $receiver->name }}</h2>

<hr>

@foreach($messages as $message)

    @if($message->sender_id == auth()->id())

        <p>
            <strong>Me:</strong>
            {{ $message->message }}
        </p>

    @else

        <p>
            <strong>{{ $receiver->name }}:</strong>
            {{ $message->message }}
        </p>

    @endif

@endforeach

<form method="POST" action="/send-message"  enctype="multipart/form-data">

    @csrf

    <input
        type="hidden"
        name="receiver_id"
        value="{{ $receiver->id }}"
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