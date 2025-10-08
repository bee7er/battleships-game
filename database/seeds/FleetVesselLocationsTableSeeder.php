<?php

use Illuminate\Database\Seeder;
use App\FleetVesselLocation;
use App\FleetVessel;
use App\Fleet;
use App\Vessel;
use Illuminate\Support\Facades\DB;

class FleetVesselLocationsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('fleet_vessel_locations')->delete();

        $dreadNought = Fleet::where('name', Fleet::FLEET_DREADNOUGHT)->firstOrFail();
        $zodiac = Vessel::where('name', Vessel::VESSEL_TYPE_ZODIAC)->firstOrFail();
        $fleetVessel = FleetVessel::where('fleet_id', $dreadNought->id)
            ->where('vessel_id', $zodiac->id)
            ->firstOrFail();

        $fleetVesselLocation = new FleetVesselLocation();
        $fleetVesselLocation->fleet_vessel_id = $fleetVessel->id;
        $fleetVesselLocation->row = 4;
        $fleetVesselLocation->col = 5;
        $fleetVesselLocation->save();

        $fleetVessel->status = FleetVessel::FLEET_VESSEL_PLOTTED;
        $fleetVessel->save();

    }

}
