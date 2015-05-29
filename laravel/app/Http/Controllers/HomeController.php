<?php namespace App\Http\Controllers;

use Input;
use App\Import;
use App\ImportData;

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
		return view('home');
	}

	public function submit()
	{
		Input::file('fileupload')->move('/home/superdude/Projects/importer_api_spike/laravel/storage/files/', 'import.csv');

		$import = new Import();
		$import->name = 'import_file.csv';
		$import->save();

		$fileHandle = fopen('/home/superdude/Projects/importer_api_spike/laravel/storage/files/import.csv', 'r');

		$file = fgetcsv($fileHandle);

		$importData = new ImportData();
		$importData->createFromCSV($file, $import->id);

		return view('home');
	}

}
