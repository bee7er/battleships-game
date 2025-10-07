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
    public static function getFleetVesselLocations($fleetVesselId)
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

    /**
     * Retrieve entire set of fleet vessel location and replace them with
     * the latest set of locations
     *
     * @param $fleetVesselId - id of the fleet vessel
     * @param $locations - array of new locations
     */
    /**
     */
    public static function replaceFleetVesselLocations($fleetVesselId, $locations)
    {
        $fleetVesselLocations = FleetVesselLocation::getFleetVesselLocations($fleetVesselId);
        if (isset($fleetVesselLocations) && 0 < count($fleetVesselLocations)) {
            foreach ($fleetVesselLocations as $fleetVesselLocation) {
                $fleetVesselLocation->delete();
            }
        }
        // Now add the new one(s)
        if (isset($locations) && 0 < count($locations)) {
            foreach ($locations as $location) {
                $fleetVesselLocation = new FleetVesselLocation();
                $fleetVesselLocation->fleet_vessel_id = $fleetVesselId;
                $fleetVesselLocation->row = $location[0];
                $fleetVesselLocation->col = $location[1];
                $fleetVesselLocation->save();
            }
        }

        return true;
    }

}