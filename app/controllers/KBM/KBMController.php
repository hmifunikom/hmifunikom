<?php 

use HMIF\Model\KBM\Anggota as Anggota;

class KBMController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index()
	{
		return View::make('pages.kbm.index')->with(array('pagetitle' => 'Formulir Pendaftaran - KBM'));
	}

	public function store()
	{
        $validator = Validator::make(
			Input::all(),
			array(
				'nama'     => 'required',
		        'nim'      => 'required|numeric|unique:tb_kbm_anggota|nim',
		        'angkatan' => 'required|numeric',
		        'no_hp'    => 'required|numeric',
		        'matkul'   => 'required',
                'g-recaptcha-response'     => 'required|recaptcha'
			)
		);

		if($validator->passes())
		{
			$anggota = new Anggota();

			if ($anggota->save()) {
			    return View::make('pages.kbm.thanks')->with(array('pagetitle' => 'Terimakasih - KBM'));;
	        } else {
	            return Redirect::action('kbm.index')->withErrors($anggota->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
	        }
		}
		else
		{
			return Redirect::action('kbm.index')->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
		}
	}
}