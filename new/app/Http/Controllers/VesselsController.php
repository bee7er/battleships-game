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
		try {

			$message = "Yeah all good";
			$result = 'OK';

			$fleetId = Input::get('fleetId');
			$fleetVesselId = Input::get('fleetVesselId');
			$vesselLength = Input::get('vesselLength');
			$locations = Input::get('locations');

			Log::info('Data' . print_r(Input::all(), true));

//			$user = User::where('email', $request->get(self::VESSEL_ID))->first();
//			if ($user) {
//				$user->checkUserToken($request->get(User::USERTOKEN));
//
//

			$fleetVessel = FleetVessel::where('fleet_vessel_id', $fleetVesselId)
				->firstOrFail();
			$fleetVesselLocations = FleetVesselLocation::getFleetVesselLocationss($fleetVesselId);

			Log::info('Data' . print_r($fleetVesselLocations, true));

//				$result = 'OK';
//
//			} else {
//				// User can only be added by the administrator
//				$message = "Could not find user with email: " . $request->get(self::VESSEL_ID);
//				Log::info('Error: ' . $message);
//				$renderId = 0;
//				$result = 'Error';
//			}

		} catch(\Exception $exception) {
			$result = 'Error';
			$message = $exception->getMessage();
			Log::info('Error in setVesselLocation(): ' . $message);
		}

		$returnData = [
			"message" => $message,
			"result" => $result
		];

		return $returnData;   // Gets converted to json
	}
}
