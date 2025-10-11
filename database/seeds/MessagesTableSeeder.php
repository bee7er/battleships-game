<?php

use Illuminate\Database\Seeder;
use App\Message;
use App\User;
use Illuminate\Support\Facades\DB;

class MessagesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('messages')->delete();

        $brian = User::where('name', User::USER_BRIAN)->firstOrFail();
        $dave = User::where('name', User::USER_DAVE)->firstOrFail();
        $steve = User::where('name', User::USER_STEVE)->firstOrFail();

        $message = new Message();
        $message->message_text = 'Hi Dave, will you play a game with me?';
        $message->status = Message::STATUS_OPEN;
        $message->sending_user_id = $brian->id;
        $message->receiving_user_id = $dave->id;
        $message->read_at = null;
        $message->save();

        $message = new Message();
        $message->message_text = 'well hello you';
        $message->status = Message::STATUS_OPEN;
        $message->sending_user_id = $brian->id;
        $message->receiving_user_id = $steve->id;
        $message->read_at = null;
        $message->save();

        $message = new Message();
        $message->message_text = 'Hi Bri, yes I would love to play a game with you.';
        $message->status = Message::STATUS_OPEN;
        $message->sending_user_id = $dave->id;
        $message->receiving_user_id = $brian->id;
        $message->read_at = null;
        $message->save();
    }
}
