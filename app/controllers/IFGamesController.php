<?php

use IFGTim as Tim;

class IFGamesController extends BaseController {

	public function __construct()
	{
		
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('pages.ifgames.index')->with(array('pagetitle' => 'IF Games'));
	}

	public function pendaftaran()
	{
		return View::make('pages.ifgames.pendaftaran')->with(array('pagetitle' => 'Panduan Pendaftaran - IF Games'));
	}
	
	public function cabang()
	{
		return Redirect::back();
		if(Auth::ifgames()->check())
			return Redirect::action('ifgames.anggota.index');

		$cabang = new IFGCabang;
		return View::make('pages.ifgames.cabang')->with(array('pagetitle' => 'Daftar Cabang - IF Games', 'cabang' => $cabang));
	}

	public function create($cabang)
	{
		return Redirect::back();
		if(Auth::ifgames()->check())
			return Redirect::action('ifgames.anggota.index');

		if($cabang->sisa_kuota() < 1)
			return Redirect::action('ifgames.cabang')->with('warning', 'Kuota telah habis.');		

		$tim = new Tim;
		return View::make('pages.ifgames.form')->with(array('pagetitle' => 'Formulir Pendaftaran - IF Games', 'cabang' => $cabang, 'tim' => $tim));
	}

	public function store($cabang)
	{
		return Redirect::back();
		if(Auth::ifgames()->check())
			return Redirect::action('ifgames.anggota.index');

		if($cabang->sisa_kuota() < 1)
			return Redirect::action('ifgames.cabang')->with('warning', 'Kuota telah habis.');		

		$messages = array(
			
		);

		if($cabang->anggota < 2)
		{
			$validator = Validator::make(
				Input::all(),
				array(
					'username'              => 'required|unique:tb_ifgames_tim',
					"password"				=> "required|min:4|confirmed",
					"password_confirmation"	=> "same:password",
					'nama_peserta'              => 'required|unique:tb_ifgames_tim,nama_tim,NULL,id_tim,id_cabang,'.$cabang->id_cabang,
					'recaptcha_response_field' => 'required|recaptcha',
				), 
				$messages
			);
		}
		else
		{
			$validator = Validator::make(
				Input::all(),
				array(
					'username'              => 'required|unique:tb_ifgames_tim',
					"password"				=> "required|min:4|confirmed",
					"password_confirmation"	=> "same:password",
					'nama_tim'              => 'required|unique:tb_ifgames_tim,nama_tim,NULL,id_tim,id_cabang,'.$cabang->id_cabang,
					'recaptcha_response_field' => 'required|recaptcha',
				),
				$messages
			);
		}

		if($validator->passes())
		{
			$tim = new Tim();
			if($cabang->anggota < 2) $tim->nama_tim = Input::get('nama_peserta');
			$tim->password = Hash::make(Input::get('password'));
			if ($cabang->tim()->save($tim)) {
				
				Auth::ifgames()->login($tim);

				if($cabang->anggota < 2)
	            	return Redirect::action('ifgames.anggota.index')->with('success', 'Berhasil mendaftarkan tim!');
	            else
	            	return Redirect::action('ifgames.anggota.index')->with('success', 'Berhasil mendaftarkan peserta!');
	        } else {
	            return Redirect::action('ifgames.create', $cabang->slug)->withErrors($tim->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
	        }
		}
		else
		{
			return Redirect::action('ifgames.create', $cabang->slug)->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
		}
	}
}