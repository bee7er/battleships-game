<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(VesselsTableSeeder::class);
        $this->call(GamesTableSeeder::class);
        $this->call(FleetTemplatesTableSeeder::class);
        $this->call(FleetsTableSeeder::class);
        $this->call(FleetVesselsTableSeeder::class);
        $this->call(FleetVesselLocationsTableSeeder::class);

        Model::reguard();
    }
}
