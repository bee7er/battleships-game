<?php

use App\Game;
use Illuminate\Database\Seeder;
use App\Message;
use App\MessageText;
use App\User;
use Illuminate\Support\Facades\DB;

class MessagesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('messages')->delete();

        $brian = User::where('name', User::USER_BRIAN)->firstOrFail();
        $ben = User::where('name', User::USER_BEN)->firstOrFail();
        $steve = User::where('name', User::USER_STEVE)->firstOrFail();
        $game = Game::where('name', Game::GAME_FIRST_NAVAL_BATTLE)->firstOrFail();
        $game2 = Game::where('name', Game::GAME_SECOND_NAVAL_BATTLE)->firstOrFail();
        $game3 = Game::where('name', Game::GAME_THIRD_NAVAL_BATTLE)->firstOrFail();

        $message = new Message();
        $msgDataAry = [$ben->name, $game->name, $brian->name];
        $message->message_text = MessageText::retrieveMessageText(MessageText::MESSAGE_INVITE, $msgDataAry);
        $message->status = Message::STATUS_OPEN;
        $message->sending_user_id = $brian->id;
        $message->receiving_user_id = $ben->id;
        $message->read_at = null;
        $message->save();

        $message = new Message();
        $msgDataAry = [$brian->name, $game2->name, $ben->name];
        $message->message_text = MessageText::retrieveMessageText(MessageText::MESSAGE_INVITE, $msgDataAry);
        $message->status = Message::STATUS_OPEN;
        $message->sending_user_id = $ben->id;
        $message->receiving_user_id = $brian->id;
        $message->read_at = null;
        $message->save();

        $message = new Message();
        $msgDataAry = [$ben->name, $game3->name, $steve->name];
        $message->message_text = MessageText::retrieveMessageText(MessageText::MESSAGE_INVITE, $msgDataAry);
        $message->status = Message::STATUS_OPEN;
        $message->sending_user_id = $steve->id;
        $message->receiving_user_id = $ben->id;
        $message->read_at = null;
        $message->save();
    }
}
