<?php

use App\Game;
use Illuminate\Database\Seeder;
use App\MessageText;
use App\User;
use Illuminate\Support\Facades\DB;

class MessageTextsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('messages')->delete();

        $messageText = new MessageText();
        $messageText->name = MessageText::MESSAGE_INVITE_OWNER;
        $messageText->text = "Hi %s, a game has been created for you by the system called '%s' against opponent '%s'. System";
        $messageText->type = MessageText::TYPE_SPECIFIC;
        $messageText->status = MessageText::STATUS_READY;
        $messageText->save();

        $messageText = new MessageText();
        $messageText->name = MessageText::MESSAGE_INVITE;
        $messageText->text = "Hi %s, will you play '%s' with me? %s";
        $messageText->type = MessageText::TYPE_SPECIFIC;
        $messageText->status = MessageText::STATUS_READY;
        $messageText->save();

        $messageText = new MessageText();
        $messageText->name = MessageText::MESSAGE_ACCEPT;
        $messageText->text = "Hi %s, I will love playing '%s' with you. %s";
        $messageText->type = MessageText::TYPE_SPECIFIC;
        $messageText->status = MessageText::STATUS_READY;
        $messageText->save();

        $messageText = new MessageText();
        $messageText->name = MessageText::MESSAGE_READY;
        $messageText->text = "Hi %s and %s, I'm happy to say that '%s' is ready to play. System";
        $messageText->type = MessageText::TYPE_SPECIFIC;
        $messageText->status = MessageText::STATUS_READY;
        $messageText->save();

        $messageText = new MessageText();
        $messageText->name = MessageText::MESSAGE_WAITING;
        $messageText->text = "Hi %s, %s is waiting for you to finish plotting your fleet in the '%s' game. System";
        $messageText->type = MessageText::TYPE_SPECIFIC;
        $messageText->status = MessageText::STATUS_READY;
        $messageText->save();

        $messageText = new MessageText();
        $messageText->name = MessageText::MESSAGE_WINNER;
        $messageText->text = "Hi %s, you won the '%s' game.  Well done. %s";
        $messageText->type = MessageText::TYPE_SPECIFIC;
        $messageText->status = MessageText::STATUS_READY;
        $messageText->save();

        $messageText = new MessageText();
        $messageText->name = MessageText::MESSAGE_LOSER;
        $messageText->text = "Hi %s, sadly you lost the '%s' game.  Try again later. %s";
        $messageText->type = MessageText::TYPE_SPECIFIC;
        $messageText->status = MessageText::STATUS_READY;
        $messageText->save();

        $messageText = new MessageText();
        $messageText->name = MessageText::MESSAGE_BROADCAST_HIT_ANOTHER_GO;
        $messageText->text = "Hi %s, just to let you know, you now get another go after a successful hit. System";
        $messageText->type = MessageText::TYPE_BROADCAST;
        $messageText->status = MessageText::STATUS_READY;
        $messageText->save();

        $messageText = new MessageText();
        $messageText->name = MessageText::MESSAGE_BROADCAST_VOLUME_RANGE;
        $messageText->text = "Hi %s, there is now a range of volumes to which the sound can be set. System";
        $messageText->type = MessageText::TYPE_BROADCAST;
        $messageText->status = MessageText::STATUS_READY;
        $messageText->save();
    }
}
