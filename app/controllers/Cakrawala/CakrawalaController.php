<?php

use HMIF\Model\Cakrawala\Tim;
use HMIF\Model\Cakrawala\User;
use HMIF\Model\Cakrawala\Pembayaran;

class CakrawalaController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter(function($route) {
		    $param = $route->getParameter('lomba');
		    $lomba = array('ITContest', 'Debat', 'LKTI');
		    if(! in_array($param, $lomba) && isset($param)) App::abort(404);
		});
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('pages.cakrawala.index');
	}

	public function pendaftaran()
	{
		// Check if we already logged in
		if (Auth::cakrawala()->check())
		{
		// Redirect to homepage
		return Redirect::route('cakrawala.anggota.index')->with('success', 'Anda sudah masuk sebelumnya.');
		}

		return View::make('pages.cakrawala.pendaftaran')->with(array('pagetitle' => 'Panduan Pendaftaran'));
	}
	
	public function lomba()
	{
		//return Redirect::back();
		if(Auth::cakrawala()->check())
			return Redirect::action('cakrawala.anggota.index');

		return View::make('pages.cakrawala.lomba')->with(array('pagetitle' => 'Daftar Lomba'));
	}

	public function create($lomba)
	{
		$lomba = ($lomba != "ITContest") ? $lomba : "IT Contest";
		//return Redirect::back();
		if(Auth::cakrawala()->check())
			return Redirect::action('cakrawala.anggota.index');

		$tim = new Tim;
		return View::make('pages.cakrawala.form')->with(array('pagetitle' => 'Formulir Pendaftaran', 'lomba' => $lomba, 'tim' => $tim));
	}

	public function store($lomba)
	{
		$lomba = ($lomba != "ITContest") ? $lomba : "IT Contest";
		//return Redirect::back();
		if(Auth::cakrawala()->check())
			return Redirect::action('cakrawala.anggota.index');

		$validator = Validator::make(
			Input::all(),
			array(
				'username'              => 'required|unique:tb_cakrawala_user',
				'email'                 => 'required|email',
				"password"				=> "required|min:8|confirmed",
				"password_confirmation"	=> "same:password",
				
				'nama_tim'              => 'required|unique:tb_cakrawala_kompetisi_tim,nama_tim,NULL,id_tim,lomba,'.$lomba,
				'asal'					=> 'required',
				'alamat'				=> 'required',
				'no_telp'      	  		=> 'required|numeric',
				'nama_pembimbing'		=> 'required',
			)
		);
	
		if($validator->passes())
		{
			$tim = new Tim();
			$tim->lomba = $lomba;
			$user = new User();
			$user->password = Input::get('password');
			if ($tim->save()) {
				if($tim->user()->save($user))
				{
					$pembayaran = new Pembayaran();
					$pembayaran->setNotVerifying();
					$tim->pembayaran()->save($pembayaran);

            		Auth::cakrawala()->login($user);

	            	return Redirect::action('cakrawala.anggota.index')->with('success', 'Berhasil mendaftarkan tim!');
            	}
            	else
            	{
            		$tim->delete();
            		return Redirect::action('cakrawala.create', $lomba)->withErrors($user->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
            	}
	        } else {
	            return Redirect::action('cakrawala.create', $lomba)->withErrors($tim->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
	        }
		}
		else
		{
			return Redirect::action('cakrawala.create', $lomba)->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
		}

	}

	public function pembayaran()
	{
		if (Auth::cakrawala()->guest()) return Redirect::guest('login'); 

		$user = Auth::cakrawala()->user();
		$tim = $user->userable;

		return View::make('pages.cakrawala.pembayaran')->with(array('pagetitle' => 'Pembayaran', 'lomba' => $tim->lomba, 'tim' => $tim));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function store_pembayaran()
	{
		if (Auth::cakrawala()->guest()) return Redirect::guest('login'); 

		$user = Auth::cakrawala()->user();
		$tim = $user->userable;
		$pembayaran = $tim->pembayaran;

		$messages = array(
			'max'    => 'Bukti pembayaran tidak boleh lebih dari 2MB.',
		);

	
		$validator = Validator::make(
			Input::all(),
			array(
				'file_bukti_pembayaran'  => 'required|mimes:zip,jpeg,png|max:2048',
			), $messages
		);

		if($validator->passes())
		{
			$filename = Str::slug($tim->lomba.'_p_'.$tim->id_tim.'_'.$tim->nama_tim);
			$file = new FileManipulation('file_bukti_pembayaran', $filename);
			
			if($file->isUploaded())
			{
				Helper::deleteFile($pembayaran->bukti_bayar);

				$pembayaran->bukti_bayar = $file->getFileName();
				$pembayaran->setWaitVerifying();

				if ($pembayaran->updateUniques()) {
	            	return Redirect::action('cakrawala.pembayaran.edit')->with('success', 'Bukti pembayaran berhasil diupload!');
		        } else {
		            return Redirect::action('cakrawala.pembayaran.edit')->withErrors($pembayaran->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
		        }
	        } else {
	            return Redirect::action('cakrawala.pembayaran.edit')->withErrors($validator)->with('danger', 'Bukti pembayaran gagal diupload!')->withInput();
	        }
	    }
	    else
	    {
	    	return Redirect::action('cakrawala.pembayaran.edit')->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
	    }
	}
}