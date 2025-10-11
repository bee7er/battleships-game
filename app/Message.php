<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    const STATUS_OPEN = 'open';
    const STATUS_READ = 'read';

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
            ->where("messages.receiving_user_id", "=", $receivingUserId);

        return $messages->get();
    }

}