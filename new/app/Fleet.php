<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Fleet extends Model
{
    const FLEET_DREADNOUGHT = 'dreadnought';
    const FLEET_VICTORY = 'victory';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fleets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Retrieve fleet object for a user/game combination
     */
    public static function getFleet($gameId, $userId)
    {
        // Change mode
        $builder = self::select(
            array(
                'fleets.id',
                'fleets.name as fleet_name',
                'fleets.user_id',
                'fleets.game_id'
            )
        );

        $fleet = $builder
            ->where("fleets.game_id", "=", $gameId)
            ->where("fleets.user_id", "=", $userId);

        if (!isset($fleet) || $fleet->count() <= 0) {
            throw new Exception("Could not find fleet with game id '$gameId' and user id '$userId'");
        }

        if ($fleet->count() > 1) {
            throw new Exception("More than one fleet with game id '$gameId' and user id '$userId'");
        }

        return $fleet->get()[0];
    }
    
    /**
     * Retrieve entire fleet details for a game
     */
    public static function getFleetDetails($gameId, $userId)
    {
        $builder = self::select(
            array(
                'fleets.id',
                'fleets.name as fleet_name',
                'fleets.user_id',
                'fleets.game_id',
                'users.name as user_name',
                'fleet_vessels.id as fleet_vessel_id',
                'fleet_vessels.status',
                'vessels.name as vessel_name',
                'vessels.length',
                'vessels.points',
            )
        )
            ->join('users', 'users.id', '=', 'fleets.user_id')
            ->join('fleet_vessels', 'fleet_vessels.fleet_id', '=', 'fleets.id')
            ->join('vessels', 'vessels.id', '=', 'fleet_vessels.vessel_id')
            ->orderBy("vessels.points", "DESC")
            ->orderBy("vessels.name");

        $fleet = $builder
            ->where("fleets.user_id", "=", $userId)
            ->where("fleets.game_id", "=", $gameId);

        if (!isset($fleet) || $fleet->count() <= 0) {
            throw new Exception("Could not find fleet with game id '$gameId' and user id '$userId'");
        }

        return $fleet->get();
    }
}