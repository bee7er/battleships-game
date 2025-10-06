<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Fleet;
use App\Game;
use Illuminate\Support\Facades\DB;

class FleetsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('fleets')->delete();

        $brian = User::where('name', User::USER_BRIAN)->firstOrFail();
        $steve = User::where('name', User::USER_STEVE)->firstOrFail();
        $game = Game::where('name', Game::GAME_FIRST_NAVAL_BATTLE)->firstOrFail();

        $fleetTemplate = new Fleet();
        $fleetTemplate->name = Fleet::FLEET_DREADNOUGHT;
        $fleetTemplate->user_id = $brian->id;
        $fleetTemplate->game_id = $game->id;
        $fleetTemplate->save();

        $fleetTemplate = new Fleet();
        $fleetTemplate->name = Fleet::FLEET_VICTORY;
        $fleetTemplate->user_id = $steve->id;
        $fleetTemplate->game_id = $game->id;
        $fleetTemplate->save();

    }

}
