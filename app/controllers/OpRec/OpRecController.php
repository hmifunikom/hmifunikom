<?php

use HMIF\Model\Keanggotaan\OpRec as Anggota;

class OpRecController extends BaseController {

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
		return View::make('pages.oprec.index')->with(array('pagetitle' => 'Open Recruitment'));
	}

    public function create()
    {
        return View::make('pages.oprec.form')->with(array('pagetitle' => 'Formulir Open Recruitment'));
    }

	public function store()
    {
        $validator = Validator::make(
			Input::all(),
			array(
                'nim'                      => 'required|numeric|unique:lkmm|nim',
                'nama'                     => 'required',
                'panggilan'                => 'required',
                'jenis_kelamin'            => 'required',
                'tempat_lahir'             => 'required',
                'tanggal_lahir'            => 'required',
                'agama'                    => 'required',
                'alamat'                   => 'required',
                'alamat_ortu'              => 'required',
                'no_hp'                    => 'required|numeric',
                'email'                    => 'required|email',
                'kelas'                    => 'required',
                'angkatan'                 => 'required|numeric',
                'tujuan'                   => 'required',

                'recaptcha_response_field' => 'required|recaptcha',
			)
		);

		if($validator->passes())
		{
			$anggota = new Anggota();

            $organisasi = array (
                array(Input::get('organisasi_tahun')[0], Input::get('organisasi_field')[0]),
                array(Input::get('organisasi_tahun')[1], Input::get('organisasi_field')[1]),
                array(Input::get('organisasi_tahun')[2], Input::get('organisasi_field')[2]),
            );

            $penyakit = array (
                array(Input::get('penyakit_tahun')[0], Input::get('penyakit_field')[0]),
                array(Input::get('penyakit_tahun')[1], Input::get('penyakit_field')[1]),
                array(Input::get('penyakit_tahun')[2], Input::get('penyakit_field')[2]),
            );

            $anggota->organisasi = json_encode($organisasi);
            $anggota->penyakit = json_encode($penyakit);

			if ($anggota->save()) {
                Session::put('nim', Input::get('nim'));
                return Redirect::action('oprec.berkas');
	        } else {
                dd('aa');
	            return Redirect::action('oprec.index')->withErrors($anggota->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();;
	        }
		}
		else
		{
			return Redirect::action('oprec.index')->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
		}
	}

    public function berkas()
    {
        if (!Session::has('nim'))
        {
            return Redirect::action('oprec.index');
        }
        return View::make('pages.oprec.berkas')->with(array('pagetitle' => 'Formulir Open Recruitment'));
    }

    public function berkas_store()
    {
        if (!Session::has('nim')) {
            return Redirect::action('oprec.index');
        }

        $nim = Session::get('nim');

        $messages = array(
            'max' => 'Dokumen tidak boleh lebih dari 2MB.'
        );
        $validator = Validator::make(
            Input::all(),
            array(
                'dokumen' => 'required|mimes:zip|max:2048',
            ), $messages
        );

        if ($validator->passes()) {
            $filename = Str::slug('LKMM-' . $nim);
            $file = new FileManipulation('dokumen', $filename, true, false);

            if ($file->isUploaded()) {
                Session::forget('nim');

                return View::make('pages.oprec.thanks')->with(array('pagetitle' => 'Terimakasih - Open Recruitment'));
            } else {
                return Redirect::action('oprec.berkas')->withErrors($validator)->with('danger', 'Dokumen gagal diupload!')->withInput();
            }
        } else {
            return Redirect::action('oprec.berkas')->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
        }
    }
}