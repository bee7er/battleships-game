<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Game;
use App\Fleet;
use App\FleetVessel;
use App\FleetVesselLocation;
use App\Message;
use App\Move;
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
	 * Save the locations of a vessel
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
				$opponentReady = Fleet::isFleetReady($game->id, $game->opponent_id);
				if ($protagonistReady && $opponentReady) {
					$game->status = Game::STATUS_READY;	// Both are ready
					// Message the protagonist and the opponent that the game is eady
					Message::addMessage($game->opponent_id, $game->protagonist_id, $game->id, Message::MESSAGE_READY, '012');
					Message::addMessage($game->protagonist_id, $game->opponent_id, $game->id, Message::MESSAGE_READY, '012');
				} elseif ($protagonistReady || $opponentReady) {
					$game->status = Game::STATUS_WAITING;
					// If the protagonist or opponent is not yet started then send them a message
					if ($protagonistReady && Fleet::isFleetNotStarted($game->id, $game->opponent_id)) {
						Message::addMessage($game->protagonist_id, $game->opponent_id, $game->id, Message::MESSAGE_WAITING, '102');
					} elseif ($opponentReady && Fleet::isFleetNotStarted($game->id, $game->protagonist_id)) {
						Message::addMessage($game->opponent_id, $game->protagonist_id, $game->id, Message::MESSAGE_WAITING, '102');
					}
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

	/**
	 * Find and return the latest move for the specified user
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function getLatestOpponentMove(Request $request)
	{
		$message = "Data received OK";
		$result = 'Error';
		$returnedData = null;
		$affectedLocations = null;

		try {
			// User token must be provided and valid for all API calls
			User::checkUserToken($request->get(User::USER_TOKEN));

			// We grab the latest move.  If it was by them, we gauge the impact on my fleet.
			$move = Move::getLatestMove($request->get('gameId'));

			if (isset($move) && $move->player_id == $request->get('userId'))
			{
				$locationHit = FleetVessel::getFleetVesselLocationByRowCol($move->row, $move->col, $request->get('fleetId'));
				if (isset($locationHit)) {
					// The strike has hit a vessel at that location.  Get all affected locations.
					$affectedLocations = $this->getAffectedLocations($locationHit);
				}

				$returnedData = [
					'move' => $move,
					'affectedLocations' => $affectedLocations
				];
			}

			$result = 'OK';

		} catch(\Exception $exception) {
			$result = 'Error';
			$message = $exception->getMessage();
			Log::info('Error in getLatestOpponentMove(): ' . $message);
		}

		$returnData = [
			"message" => $message,
			"result" => $result,
			"returnedData" => $returnedData
		];

		return $returnData;   // Gets converted to json
	}

	/**
	 * Strike a vessel location
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function strikeVesselLocation(Request $request)
	{
		$message = "Data received OK";
		$result = 'Error';
		$returnedData = null;
		$affectedLocations = null;

		try {
			// User token must be provided and valid for all API calls
			User::checkUserToken($request->get(User::USER_TOKEN));

			$userId = $request->get('userId');
			$gameId = $request->get('gameId');
			$fleetId = $request->get('fleetId');
			// We save this latest move.
			$move = new Move();
			$move->game_id = $gameId;
			$move->player_id = $userId;
			$move->row = $request->get('row');
			$move->col = $request->get('col');
			$move->save();

			$locationHit = FleetVessel::getFleetVesselLocationByRowCol($move->row, $move->col, $fleetId);

			if (isset($locationHit)) {
				// The strike has hit a vessel at that location.  Get all affected locations.
				$affectedLocations = $this->getAffectedLocations($locationHit);
			}

			// Check if all fleet vessels have been destroyed
			Game::checkGameStatus($gameId, $fleetId);

			$returnedData = [
				'move' => $move,
				'affectedLocations' => $affectedLocations
			];
			$result = 'OK';

		} catch(\Exception $exception) {
			$result = 'Error';
			$message = $exception->getMessage();
			Log::info('Error in strikeVesselLocation(): ' . $message);
		}

		$returnData = [
			"message" => $message,
			"result" => $result,
			"returnedData" => $returnedData
		];

		return $returnData;   // Gets converted to json
	}

	/**
	 * A successful hit, find and returned all affected locations
	 */
	private function getAffectedLocations($locationHit)
	{
		$affectedLocations = [];
		$affectedLocations[] = ['fleetVesselId' => $locationHit->fleet_vessel_id, 'fleetVesselLocationId' => $locationHit->fleet_vessel_location_id,
			'status' => FleetVesselLocation::FLEET_VESSEL_LOCATION_HIT];
		// Update the status at that location
		$fleetVesselLocation = FleetVesselLocation::getFleetVesselLocationById($locationHit->fleet_vessel_location_id);
		$fleetVesselLocation->status = FleetVesselLocation::FLEET_VESSEL_LOCATION_HIT;
		$fleetVesselLocation->save();
		// Have all the vessel parts been hit
		$fleetVesselLocations = FleetVesselLocation::getFleetVesselLocationsByVesselId($fleetVesselLocation->fleet_vessel_id);
		$isDestroyed = true;
		foreach ($fleetVesselLocations as $fvl) {
			if ($fvl->status == FleetVesselLocation::FLEET_VESSEL_LOCATION_NORMAL) {
				$isDestroyed = false;
				break;
			}
		}
		if (true == $isDestroyed) {
			$affectedLocations = [];
			// Update the status of the various parts to to destroyed
			foreach ($fleetVesselLocations as $fvl) {
				$fvl->status = FleetVesselLocation::FLEET_VESSEL_LOCATION_DESTROYED;
				$fvl->save();
				// Save all affected locations
				$affectedLocations[] = ['fleetVesselId' => $fvl->fleet_vessel_id, 'fleetVesselLocationId' => $fvl->id,
					'status' => FleetVesselLocation::FLEET_VESSEL_LOCATION_DESTROYED];
			}
		}

		return $affectedLocations;
	}

	/**
	 * Delete existing locations for each fleet vessel and replace them with those supplied
	 */
	public function replaceFleetVesselLocations(Request $request)
	{
		$message = "Data received OK";
		$result = 'Error';
		$returnedData = null;
		$affectedLocations = null;

		try {
			// User token must be provided and valid for all API calls
			User::checkUserToken($request->get(User::USER_TOKEN));

			$gameId = $request->get('gameId');
			$fleetId = $request->get('fleetId');

			// TODO: Delete existing locations for each fleet vessel
			// Create new locations for each fleet vessel, as supplied


			$returnedData = [

			];
			$result = 'OK';

		} catch(\Exception $exception) {
			$result = 'Error';
			$message = $exception->getMessage();
			Log::info('Error in replaceFleetVesselLocations(): ' . $message);
		}

		$returnData = [
			"message" => $message,
			"result" => $result,
			"returnedData" => $returnedData
		];

		return $returnData;   // Gets converted to json
	}
}
