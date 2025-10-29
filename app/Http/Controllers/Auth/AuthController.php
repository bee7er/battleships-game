<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Guard;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->middleware('guest', ['except' => 'getLogout']);

        $this->auth = $auth;
    }

    /**
     * Show the login page to the user.
     *
     * @param Request $request
     * @return Response
     */
    public function getLogin(Request $request)
    {
        $loggedIn = false;
        if ($this->auth->check()) {
            $loggedIn = true;
        }

        //dd(Hash::make('battle101'));

        $errors = [];
        $msgs = [];

        return view('auth.login', compact('loggedIn', 'errors', 'msgs'));
    }


    /**
     * If valid login show the application dashboard to the user.
     *
     * @param Request $request
     * @return Response
     */
    public function postLogin(Request $request)
    {
        $loggedIn = false;
        if ($this->auth->check()) {
            $loggedIn = true;
        }
        $errors = [];
        $msgs = [];

        if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
            // Authentication passed...
            return redirect()->intended('/home');
        }

        $errors[] = 'Email not found or an incorrect password was used.';
        return view('auth.login', compact('loggedIn', 'errors', 'msgs'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
