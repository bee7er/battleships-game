<?php

namespace App\Http\Controllers;

use App\FleetVesselLocation;
use App\Game;
use App\User;
use App\Fleet;
use Exception;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class GamesController
 * @package App\Http\Controllers
 */
class GamesController extends Controller
{
	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Show the games created by the current user.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function index(Request $request)
	{
		$loggedIn = true;
		if (!$this->auth->check()) {
			return redirect()->intended('error');
		}

		$userId = $this->auth->user()->id;

		$errors = [];
		$msgs = [];

		// Load the games for the current user
		$games = Game::getGames($userId);
		foreach($games as &$game) {
			// Get the user's fleet for each game
			$game->fleet = Fleet::getFleet($game->id, $userId);
		}

		return view('pages.games.games', compact('loggedIn', 'games', 'errors', 'msgs'));
	}

	/**
	 * Edit the selected game.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function editGame(Request $request)
	{
		if (!$this->auth->check()) {
			return redirect()->intended('error');
		}

		$loggedIn = true;
		$userId = $this->auth->user()->id;
		$gameId = $request->get('gameId');
		$fleetId = 0;

		$errors = [];
		$msgs = [];

		$game = null;
		try {
			$game = Game::getGame($gameId);
			$fleet = Fleet::getFleetDetails($gameId, $userId);
			if (isset($fleet) && count($fleet) > 0) {
				// Just get fleet id from the first fleet vessel entry
				$fleetId = $fleet[0]->id;
			}

		} catch(Exception $e) {
			Log::notice("Error getting game: {$e->getMessage()} at {$e->getFile()}, {$e->getLine()}");
			$errors[] = $e->getMessage();
		}

		$users = User::getUsers($userId);

		return view('pages.games.editGame', compact('loggedIn', 'game', 'users', 'fleet', 'fleetId', 'errors', 'msgs'));
	}

	/**
	 * Update the selected game.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function updateGame(Request $request)
	{
		if (!$this->auth->check()) {
			return redirect()->intended('error');
		}

		$formData = $request->all();

		dd($formData);
	}
}
