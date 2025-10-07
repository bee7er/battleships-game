<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\VerbController;
use App\Http\Controllers\Controller;
use App\Language;
use App\Verb;
use Exception;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

/**
 * Class AdminVerbController
 * @package App\Http\Controllers
 */
class AdminVerbController extends Controller
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
	 * Show the application verb page to the user.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function index(Request $request, $position=null, $filter=null)
	{
		$loggedIn = false;
		if ($this->auth->check()) {
			$loggedIn = true;
		}

		$errors = [];
		$msgs = [];
		$languageCode = self::getCurrentLanguageCode();
		$languages = Language::getLanguages();
		$currentLanguage = self::getCurrentLanguage();

		$verbs = $this->getVerbs($request, $languageCode, trim($position), trim($filter));

		return view('pages.admin.workWithVerbs', compact('position', 'filter', 'currentLanguage',
			'languageCode', 'languages', 'verbs', 'loggedIn', 'errors', 'msgs'));
	}

	/**
	 * Add a verb.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function addVerb(Request $request)
	{
		$loggedIn = false;
		if ($this->auth->check()) {
			$loggedIn = true;
		}

		$errors = [];
		$msgs = [];
		$languageCode = self::getCurrentLanguageCode();
		$languages = Language::getLanguages();
		$currentLanguage = self::getCurrentLanguage();

		$verb = null;
		try {
			$verb = $this->getVerb($request);
			$verb->lang = $languageCode;		// Default to current language

		} catch(Exception $e) {
			Log::notice("Error getting verb: {$e->getMessage()} at {$e->getFile()}, {$e->getLine()}");
			$errors[] = "Error finding verb with id {$request->get('verbId')}";
		}

		$title = "Add Verb";
		$button = "Add";

		return view('pages.admin.editVerb', compact('title', 'button', 'currentLanguage',
			'languageCode', 'languages', 'verb', 'loggedIn', 'errors', 'msgs'));
	}

	/**
	 * Edit a verb.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function editVerb(Request $request)
	{
		$loggedIn = false;
		if ($this->auth->check()) {
			$loggedIn = true;
		}

		$errors = [];
		$msgs = [];
		$languageCode = self::getCurrentLanguageCode();
		$languages = Language::getLanguages();
		$currentLanguage = self::getCurrentLanguage();

		$verb = null;
		try {
			$verb = $this->getVerb($request, $request->get('verbId'));
		} catch(Exception $e) {
			Log::notice("Error getting verb: {$e->getMessage()} at {$e->getFile()}, {$e->getLine()}");
			$errors[] = "Error finding verb with id {$request->get('verbId')}";
		}

		$title = "Edit Verb";
		$button = "Update";
		// We may have navigated here from the play-with function, if so we want to return there.
		$returnToVerb = urlAction();

		return view('pages.admin.editVerb', compact('title', 'button', 'currentLanguage',
			'languageCode', 'languages', 'verb', 'loggedIn', 'returnToVerb', 'errors', 'msgs'));
	}

	/**
	 * Deletes a verb.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function deleteVerb(Request $request)
	{
		$languageCode = self::getCurrentLanguageCode();
		$verb = $pos = $fil = null;
		try {
			$verbId = $request->get('verbId');

			$verb = $this->getVerb($request, $verbId);
			// We will position back to where this entry was
			$pos = $verb->infinitive;
			$fil = '';

			$verb->delete();

		} catch(Exception $e) {
			Log::notice("Error deleting verb: {$e->getMessage()} at {$e->getFile()}, {$e->getLine()}");
		}

		return Redirect::to("/workWithVerbs/$pos/$fil");
	}

	/**
	 * Updates a verb.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function updateVerb(Request $request)
	{
		$loggedIn = false;
		if ($this->auth->check()) {
			$loggedIn = true;
		}

		$errors = [];
		$msgs = [];
		$languageCode = self::getCurrentLanguageCode();
		$languages = Language::getLanguages();
		$currentLanguage = self::getCurrentLanguage();

		$verbId = $request->get('verbId');
		// We may have navigated here from the play-with function, if so we want to return there.
		$returnToVerb = $request->get('returnToVerb');

		$verb = $pos = $fil = null;
		try {
			if (isset($verbId) && is_numeric($verbId) && $verbId > 0) {
				$verb = $this->getVerb($request, $verbId);
				$verb->infinitive = $request->get('infinitive');
				$verb->english = $request->get('english');
				$verb->reflexive = ($request->get('reflexive') == null ? '0': '1');
				$verb->lang = $request->get('language');
				$verb->save();

				$pos = $verb->infinitive;

			} else {
				$verbAry = [
					"infinitive" => $request->get('infinitive'),
					"english" => $request->get('english'),
					"reflexive" => ($request->get('reflexive') == null ? '0': '1'),
					"lang" => $request->get('language'),
				];
				Verb::create($verbAry);

				$pos = $verbAry["infinitive"];
				$fil = '';
			}

		} catch(Exception $e) {
			Log::notice("Error getting verb: {$e->getMessage()} at {$e->getFile()}, {$e->getLine()}");
			$errors[] = "Error finding verb with id {$request->get('verbId')}";

			$title = $request->get('title');
			$button = $request->get('button');

			return view('pages.admin.editVerb', compact('title', 'button', 'currentLanguage',
				'languageCode', 'languages', 'verb', 'loggedIn', 'returnToVerb', 'errors', 'msgs'));
		}

		if ('workWithVerbs' != $returnToVerb) {
			// We have come from the play-with function, return there
			$request->merge(["returnToVerbId" => $verbId]);

			return (new VerbController($this->auth))->index($request);
		}

		return Redirect::to("/workWithVerbs/$pos/$fil");
	}

	/**
	 * Retrieve a verb from the db table
	 */
	private function getVerb(Request $request, $id=null)
	{
		if (null == $id) {
			// Add mode
			return new Verb();
		}

		// Change mode
		return Verb::findOrFail(
			$id,
			array(
				'verbs.id',
				'verbs.infinitive',
				'verbs.english',
				'verbs.reflexive',
				'verbs.lang',
			)
		);
	}

	/**
	 * Retrieve all verbs from the db table
	 */
	private function getVerbs($request, $languageCode, $position=null, $filter=null)
	{
		$builder = Verb::select(
			array(
				'verbs.id',
				'verbs.infinitive',
				'verbs.english',
				'verbs.reflexive',
				'verbs.lang',
			)
		);

		if (null != $position) {
			$builder->where("verbs.infinitive", ">=", $position);
		}

		if (null != $filter) {
			$builder->where("verbs.infinitive", "LIKE", ("%$filter%"));
		}

		$verbs = $builder
			->where("verbs.lang", "=", $languageCode)
			->orderBy('verbs.infinitive')
			->get();

		return $verbs;
	}

}
