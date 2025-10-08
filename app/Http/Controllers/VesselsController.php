<?php

namespace App\Http\Controllers;

use App\FleetVessel;
use App\FleetVesselLocation;
use App\User;
use Exception;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

/**
 * Class VesselsController
 * @package App\Http\Controllers
 */
class VesselsController extends Controller
{

	const VESSEL_ID = "vesselId";

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
		$fleetVessel = Input::all();

		try {
			//$user = User::where('email', $request->get(self::VESSEL_ID))->first();
//			if ($user) {
			if (true) {

				//$user->checkUserToken($request->get(User::USERTOKEN));

				// Update the fleet vessel status, returned below
				$fleetVessel['status'] =
					FleetVesselLocation::addNewLocation($fleetVessel['fleetVesselId'], $fleetVessel['locations']);

				$result = 'OK';

			} else {
				$message = "Could not find user with email: " . $request->get(self::VESSEL_ID);
				Log::info('Error: ' . $message);
				$result = 'Error';
			}

		} catch(\Exception $exception) {
			$result = 'Error';
			$message = $exception->getMessage();
			Log::info('Error in setVesselLocation(): ' . $message);
		}

		$returnData = [
			"message" => $message,
			"result" => $result,
			"returnedData" => $fleetVessel
		];

		return $returnData;   // Gets converted to json
	}
}
