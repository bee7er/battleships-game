<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    const GAME_FIRST_NAVAL_BATTLE = '1st naval battle';
    const GAME_SECOND_NAVAL_BATTLE = '2nd naval battle';
    const GAME_THIRD_NAVAL_BATTLE = '3rd naval battle';

    const STATUS_EDIT = 'edit';
    const STATUS_WAITING = 'waiting';
    const STATUS_READY = 'ready';
    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';
    const STATUS_DELETED = 'deleted';

    const STATUS_ARRAY = [self::STATUS_EDIT, self::STATUS_WAITING, self::STATUS_READY, self::STATUS_ACTIVE, self::STATUS_COMPLETED, self::STATUS_DELETED];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'games';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'status', 'protagonist_id', 'opponent_id', 'started_at', 'ended_at', 'deleted_at'];

    /**
     * Retrieve a game
     */
    public static function getGame($id=null)
    {
        if (null == $id) {
            // Add mode
            return new Game();
        }

        $builder = self::select(
            array(
                'games.id',
                'games.name',
                'games.status',
                'games.protagonist_id',
                'games.opponent_id',
                'games.started_at',
                'games.ended_at',
                'games.deleted_at'
            )
        );

        $game = $builder
            ->where("games.id", "=", $id)->get();

        if (isset($game) && count($game) > 0) {
            return $game[0];
        }
        Log::notice("Could not find game for id '$id'");

        return null;
    }

    /**
     * Retrieve all games for the given user, where they created the game and where they
     * have been nominated as an opponent
     *
     * @param $userId
     * @param $showDeletedGames - check whether they have been soft deleted
     * @return mixed
     */
    public static function getGames($userId, $showDeletedGames)
    {
        $builder = self::select(
            array(
                'games.id',
                'games.name',
                'games.protagonist_id',
                'protagonist.name as protagonist_name',
                'games.opponent_id',
                'opponent.name as opponent_name',
                'games.status',
                'games.started_at',
                'games.ended_at',
                'games.deleted_at',
            )
        )
            ->join('users as opponent', 'opponent.id', '=', 'games.opponent_id')
            ->join('users as protagonist', 'protagonist.id', '=', 'games.protagonist_id')
            ->orderBy("games.name");

        if (false == $showDeletedGames) {
            $builder = $builder
                ->where("games.status", "!=", Game::STATUS_DELETED);
        }

        $builder = $builder
            ->where("games.protagonist_id", "=", $userId)
            ->orWhere("games.opponent_id", "=", $userId);

        $games = $builder->get();

        return $games;
    }

    /**
     * Retrieve a game and its joined entities
     */
    public static function getGameDetails($id=null)
    {
        $builder = self::select(
            array(
                'games.id',
                'games.name as game_name',
                'games.protagonist_id',
                'users1.name as protagonist_name',
                'games.opponent_id',
                'users2.name as opponent_name',
                'games.status',
                'games.started_at',
                'games.ended_at',
                'games.deleted_at',
            )
        )
            ->join('users as users1', 'users1.id', '=', 'games.protagonist_id')
            ->join('users as users2', 'users2.id', '=', 'games.opponent_id')
            ->orderBy("games.name");

        $game = $builder
            ->where("games.id", "=", $id);

        if (!isset($game) || $game->count() <= 0) {
            throw new Exception("Could not find game with id '$id'");
        }
        if ($game->count() > 1) {
            throw new Exception("More than one game found with id '$id'");
        }

        return $game->get()[0];
    }

    /**
     * Delete a game
     */
    public function deleteGame()
    {
        $this->status = self::STATUS_DELETED;
        $this->deleted_at = date("Y-m-d H:i:s");
        $this->save();
    }


}