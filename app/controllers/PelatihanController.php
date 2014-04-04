<?php 

class PelatihanController extends BaseController {

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
		return View::make('pages.pelatihan.index');
	}

	public function store()
	{
        $validator = Validator::make(
			Input::all(),
			array(
				'nama'     => 'required',
		        'nim'      => 'required|numeric|unique:tb_pelatihan_anggota|nim',
		        'tahun_masuk'    => 'required|numeric',
		        'no_hp'    => 'required|numeric',
		        'email'    => 'required|email',
		        'alamat'   => 'required',
		        'divisi'   => 'required',
		        'tingkat'  => 'required',
		        'motivasi' => '',
				'recaptcha_response_field' => 'required|recaptcha',
			)
		);

		if($validator->passes())
		{
			$anggota = new PelatihanAnggota();

			if ($anggota->save()) {
			    return View::make('pages.pelatihan.thanks');
	        } else {
	            return Redirect::action('pelatihan.index')->withErrors($anggota->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
	        }
		}
		else
		{
			return Redirect::action('pelatihan.index')->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
		}
	}
}