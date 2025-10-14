<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Move extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'moves';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['seq', 'game_id', 'player_id', 'row', 'col'];

    /**
     * Retrieve a move
     */
    public static function getMove($id=null)
    {
        $builder = self::select(
            array(
                'moves.id',
                'moves.seq',
                'moves.game_id',
                'moves.player_id',
                'moves.row',
                'moves.col'
            )
        );

        $move = $builder
            ->where("moves.id", "=", $id)->get();

        if (isset($move) && count($move) > 0) {
            return $move[0];
        }
        Log::notice("Could not find move for id '$id'");

        return null;
    }

    /**
     * Retrieve all moves for the given game/user
     *
     * @param $gameId
     * @param $userId
     * @return mixed
     */
    public static function getMoves($gameId, $userId)
    {
        $builder = self::select(
            array(
                'moves.id',
                'moves.seq',
                'moves.game_id',
                'moves.player_id',
                'users.name as player_name',
                'moves.row',
                'moves.col'
            )
        )
            ->join('users', 'users.id', '=', 'moves.player_id')
            ->orderBy("moves.seq");

        $builder = $builder
            ->where("moves.game_id", "=", $gameId)
            ->where("moves.player_id", "=", $userId);

        $moves = $builder->get();

        return $moves;
    }
}