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
        $message->message_text = "Hi Dave, will you play '1st naval battle' with me? Brian";
        $message->status = Message::STATUS_OPEN;
        $message->sending_user_id = $brian->id;
        $message->receiving_user_id = $dave->id;
        $message->read_at = null;
        $message->save();

        $message = new Message();
        $message->message_text = "Hi Brian, will you play '2nd naval battle' with me? Steve";
        $message->status = Message::STATUS_OPEN;
        $message->sending_user_id = $steve->id;
        $message->receiving_user_id = $brian->id;
        $message->read_at = null;
        $message->save();

        $message = new Message();
        $message->message_text = "Hi Dave, will you play '3rd naval battle' with me? Steve";
        $message->status = Message::STATUS_OPEN;
        $message->sending_user_id = $steve->id;
        $message->receiving_user_id = $dave->id;
        $message->read_at = null;
        $message->save();
    }
}
