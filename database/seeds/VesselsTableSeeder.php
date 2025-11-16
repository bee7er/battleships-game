<?php

use Illuminate\Database\Seeder;
use App\Vessel;
use Illuminate\Support\Facades\DB;

class VesselsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('vessels')->delete();

//        $vessel = new Vessel();
//        $vessel->name = 'aircraft carrier';
//        $vessel->length = 4;
//        $vessel->points = 7;
//        $vessel->save();

        $vessel = new Vessel();
        $vessel->name = 'battleship';
        $vessel->length = 3;
        $vessel->points = 5;
        $vessel->save();


        $vessel = new Vessel();
        $vessel->name = 'destroyer';
        $vessel->length = 2;
        $vessel->points = 4;
        $vessel->save();


        $vessel = new Vessel();
        $vessel->name = 'submarine';
        $vessel->length = 2;
        $vessel->points = 4;
        $vessel->save();


        $vessel = new Vessel();
        $vessel->name = 'zodiac';
        $vessel->length = 1;
        $vessel->points = 3;
        $vessel->save();

    }

}
