<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    const STATUS_OPEN = 'open';
    const STATUS_READ = 'read';

    const MESSAGE_INVITE = "Hi %s, will you play '%s' with me? %s";
    const MESSAGE_ACCEPT = "Hi %s, I will love playing '%s' with you? %s";

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['message_text', 'status', 'sending_user_id', 'receiving_user_id', 'read_at'];

    /**
     * Find and return the identified message
     */
    public static function getMessage($id=null)
    {
        if (null == $id) {
            // Add mode
            return new Message();
        }

        $message = self::where("messages.id", "=", $id);

        return $message->get()[0];
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
     * Add a new message
     *
     * @param $fromUserId
     * @param $toUserId
     * @param $gameId
     * @param $message
     */
    public static function addMessage($fromUserId, $toUserId, $gameId, $message)
    {
        $fromUser = User::getUser($fromUserId);
        $toUser = User::getUser($toUserId);
        $game = Game::getGame($gameId);
        $messageText = sprintf($message, $toUser->name, $game, $fromUser->name);
        $message = Message::getMessage();
        $message->message_text = $messageText;
        $message->status = self::STATUS_OPEN;
        $message->sending_user_id = $fromUserId;
        $message->receiving_user_id = $toUserId;
        $message->save();
    }

}