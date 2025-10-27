<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use Exception;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
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
	 * Show the application dashboard to the user.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function index(Request $request)
	{
		$loggedIn = false;
		$userToken = '';
		$errors = [];
		$msgs = [];

		if ($this->auth->check()) {
			$loggedIn = true;
			$user = $this->auth->user();
			// We place the user token in the response so it can be obtained
			// by the client and stored in a cookie
			$userToken = $user->user_token;

			$msgs = Message::getMessages($user->id)->toArray();
		}



		return view('pages.home', compact('loggedIn', 'userToken', 'errors', 'msgs'));
	}

	/**
	 * Show the about page to the user.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function about(Request $request)
	{
		$loggedIn = false;
		if ($this->auth->check()) {
			$loggedIn = true;
		}

		$errors = [];
		$msgs = [];

		return view('pages.about', compact('loggedIn', 'errors', 'msgs'));
	}

	/**
	 * Show the profile page to the user.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function profile(Request $request)
	{
		if (!$this->auth->check()) {
			return redirect()->intended('error');
		}

		$loggedIn = true;
		$user = $this->auth->user();

		$errors = [];
		$msgs = [];

		return view('pages.profile', compact('loggedIn', 'user', 'errors', 'msgs'));
	}

	/**
	 * Show the error page to the user.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function error(Request $request)
	{
		$loggedIn = false;
		if ($this->auth->check()) {
			$loggedIn = true;
		}

		$errors = [];
		$msgs = [];

		return view('pages.error', compact('loggedIn', 'errors', 'msgs'));
	}

}
