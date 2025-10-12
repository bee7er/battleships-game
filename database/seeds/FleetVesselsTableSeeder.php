<?php

use Illuminate\Database\Seeder;
use App\FleetTemplate;
use App\FleetVessel;
use App\Fleet;
use App\Vessel;
use Illuminate\Support\Facades\DB;

class FleetVesselsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('fleet_vessels')->delete();

        $dreadNought = Fleet::where('name', Fleet::FLEET_DREADNOUGHT)->firstOrFail();
        $victory = Fleet::where('name', Fleet::FLEET_VICTORY)->firstOrFail();
        $default = Fleet::where('name', Fleet::FLEET_DEFAULT_NAME)->firstOrFail();

        $vessels = FleetTemplate::select(
            array(
                'vessel_id',
            )
        )->orderBy("id")->get();

        // For each vessel in the template create a fleet vessel for each fleet
        foreach ($vessels as $vessel) {
            $fleetVessel = new FleetVessel();
            $fleetVessel->fleet_id = $dreadNought->id;
            $fleetVessel->vessel_id = $vessel->vessel_id;
            $fleetVessel->status = FleetVessel::FLEET_VESSEL_AVAILABLE;
            $fleetVessel->save();

            $fleetVessel = new FleetVessel();
            $fleetVessel->fleet_id = $victory->id;
            $fleetVessel->vessel_id = $vessel->vessel_id;
            $fleetVessel->status = FleetVessel::FLEET_VESSEL_AVAILABLE;
            $fleetVessel->save();

            $fleetVessel = new FleetVessel();
            $fleetVessel->fleet_id = $default->id;
            $fleetVessel->vessel_id = $vessel->vessel_id;
            $fleetVessel->status = FleetVessel::FLEET_VESSEL_AVAILABLE;
            $fleetVessel->save();
        }

    }

}
