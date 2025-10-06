<?php

namespace App\Http\Controllers;

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

		//dd($games);

		return view('pages.games.games', compact('loggedIn', 'games', 'errors', 'msgs'));
	}

	/**
	 * Edit the seleected game.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function editGame(Request $request)
	{
		$loggedIn = true;
		if (!$this->auth->check()) {
			return redirect()->intended('error');
		}

		$userId = $this->auth->user()->id;
		$gameId = $request->get('gameId');

		$errors = [];
		$msgs = [];

		$game = null;
		try {
			$game = Game::getGame($gameId);
			$fleet = Fleet::getFleet($gameId, $userId);
		} catch(Exception $e) {
			Log::notice("Error getting game: {$e->getMessage()} at {$e->getFile()}, {$e->getLine()}");
			$errors[] = $e->getMessage();
		}

		$users = User::getUsers($userId);

		//dd($game);
		//dd($users);
		//dd($fleet);

		return view('pages.games.editGame', compact('loggedIn', 'game', 'users', 'fleet', 'errors', 'msgs'));
	}
}
