<?php

namespace App\Http\Controllers;

use App\Game;
use App\Fleet;
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

				if (FleetVessel::FLEET_VESSEL_PLOTTED == $fleetVessel['status']) {
					// Are they all plotted?  If so, we set the game to waiting or ready.
					$protagonistReady = FleetVessel::isFleetReady($fleetVessel['fleetId']);
					if ($protagonistReady) {
						$opponentReady = false;
						// Find the opponent's fleet
						$opponentFleet = Fleet::getFleet($fleetVessel['gameId'], $fleetVessel['opponentId']);
						if (isset($opponentFleet) && count($opponentFleet) > 0) {
							$opponentReady = FleetVessel::isFleetReady($opponentFleet->id);
						}
						$game = Game::getGame($fleetVessel['gameId']);
						if ($opponentReady) $game->status = Game::STATUS_READY;
						else $game->status = Game::STATUS_WAITING;
						$game->save();
					}
				}
				$result = 'OK';

			} else {
				$message = "Could not find user with email: " . $request->get(self::VESSEL_ID);
				Log::info('Error: ' . $message);
				$result = 'Error';
			}

		} catch(\Exception $exception) {
			$result = 'Error';
			$message = $exception->getMessage();
			Log::info('Error in setVesselLocation(): ' . $message . ', line: ' . $exception->getLine());
		}

		$returnData = [
			"message" => $message,
			"result" => $result,
			"returnedData" => $fleetVessel
		];

		return $returnData;   // Gets converted to json
	}

	/**
	 * Remove the locations of a vesssel
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function removeVesselLocation(Request $request)
	{
		$message = "Data received OK";
		$result = 'Error';
		$location = Input::all();
		$fleetVessel = null;

		try {
			//$user = User::where('email', $request->get(self::VESSEL_ID))->first();
//			if ($user) {
			if (true) {
				//$user->checkUserToken($request->get(User::USERTOKEN));

				// We update the fleet vessel, returned below
				$fleetVessel = $location['fleetVessel'];
				$fleetVessel['status'] = FleetVesselLocation::deleteLocation($fleetVessel['fleetVesselId'], $location['row'], $location['col']);
				$fleetVessel['locations'] = [];
				// Replace the remaining locations, if any
				$locations = FleetVesselLocation::getFleetVesselLocations($fleetVessel['fleetVesselId']);
				if (isset($locations) && 0 < count($locations)) {
					foreach ($locations as $existingLocation) {
						$fleetVessel['locations'][] = [
							'id' => $existingLocation->id,
							'fleet_vessel_id' => $existingLocation->fleet_vessel_id,
							'row' => $existingLocation->row,
							'col' => $existingLocation->col,
							'vessel_name' => $existingLocation->vessel_name,
						];
					}
				}

				$result = 'OK';

			} else {
				$message = "Could not find user with email: " . $request->get(self::VESSEL_ID);
				Log::info('Error: ' . $message);
				$result = 'Error';
			}

		} catch(\Exception $exception) {
			$result = 'Error';
			$message = $exception->getMessage();
			Log::info('Error in removeVesselLocation(): ' . $message);
		}

		$returnData = [
			"message" => $message,
			"result" => $result,
			"returnedData" => $fleetVessel
		];

		return $returnData;   // Gets converted to json
	}
}
