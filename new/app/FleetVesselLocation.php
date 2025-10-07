<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FleetVesselLocation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fleet_vessel_locations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['fleet_vessel_id', 'row', 'col'];

    /**
     * Retrieve entire set of fleet vessel location
     */
    public static function getFleetVesselLocationss($fleetVesselId)
    {
        $builder = self::select(
            array(
                'fleet_vessel_locations.id',
                'fleet_vessel_locations.fleet_vessel_id',
                'fleet_vessel_locations.row',
                'fleet_vessel_locations.col',
            )
        )
            ->orderBy("fleet_vessel_locations.row")
            ->orderBy("fleet_vessel_locations.col");

        $fleetVesselLocations = $builder
            ->where("fleet_vessel_locations.fleet_vessel_id", "=", $fleetVesselId);

        return $fleetVesselLocations->get();
    }

}