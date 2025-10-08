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
        $fleetVesselLocations = self::select(
            array(
                'fleet_vessel_locations.id',
                'fleet_vessel_locations.fleet_vessel_id',
                'fleet_vessel_locations.row',
                'fleet_vessel_locations.col',
                'fleet_vessels.status as vessel_status',
                'vessels.name as vessel_name',
            )
        )
            ->join('fleet_vessels', 'fleet_vessels.id', '=', 'fleet_vessel_locations.fleet_vessel_id')
            ->join('vessels', 'vessels.id', '=', 'fleet_vessels.vessel_id')
            ->where("fleet_vessel_locations.fleet_vessel_id", "=", $fleetVesselId)
            ->orderBy("fleet_vessel_locations.row")
            ->orderBy("fleet_vessel_locations.col");

//        $fvl = $fleetVesselLocations->get();
//        if (count($fvl) > 0) {
//            dd($fleetVesselLocations->get());
//        }
        return $fleetVesselLocations->get();
    }

    /**
     * Examines all locations for the fleet vessel and saves any new ones
     *
     * @param $fleetVesselId - id of the fleet vessel
     * @param $locations - array of new locations
     */
    public static function addNewLocation($fleetVesselId, &$locations)
    {
        if (isset($locations) && 0 < count($locations)) {
            foreach ($locations as &$location) {
                if (0 == $location['id']) {
                    $fleetVesselLocation = new FleetVesselLocation();
                    $fleetVesselLocation->fleet_vessel_id = $fleetVesselId;
                    $fleetVesselLocation->row = $location['row'];
                    $fleetVesselLocation->col = $location['col'];
                    $fleetVesselLocation->save();
                    // Populate the returned location
                    $location['id'] = $fleetVesselLocation->id;
                }
            }
        }
        // Get the fleet vessel object, and set the status if it is fully plotted
        $fleetVessel = FleetVessel::getFleetVessel($fleetVesselId);
        if (count($locations) >= $fleetVessel->length) {
            $fleetVessel->status = FleetVessel::FLEET_VESSEL_PLOTTED;
        } else {
            $fleetVessel->status = FleetVessel::FLEET_VESSEL_STARTED;
        }
        $fleetVessel->save();

        return $fleetVessel->status;
    }

}