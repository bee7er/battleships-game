<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Game extends Model
{
    const GAME_FIRST_NAVAL_BATTLE = '1st naval battle';
    const GAME_SECOND_NAVAL_BATTLE = '2nd naval battle';
    const GAME_THIRD_NAVAL_BATTLE = '3rd naval battle';

    const STATUS_EDIT = 'edit';
    const STATUS_WAITING = 'waiting';
    const STATUS_READY = 'ready';
    const STATUS_ENGAGED = 'engaged';
    const STATUS_COMPLETED = 'completed';
    const STATUS_DELETED = 'deleted';
    const STATUS_UNDELETED = 'undeleted';

    const STATUS_ARRAY = [self::STATUS_EDIT, self::STATUS_WAITING, self::STATUS_READY, self::STATUS_ENGAGED, self::STATUS_COMPLETED, self::STATUS_DELETED, self::STATUS_UNDELETED];

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
    protected $fillable = ['name', 'status', 'protagonist_id', 'opponent_id', 'winner_id', 'started_at', 'ended_at', 'deleted_at'];

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
                'games.winner_id',
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
     * Retrieve a game by name
     */
    public static function getGameByName($name)
    {
        return self::select('*')->where("games.name", "=", $name)->get();
    }

    /**
     * Retrieve a unique game name
     */
    public static function getUniqueGameName($name, $gameId)
    {
        $game = self::getGameByName($name);
        // Make it unique
        if (isset($game) && count($game) > 0) {
            if ($game[0]->id == $gameId) {
                // It is unique to the same game
                return $name;
            }
            // Add numbers until we get a unique name
            for ($n=1; $n<25; $n++) {
                $name = $name."_$n";
                $game = self::getGameByName($name);
                if (!isset($game) || count($game) <= 0) {
                    return $name;
                }
            }
            throw new Exception("Could not generate a unique name and gave up.");
        }
        // It is unique
        return $name;
    }

    /**
     * Retrieve all games for the given user, where they created the game and where they
     * have been nominated as an opponent
     *
     * @param $userId
     * @param $showDeletedGames - check whether they have been soft deleted
     * @return mixed
     */
    public static function getGames($userId=null, $showDeletedGames=true)
    {
        $builder = self::select(
            array(
                'games.id',
                'games.name',
                'games.protagonist_id',
                'protagonist.name as protagonist_name',
                'games.opponent_id',
                'opponent.name as opponent_name',
                'games.winner_id',
                'games.status',
                'games.started_at',
                'games.ended_at',
                'games.deleted_at',
            )
        )
            ->leftjoin('users as opponent', 'opponent.id', '=', 'games.opponent_id')
            ->leftjoin('users as protagonist', 'protagonist.id', '=', 'games.protagonist_id')
            ->orderBy("games.name");

        if (false == $showDeletedGames) {
            $builder = $builder
                ->where("games.status", "!=", Game::STATUS_DELETED);
        }

        if (null != $userId) {
            $builder = $builder
                ->where("games.protagonist_id", "=", $userId)
                ->orWhere("games.opponent_id", "=", $userId);
        }

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
                'games.winner_id',
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
     * Check the satatus of the game
     */
    public static function setGameStatus($gameId)
    {
        $game = self::getGame($gameId);
        if (self::STATUS_COMPLETED == $game->status) {
            // The game is already completed, just exit
            return $game->status;
        }

        $gameStatus = self::STATUS_EDIT;
        // If there are any moves, then it has started
        $moves = Move::getMoves($gameId);
        if (isset($moves) && count($moves) > 0) {
            if (1 == count($moves)) {
                // First move, set the game started datetime
                $game->started_at = date('Y-m-d H:i:s');
            }
            $gameStatus = self::STATUS_ENGAGED;

            $protagonistFleet = Fleet::getFleet($gameId, $game->protagonist_id);
            // Check the fleet vessel locations to see if all parts of all vessels have been destroyed
            $isFleetDestroyed = FleetVessel::isFleetDestroyed($protagonistFleet->id);
            if ($isFleetDestroyed) {
                $gameStatus = self::STATUS_COMPLETED;
                $game->winner_id = $game->opponent_id;
                // Notify both parties
                $messageText = MessageText::retrieveMessageText(MessageText::MESSAGE_LOSER,
                    [User::getUser($game->protagonist_id)->name,Game::getGame($game->id)->name,User::systemUser()->name]);
                Message::addMessage($messageText, User::systemUser()->id, $game->protagonist_id);

                $messageText = MessageText::retrieveMessageText(MessageText::MESSAGE_WINNER,
                    [User::getUser($game->opponent_id)->name,Game::getGame($game->id)->name,User::systemUser()->name]);
                Message::addMessage($messageText, User::systemUser()->id, $game->opponent_id);
            } else {
                // Ok, still fighting, check the opponent's fleet
                $opponentFleet = Fleet::getFleet($gameId, $game->opponent_id);
                $isFleetDestroyed = FleetVessel::isFleetDestroyed($opponentFleet->id);
                if ($isFleetDestroyed) {
                    $gameStatus = self::STATUS_COMPLETED;
                    $game->winner_id = $game->protagonist_id;
                    // Notify both parties
                    $messageText = MessageText::retrieveMessageText(MessageText::MESSAGE_LOSER,
                        [User::getUser($game->opponent_id)->name,Game::getGame($game->id)->name,User::systemUser()->name]);
                    Message::addMessage($messageText, User::systemUser()->id, $game->opponent_id);

                    $messageText = MessageText::retrieveMessageText(MessageText::MESSAGE_WINNER,
                        [User::getUser($game->protagonist_id)->name,Game::getGame($game->id)->name,User::systemUser()->name]);
                    Message::addMessage($messageText, User::systemUser()->id, $game->protagonist_id);
                }
            }
            if ($gameStatus == self::STATUS_COMPLETED) {
                // Last move, set the game ended datetime
                $game->ended_at = date('Y-m-d H:i:s');
            }
        } else {
            $protagonistReady = Fleet::isFleetReady($gameId, $game->protagonist_id);
            $opponentReady = Fleet::isFleetReady($gameId, $game->opponent_id);
            if ($protagonistReady && $opponentReady) {
                $gameStatus = self::STATUS_READY;
                // Message the protagonist and the opponent that the game is ready
                $messageText = MessageText::retrieveMessageText(MessageText::MESSAGE_READY,
                    [User::getUser($game->protagonist_id)->name,User::getUser($game->opponent_id)->name,Game::getGame($game->id)->name]);
                Message::addMessage($messageText, User::systemUser()->id, $game->protagonist_id);

                $messageText = MessageText::retrieveMessageText(MessageText::MESSAGE_READY,
                    [User::getUser($game->opponent_id)->name,User::getUser($game->protagonist_id)->name,Game::getGame($game->id)->name]);
                Message::addMessage($messageText, User::systemUser()->id, $game->opponent_id);

            } elseif ($protagonistReady || $opponentReady) {
                $gameStatus = self::STATUS_WAITING;
                // If the protagonist or opponent is not yet started then send them a message
                if ($protagonistReady && Fleet::isFleetNotStarted($game->id, $game->opponent_id)) {
                    $messageText = MessageText::retrieveMessageText(MessageText::MESSAGE_WAITING,
                        [User::getUser($game->opponent_id)->name,User::getUser($game->protagonist_id)->name,Game::getGame($game->id)->name]);
                    Message::addMessage($messageText, User::systemUser()->id, $game->opponent_id);

                } elseif ($opponentReady && Fleet::isFleetNotStarted($game->id, $game->protagonist_id)) {
                    $messageText = MessageText::retrieveMessageText(MessageText::MESSAGE_WAITING,
                        [User::getUser($game->protagonist_id)->name,User::getUser($game->opponent_id)->name,Game::getGame($game->id)->name]);
                    Message::addMessage($messageText, User::systemUser()->id, $game->protagonist_id);
                }
            }
        }

        $game->status = $gameStatus;
        $game->save();
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

    /**
     * Undelete a game
     */
    public function undeleteGame()
    {
        $this->status = self::STATUS_UNDELETED;
        $this->deleted_at = null;
        $this->save();
    }

    /**
     * Get a count of the number of wins by the specified user
     */
    public static function getWinnerCount($userId)
    {
        $wins = self::select('*')
            ->where("games.winner_id", "=", $userId)->get();

        if (isset($wins) && count($wins) > 0) {
            return count($wins);
        }

        return 0;
    }

}