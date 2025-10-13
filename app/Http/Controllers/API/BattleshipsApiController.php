<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Game;
use App\Fleet;
use App\FleetVessel;
use App\FleetVesselLocation;
use App\Message;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

/**
 * Class BattleshipsApiController
 * @package App\Http\Controllers\API
 */
class BattleshipsApiController extends Controller
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
	 * Mark a system message as having been read
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function markAsRead(Request $request)
	{
		$message = "Data received OK";
		$result = 'Error';

		try {
			// User token must be provided and valid for all API calls
			User::checkUserToken($request->get(User::USER_TOKEN));

			$messageId = $request->get('messageId');
			$message = Message::getMessage($messageId);
			$message->status = Message::STATUS_READ;
			$message->save();

			$result = 'OK';

		} catch(\Exception $exception) {
			$result = 'Error';
			$message = $exception->getMessage();
			Log::info('Error in getGameStatus(): ' . $message);
		}

		$returnData = [
			"message" => $message,
			"result" => $result
		];

		return $returnData;   // Gets converted to json
	}

	/**
	 * Get Game current status
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function getGameStatus(Request $request)
	{
		$message = "Data received OK";
		$result = 'Error';
		$gameStatus = 'unknown';

		try {
			// User token must be provided and valid for all API calls
			User::checkUserToken($request->get(User::USER_TOKEN));

			$gameId = $request->get('gameId');
			$game = Game::getGame($gameId);
			$gameStatus = ucfirst($game->status);

			$result = 'OK';

		} catch(\Exception $exception) {
			$result = 'Error';
			$message = $exception->getMessage();
			Log::info('Error in getGameStatus(): ' . $message);
		}

		$returnData = [
			"message" => $message,
			"result" => $result,
			"returnedData" => $gameStatus
		];

		return $returnData;   // Gets converted to json
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
			// User token must be provided and valid for all API calls
			//Log::info('Checking authorisation: ' . $request->get(User::USER_TOKEN));
			User::checkUserToken($request->get(User::USER_TOKEN));

			// Update the fleet vessel status, returned below
			$fleetVessel['status'] =
				FleetVesselLocation::addNewLocation($fleetVessel['fleetVesselId'], $fleetVessel['locations']);

			if (FleetVessel::FLEET_VESSEL_PLOTTED == $fleetVessel['status']) {
				// Are they all plotted?  If so, we set the game to waiting or ready.
				// However, care must be taken because the current user could be either
				// the protagonist or the opponent.
				$game = Game::getGame($fleetVessel['gameId']);
				$protagonistReady = Fleet::isFleetReady($game->id, $game->protagonist_id);
				$opponentReady = Fleet::isFleetReady($game->id, $game->opponent_id);;
				if ($protagonistReady && $opponentReady) {
					$game->status = Game::STATUS_READY;	// Both are ready
					// Message the protagonist and the opponent that the game is eady
					Message::addMessage($game->opponent_id, $game->protagonist_id, $game->id, Message::MESSAGE_READY, '021');
					Message::addMessage($game->protagonist_id, $game->opponent_id, $game->id, Message::MESSAGE_READY, '021');
				} elseif ($protagonistReady || $opponentReady) {
						$game->status = Game::STATUS_WAITING;	// One or other is ready
				}
				$game->save();
			}
			$result = 'OK';

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
			// User token must be provided and valid for all API calls
			User::checkUserToken($request->get(User::USER_TOKEN));

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
