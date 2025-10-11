<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FleetVessel extends Model
{
    const FLEET_VESSEL_AVAILABLE = 'available';
    const FLEET_VESSEL_STARTED = 'started';
    const FLEET_VESSEL_PLOTTED = 'plotted';
    const FLEET_VESSEL_DESTROYED = 'destroyed';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fleet_vessels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['fleet_id', 'vessel_id', 'status'];

    /**
     * Retrieve fleet vessel object
     */
    public static function getFleetVessel($fleetVesselId)
    {
        $builder = self::select(
            array(
                'fleet_vessels.id',
                'fleet_vessels.fleet_id',
                'fleet_vessels.vessel_id',
                'fleet_vessels.status',
                'vessels.name as vessel_name',
                'vessels.length',
                'vessels.points'
            )
        )
            ->join('vessels', 'vessels.id', '=', 'fleet_vessels.vessel_id');

        $fleetVessel = $builder
            ->where("fleet_vessels.id", "=", $fleetVesselId);

        if (!isset($fleetVessel) || $fleetVessel->count() <= 0) {
            throw new Exception("Could not find fleet vessel with fleet vessel id '$fleetVesselId'");
        }

        if ($fleetVessel->count() > 1) {
            throw new Exception("More than one fleet vessel with fleet vessel id '$fleetVesselId'");
        }

        return $fleetVessel->get()[0];
    }
    /**
     * Check fleet vessels, are they all plotted
     */
    public static function isFleetReady($fleetId)
    {
        // Check if there are any fleet vessels which aren't in the plotted status
        $results = self::where("fleet_vessels.fleet_id", "=", $fleetId)
            ->where("fleet_vessels.status", "!=", self::FLEET_VESSEL_PLOTTED)->get();

        return (count($results) <= 0);
    }
}