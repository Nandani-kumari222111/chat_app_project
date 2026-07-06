<h2>Users List</h2>

@foreach($users as $user)

    <div>
        <a href="/chat/{{ $user->id }}">
            {{ $user->name }}
        </a>
    </div>

@endforeach