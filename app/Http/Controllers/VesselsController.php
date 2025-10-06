<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class VesselsController
 * @package App\Http\Controllers
 */
class VesselsController extends Controller
{

	/**
	 * Create a new filter instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
	}

	/**
	 * Save the locations of a vesssel
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function setVesselLocation(Request $request)
	{
		$message = "Data received OK";
		$result = 'Error';
		try {

			$message = "Yeah all good";
			$result = 'OK';

//			$user = User::where('email', $request->get(self::EMAIL))->first();
//			if ($user) {
//				$user->checkUserToken($request->get(self::USERTOKEN));
//
//
//				$result = 'OK';
//
//			} else {
//				// User can only be added by the administrator
//				$message = "Could not find user with email: " . $request->get(self::EMAIL);
//				Log::info('Error: ' . $message);
//				$renderId = 0;
//				$result = 'Error';
//			}

		} catch(\Exception $exception) {
			$result = 'Error';
			$message = $exception->getMessage();
			Log::info('Error in render(): ' . $message);
		}

		$returnData = [
			"message" => $message,
			"result" => $result
		];

		return $returnData;   // Gets converted to json
	}
}
