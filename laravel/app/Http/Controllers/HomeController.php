<?php namespace App\Http\Controllers;

use Input;
use App\Import;
use App\ImportData;
use View;
class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// $this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{

		$imports = Import::all();

		return view('home', array('imports' => $imports));
	}

	public function submit()
	{
		Input::file('fileupload')->move('/home/superdude/Projects/importer_api_spike/laravel/storage/files/', 'import.csv');

		$import = new Import();
		$import->name = 'import_file.csv';
		$import->save();

		$fileHandle = fopen('/home/superdude/Projects/importer_api_spike/laravel/storage/files/import.csv', 'r');

		$import->createFromCSV($fileHandle);

		return $this->index();
	}

	public function entries($id)
	{
		$entries = ImportData::where('import_id', $id)->get();

		return view('entries', array('entries' => $entries));
	}

	public function upload($id)
	{
		
	}

}
