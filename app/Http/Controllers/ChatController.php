<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Events\UserTyping;


class ChatController extends Controller
{
    
        

    public function users()
{
    $users = User::where('id', '!=', auth()->id())->get();

    return view('users', compact('users'));
}


public function chat($id)
{
    $receiver = User::findOrFail($id);

    $messages = Message::where(function ($query) use ($id) {

        $query->where('sender_id', auth()->id())
              ->where('receiver_id', $id);

    })->orWhere(function ($query) use ($id) {

        $query->where('sender_id', $id)
              ->where('receiver_id', auth()->id());

    })->orderBy('created_at')->get();

    return view('chat', compact('receiver', 'messages'));
}

private function getConversation($receiverId)
{
    $conversation = Conversation::whereHas('users', function ($query) {
        $query->whereKey(auth()->id());
    })
    ->whereHas('users', function ($query) use ($receiverId) {
        $query->whereKey($receiverId);
    })
    ->first();

    if (! $conversation) {

        $conversation = Conversation::create();

        $conversation->users()->attach([
            auth()->id(),
            $receiverId,
        ]);
    }

    return $conversation;
}

public function sendMessage(Request $request)
{
   //dd($request->all());

   $conversation = $this->getConversation($request->receiver_id);
    if ($request->hasFile('photo')){
        $file = $request->file('photo');
        $path = $file->store('photo', 'public');
        $request->merge(['message' => $path, 'message_type' => 'image']);
    }else{
        $request->merge(['message' => $request->message, 'message_type' => 'text']);
    }

    
    $message = Message::create([
        'conversation_id' => $conversation->id,
        'sender_id' => auth()->id(),
        'receiver_id' => $request->receiver_id,
        'message' => $request->message,
        'message_type' => $request->message_type,
    ]);

    \Log::info('Message Sent: ', ['message' => $message]);

    event(new MessageSent($message));

    return back();
}



public function index(Request $request)
{
    $users = User::where('id', '!=', auth()->id())->get();

    $receiver = null;
    $messages = collect();

    if ($request->user) {

        $receiver = User::findOrFail($request->user);
        $conversation = $this->getConversation($receiver->id);

        $messages = $conversation->messages()
                         ->orderBy('created_at')
                         ->get();
    }

    return view('chat.index', compact('users', 'receiver', 'messages'));
}

public function setOnline()
{
    auth()->user()->update(['is_online' => true]);
    return response()->json(['status' => 'ok']);
}

public function setOffline()
{
    auth()->user()->update(['is_online' => false]);
    return response()->json(['status' => 'ok']);
}

public function typing(Request $request)
{
    event(new UserTyping(
        auth()->id(),
        (int) $request->receiver_id,
        (bool) $request->is_typing
    ));
    return response()->json(['status' => 'ok']);
}

}


