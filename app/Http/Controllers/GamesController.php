<?php

namespace App\Http\Controllers;

use App\FleetTemplate;
use App\FleetVessel;
use App\FleetVesselLocation;
use App\Game;
use App\Message;
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
			// Check to see if the opponent's fleet exists
			$game->opponent_fleet = Fleet::getFleet($game->id, $game->opponent_id);
		}

		return view('pages.games.games', compact('loggedIn', 'userId', 'games', 'errors', 'msgs'));
	}

	/**
	 * Add a new game.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function addGame(Request $request)
	{
		if (!$this->auth->check()) {
			return redirect()->intended('error');
		}

		$loggedIn = true;
		$userId = $this->auth->user()->id;
		$user = User::getUser($userId);

		$errors = [];
		$msgs = [];

		$game = null;
		try {
			$game = Game::getGame();

		} catch(Exception $e) {
			Log::notice("Error getting game for edit: {$e->getMessage()} at {$e->getFile()}, {$e->getLine()}");
			$errors[] = $e->getMessage();
		}

		$users = User::getUsers($userId);

		return view('pages.games.editGame', compact('loggedIn', 'game', 'user', 'users', 'errors', 'msgs'));
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
		$user = $this->auth->user();
		$gameId = $request->get('gameId');

		$errors = [];
		$msgs = [];

		$game = null;
		try {
			$game = Game::getGame($gameId);
			$opponent = User::getUser($game->opponent_id);

		} catch(Exception $e) {
			Log::notice("Error getting game for edit: {$e->getMessage()} at {$e->getFile()}, {$e->getLine()}");
			$errors[] = $e->getMessage();
		}

		$users = User::getUsers($user->id);

		return view('pages.games.editGame', compact('loggedIn', 'game', 'user', 'opponent', 'users', 'errors', 'msgs'));
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

		$user = $this->auth->user();
		$gameId = intval($request->get('gameId'));
		// Game id is null when in add mode
		$mode = (isset($gameId) && $gameId > 0) ? 'edit': 'add';

		$name = $request->get('gameName');
		try {
			$game = Game::getGame($gameId);
			$game->name = $name;
			if ('add' == $mode) {
				$game->protagonist_id = $user->id;
				$game->opponent_id = $request->get('opponentId');
			}
			$game->save();
			// Check for add mode again for the crfeatio of the fleet
			if ('add' == $mode) {
				// Create a fleet from the template set of vessels for the user creating the game
				Fleet::createFleet($game->id, $user->id);
			}

		} catch(Exception $e) {
			Log::notice("Error updating game: {$e->getMessage()} at {$e->getFile()}, {$e->getLine()}");
		}

		return redirect()->intended('/games');
	}
	/**
	 * Edit the selected game.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function editGrid(Request $request)
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
			$game = Game::getGameDetails($gameId);
			$fleet = Fleet::getFleetDetails($gameId, $userId);
			if (isset($fleet) && count($fleet) > 0) {
				// Just get fleet id from the first fleet vessel entry
				$fleetId = $fleet[0]->id;
			}

		} catch(Exception $e) {
			Log::notice("Error getting game for edit: {$e->getMessage()} at {$e->getFile()}, {$e->getLine()}");
			$errors[] = $e->getMessage();
		}

		$users = User::getUsers($userId);

		return view('pages.games.editGrid', compact('loggedIn', 'game', 'users', 'fleet', 'fleetId', 'errors', 'msgs'));
	}

	/**
	 * Accept the selected game as an opponent.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function acceptGame(Request $request)
	{
		if (!$this->auth->check()) {
			return redirect()->intended('error');
		}

		$userId = $this->auth->user()->id;
		$gameId = $request->get('gameId');

		try {
			// Create a fleet from the template set of vessels for the user accepting the challenge
			Fleet::createFleet($gameId, $userId);

			// Message the protagonist that the game is accepted
			$game = Game::where('id', $gameId)->firstOrFail();
			Message::addMessage($game->opponent_id, $game->protagonist_id, $game->id, Message::MESSAGE_ACCEPT);

		} catch(Exception $e) {
			Log::notice("Error accepting game: {$e->getMessage()} at {$e->getFile()}, {$e->getLine()}");
		}

		return redirect()->intended("/editGrid?gameId=$gameId");
	}
}
