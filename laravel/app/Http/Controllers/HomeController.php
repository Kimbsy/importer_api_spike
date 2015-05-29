<?php namespace App\Http\Controllers;

use Input;
use App\Models\Import;
use App\Models\ImportData;
use App\Models\Auth;
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

	public function validateServer()
	{
		$url = 'https://test.trainglos.simitive.com/oauth2/token';
		$data = array('grant_type' => 'client_credentials');

		// use key 'http' even if you send the request to https://...
		$options = array(
		    'http' => array(
		        'header'  => "Content-type: application/x-www-form-urlencoded\r\nAuthorization: Basic c2ltaXRpdmU6c2ltaXRpdmU\r\n",
		        'method'  => 'POST',
		        'content' => http_build_query($data),
		    ),
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		$data = json_decode($result, true);

		$auth = new Auth();
		$auth->access_token = $data['access_token'];
		$auth->save();

		var_dump($result);
	}

	public function upload($id)
	{
		$entry = ImportData::findOrFail($id);
		$entry->unserialise();
		$auth = Auth::findOrFail(1);


		$data = array(
			'name' => $entry->data[0],
			'code' => $entry->data[1],
			'year' => $entry->data[2],
			'status' => $entry->data[3],
		);
		print_r($data);

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'https://test.trainglos.simitive.com/api/wams_department',
			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer {$auth->access_token}",
				'Content-Type: application/json',
				'Accept: application/json',
			),
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => json_encode($data),
		));

		// This works so it's good. NO VERIVISD.
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

		$response = curl_exec($curl);

		if (!$response) {
			die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
		}

		print_r(array('response' => $response));

		curl_close($curl);
	}

}
