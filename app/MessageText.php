<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class MessageText extends Model
{
    const TYPE_SPECIFIC = 'specific';
    const TYPE_BROADCAST = 'broadcast';

    const STATUS_READY = 'ready';
    const STATUS_SENT = 'sent';

    const MESSAGE_INVITE = "Invite player";
    const MESSAGE_ACCEPT = "Accept invitation";
    const MESSAGE_READY = "Game ready";
    const MESSAGE_WAITING = "Waiting";
    const MESSAGE_WINNER = "Winner";
    const MESSAGE_LOSER = "Loser";

    const MESSAGE_BROADCAST_HIT_ANOTHER_GO = "Another go for hit";

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'message_texts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'text', 'type', 'status'];

    /**
     * Find and return the identified message text
     */
    private static function getMessageTextByName($name)
    {
        $message = self::where("message_texts.name", "=", $name);

        return $message->get()[0];
    }

    /**
     * Retrieve message text given the appropriate parameters
     *
     * @param $messageName
     * @param $msgDataAry
     * @return string
     */
    public static function retrieveMessageText($messageName, $msgDataAry)
    {
        $messageText = self::getMessageTextByName($messageName);

        return sprintf($messageText->text, $msgDataAry[0], $msgDataAry[1], $msgDataAry[2]);
    }

    /**
     * Retrieve all messages for the given user
     */
    public static function getMessages($receivingUserId)
    {
        $builder = self::select(
            array(
                'messages.id',
                'messages.message_text',
                'messages.status',
                'messages.sending_user_id',
                'messages.receiving_user_id',
                'messages.read_at',
                'sender.name as sender_name',
                'receiver.name as receiver_name',
            )
        )
            ->join('users as sender', 'sender.id', '=', 'messages.sending_user_id')
            ->join('users as receiver', 'receiver.id', '=', 'messages.receiving_user_id')
            ->orderBy("messages.created_at", "DESC");

        $messages = $builder
            ->where("messages.receiving_user_id", "=", $receivingUserId)
            ->where("messages.status", "=", self::STATUS_OPEN);

        return $messages->get();
    }

    /**
     * Returns any broadcast messages, hwch have not yet been processed
     */
    public static function getNewBroadcastMessages()
    {
        $builder = self::select('*')
            ->where("message_texts.type", "=", self::TYPE_BROADCAST)
            ->where("message_texts.status", "=", self::STATUS_READY);

        return $builder->get();
    }

}