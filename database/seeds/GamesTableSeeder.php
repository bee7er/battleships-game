<?php

use Illuminate\Database\Seeder;
use App\Game;
use App\User;
use Illuminate\Support\Facades\DB;

class GamesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('games')->delete();

        $brian = User::where('name', User::USER_BRIAN)->firstOrFail();
        $dave = User::where('name', User::USER_DAVE)->firstOrFail();
        $steve = User::where('name', User::USER_STEVE)->firstOrFail();

        $game = new Game();
        $game->name = Game::GAME_FIRST_NAVAL_BATTLE;
        $game->status = 'edit';
        $game->protagonist_id = $brian->id;
        $game->opponent_id = $dave->id;
        $game->started_at = null;
        $game->ended_at = null;
        $game->save();

        $game = new Game();
        $game->name = Game::GAME_SECOND_NAVAL_BATTLE;
        $game->status = 'edit';
        $game->protagonist_id = $steve->id;
        $game->opponent_id = $brian->id;
        $game->started_at = null;
        $game->ended_at = null;
        $game->save();

        $game = new Game();
        $game->name = Game::GAME_THIRD_NAVAL_BATTLE;
        $game->status = 'edit';
        $game->protagonist_id = $steve->id;
        $game->opponent_id = $dave->id;
        $game->started_at = null;
        $game->ended_at = null;
        $game->save();
    }

}
