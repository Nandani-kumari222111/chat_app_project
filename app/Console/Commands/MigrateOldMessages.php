<?php

namespace App\Console\Commands;

use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:migrate-old-messages')]
#[Description('Command description')]
class MigrateOldMessages extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
{
    $messages = Message::whereNull('conversation_id')->get();

    foreach ($messages as $message) {

        $conversation = Conversation::whereHas('users', function ($query) use ($message) {
            $query->where('user_id', $message->sender_id);
        })
        ->whereHas('users', function ($query) use ($message) {
            $query->where('user_id', $message->receiver_id);
        })
        ->first();

        if (!$conversation) {

            $conversation = Conversation::create();

            $conversation->users()->attach([
                $message->sender_id,
                $message->receiver_id
            ]);
        }

        $message->update([
            'conversation_id' => $conversation->id
        ]);
    }

    $this->info('Old messages migrated successfully.');
}
}
