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
        $ben = User::where('name', User::USER_BEN)->firstOrFail();
        $steve = User::where('name', User::USER_STEVE)->firstOrFail();
        $game = Game::where('name', Game::GAME_FIRST_NAVAL_BATTLE)->firstOrFail();
        $game2 = Game::where('name', Game::GAME_SECOND_NAVAL_BATTLE)->firstOrFail();
        $game3 = Game::where('name', Game::GAME_THIRD_NAVAL_BATTLE)->firstOrFail();

        $fleet = new Fleet();
        $fleet->name = Fleet::FLEET_DREADNOUGHT;
        $fleet->user_id = $brian->id;
        $fleet->game_id = $game->id;
        $fleet->save();

        $fleet = new Fleet();
        $fleet->name = Fleet::FLEET_VICTORY;
        $fleet->user_id = $ben->id;
        $fleet->game_id = $game2->id;
        $fleet->save();

        $fleet = new Fleet();
        $fleet->name = Fleet::FLEET_DEFAULT_NAME;
        $fleet->user_id = $steve->id;
        $fleet->game_id = $game3->id;
        $fleet->save();

    }

}
