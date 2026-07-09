<!DOCTYPE html>


<html>
<head>

    <title>Chat App</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>

        body{
            background:#f5f5f5;
        }

        .chat-container{
            height:90vh;
            margin-top:20px;
            border-radius:10px;
            overflow:hidden;
            background:white;
            box-shadow:0px 0px 10px rgba(0,0,0,.2);
        }

        .users-section{
            border-right:1px solid #ddd;
            height:90vh;
        }

        .chat-section{
            height:90vh;
        }
        .users-list{
            height:78vh;
            overflow-y:auto;
        }

        .user-item{
            transition:0.3s;
            cursor:pointer;
        }

        .user-item:hover{
            background:#f1f1f1;
        }

        .chat-header{
            height:70px;
            display:flex;
            align-items:center;
            padding-left:20px;
            border-bottom:1px solid #ddd;
            background:white;
        }

        .chat-body{
            height:calc(90vh - 140px);
            overflow-y:auto;
            background:#f8f9fa;
            padding:20px;
        }

        .chat-footer{
            height:70px;
            border-top:1px solid #ddd;
            display:flex;
            align-items:center;
            padding:15px;
            background:white;
        }

    </style>

</head>

<body>

<div class="container-fluid">

    <div class="row chat-container">

       <!-- Left Side -->
<div class="col-md-4 users-section">

    <!-- Logged In User -->
    <div class="p-3 border-bottom bg-white">

    <div class="d-flex align-items-center">

        <img
            src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=0D6EFD&color=fff"
            width="50"
            height="50"
            class="rounded-circle">

        <div class="ms-3">

            <h5 class="mb-0">
                {{ auth()->user()->name }}
            </h5>

            <small class="text-success">
                Online
            </small>

        </div>

    </div>

</div>


<div class="p-3 border-bottom">

    <input
        type="text"
        class="form-control"
        placeholder="Search user...">

</div>

    <!-- Users List -->
    <div class="users-list">

       @foreach($users as $user)

<a href="/chat-app?user={{ $user->id }}"
class="text-decoration-none text-dark">

    <div class="d-flex align-items-center p-3 border-bottom user-item
        @if(isset($receiver) && $receiver && $receiver->id == $user->id)
            bg-primary text-white
        @endif">

        <img
            src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D6EFD&color=fff"
            width="45"
            height="45"
            class="rounded-circle">

        <div class="ms-3">

            <strong>{{ $user->name }}</strong>

            <br>

            <small>
                Click to Chat
            </small>

        </div>

    </div>

</a>

@endforeach

    </div>

</div>

       <div class="col-md-8 chat-section">

    @if($receiver)

        <div class="chat-header">

    <img
        src="https://ui-avatars.com/api/?name={{ $receiver->name }}&background=198754&color=fff"
        width="45"
        height="45"
        class="rounded-circle">

    <div class="ms-3">

        <h5 class="mb-0">
            {{ $receiver->name }}
        </h5>

        <small class="text-success">
            Online
        </small>

    </div>

</div>

        <div class="chat-body" id="chatBody">

    <div id="messages">

        @foreach($messages as $message)

            @if($message->sender_id == auth()->id())

                <div class="text-end mb-2">

                    <span class="btn btn-primary">
                        {{-- {{ $message->message }} --}}
                         @if($message->message_type == 'image')
            <img src="{{ asset('storage/' . $message->message) }}" width="300" height="250">
            @else
                {{ $message->message }}
            @endif
                    </span>

                </div>

            @else

                <div class="text-start mb-2">

                    <span class="btn btn-light border">
                        {{-- {{ $message->message }} --}}
                         @if($message->message_type == 'image')
            <img  src="{{ asset('storage/' . $message->message) }}" width="300" height="250">
            @else
                {{ $message->message }}
            @endif
                    </span>

                </div>

            @endif

        @endforeach

    </div>

</div>

        <form   id="messageForm" method="POST" action="/send-message" enctype="multipart/form-data" class="p-3 border-top">

            @csrf

            <input
                id="receiver_id"
                type="hidden"
                name="receiver_id"
                value="{{ $receiver->id }}"
            >

            <div class="input-group">

                <input
                    id="message"
                    type="text"
                    class="form-control"
                    name="message"
                    placeholder="Type message..."
                >
                
                <input type="file" id="photo" name="photo" hidden>
                <button  class="btn btn-primary" type="button" onclick="document.getElementById('photo').click()">
                Upload Photo
                </button>

                <button class="btn btn-primary"  type="submit">
                    Send

                </button>

            </div>

        </form>

    @else

        <div class="d-flex justify-content-center align-items-center h-100">

            <h3>Select a user to start chatting</h3>

        </div>

    @endif

</div>

    </div>

</div>

<script>

document.querySelector('input[name="message"]').addEventListener('keypress', function(e){

    if(e.key === 'Enter'){

        e.preventDefault();

        this.closest('form').submit();

    }

});

</script>

<script>

let chatBody = document.getElementById('chatBody');

if(chatBody){

    chatBody.scrollTop = chatBody.scrollHeight;

}

</script>

<!-- <script>
const form = document.getElementById("messageForm");

form.addEventListener("submit", function (e) {
    e.preventDefault();
});
</script> -->

<script>
    window.userId = {{ auth()->id() }};

    @if($receiver)
        window.receiverId = {{ $receiver->id }};
    @else
        window.receiverId = null;
    @endif
</script>

<script>
document.getElementById('messageForm').addEventListener('submit', function(event) {

    event.preventDefault();
    console.log("Form Submitted");

    let receiverId = document.getElementById("receiver_id").value;
    let message = document.getElementById("message").value;
    let selectedFile = document.getElementById("photo").files[0];

    let formData = new FormData();

    formData.append("receiver_id", receiverId);

    if (selectedFile) {
        formData.append("photo", selectedFile);
    } else {
        formData.append("message", message);
    }

    // Message ko turant screen par dikhao
    let messages = document.getElementById("messages");

    if (selectedFile) {

        messages.innerHTML += `
            <div class="text-end mb-2">
            <span class= "btn btn-primary">
                <img src="${URL.createObjectURL(selectedFile)}" width="300" height="250">
                </span>
            </div>
        `;

    } else {

        messages.innerHTML += `
            <div class="text-end mb-2">
                <span class="btn btn-primary">
                    ${message}
                </span>
            </div>
        `;

    }

    let chatBody = document.getElementById("chatBody");
    chatBody.scrollTop = chatBody.scrollHeight;

    fetch("/send-message", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => response.text())
    .then(data => {

        document.getElementById("messageForm").reset();

    })
    .catch(error => {
        console.error(error);
        alert("Something went wrong!");
    });

});
</script>
<script>
    
let html = "";

if (message.sender_id == currentUserId) {

    html = `
        <div style="text-align:right;">
            <span  style="background:blue;color:white;padding:10px;border-radius:10px;">
                ${message.message}
            </span>
        </div>
    `;

} else {

    html = `
        <div style="text-align:left;">
            <span style="background:gray;color:white;padding:10px;border-radius:10px;">
                ${message.message}
            </span>
        </div>
    `;

}

document.getElementById("chatBody").innerHTML += html;

</script>
</body>
</html>