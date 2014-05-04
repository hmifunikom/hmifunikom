<?php

use CakrawalaKompetisiTim as Tim;
use CakrawalaUser as User;

class PanelCakrawalaKompetisiTimController extends BaseController {

	private $tim;

	public function __construct(CakrawalaKompetisiTimRepo $tim)
	{
		$this->beforeFilter(function($route) {
		    $param = $route->getParameter('kompetisi');
		    $lomba = array('IT Contest', 'Debat', 'LKTI');
		    if(! in_array($param, $lomba)) App::abort(404);
		});

		$this->tim = $tim;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($lomba)
	{
		$tim = $this->tim->findByLomba($lomba);
		return View::make('panel.pages.cakrawala.kompetisi.tim.index')->with(array('lomba' => $lomba, 'listtim' => $tim));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($lomba)
	{
		$tim = new Tim;
		return View::make('panel.pages.cakrawala.kompetisi.tim.form')->with(array('method' => 'create', 'lomba' => $lomba, 'tim' => $tim));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($lomba)
	{
		$validator = Validator::make(
			Input::all(),
			array(
				'username'              => 'required|unique:tb_cakrawala_user',
				"password"				=> "required|min:4|confirmed",
				"password_confirmation"	=> "required|same:password",
				
				'nama_tim'              => 'required|unique:tb_cakrawala_kompetisi_tim,nama_tim,NULL,id_tim,lomba,'.$lomba,
				'kategori'				=> 'required',
				'asal'					=> 'required',
				'alamat'				=> 'required',
				'nama_pembimbing'		=> 'required',
			)
		);
	
		if($validator->passes())
		{
			$tim = new Tim();
			$tim->lomba = $lomba;
			if($lomba == 'LKTI') $tim->kategori = 'SMA';
			$user = new User();
			$user->password = Hash::make(Input::get('password'));
			if ($tim->save()) {
				$user->save();
				if($tim->user()->save($user))
				{
            		return Redirect::action('panel.cakrawala.kompetisi.tim.index', $lomba)->with('success', 'Peserta berhasil ditambah!');
            	}
	        } else {
	        	
	            return Redirect::action('panel.cakrawala.kompetisi.tim.create', $lomba)->withErrors($tim->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
	        }
		}
		else
		{
			return Redirect::action('panel.cakrawala.kompetisi.tim.create', $lomba)->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($lomba, $tim)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($lomba, $tim)
	{
		return View::make('panel.pages.cakrawala.kompetisi.tim.form')->with(array('method' => 'edit', 'lomba' => $lomba, 'tim' => $tim));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($lomba, $tim)
	{
		if(Input::has('password'))
		{
			$validator = Validator::make(
				Input::all(),
				array(
					'username'              => 'required|unique:tb_cakrawala_kompetisi_tim,username,'.$tim->id_tim.',id_tim',
					"password"				=> "required|min:4|confirmed",
					"password_confirmation"	=> "same:password",

					'nama_tim'              => 'required|unique:tb_cakrawala_kompetisi_tim,nama_tim,'.$tim->id_tim.',id_tim,lomba,'.$lomba,
					'kategori'				=> 'required',
					'asal'					=> 'required',
					'nama_pembimbing'		=> 'required',
				)
			);

			$passes = $validator->passes();

			if($passes)
			{
				$tim->password = Hash::make(Input::get('password'));
			}
		}
		else
		{
			$validator = Validator::make(
				Input::all(),
				array(
					'username' => 'required|unique:tb_cakrawala_kompetisi_tim,username,'.$tim->id_tim.',id_tim',
					
					'nama_tim' => 'required|unique:tb_cakrawala_kompetisi_tim,nama_tim,'.$tim->id_tim.',id_tim,lomba,'.$lomba,
					'kategori'				=> 'required',
					'asal'					=> 'required',
					'nama_pembimbing'		=> 'required',
				)
			);
			
			$passes = $validator->passes();
		}

		if ($passes)
		{
			if($tim->updateUniques())
			{
	        	return Redirect::action('panel.cakrawala.kompetisi.tim.index', $lomba)->with('success', 'Tim berhasil diubah!');	
			}
			else
			{
				return Redirect::action('panel.cakrawala.kompetisi.tim.edit', array($lomba, $tim->id_tim))->withErrors($tim->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');	
			}
        } else {
            return Redirect::action('panel.cakrawala.kompetisi.tim.edit', array($lomba, $tim->id_tim))->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($lomba, $tim)
	{
		if(! Input::get('safe-action')) return Redirect::back();

		$tim->delete();

		return Redirect::action('panel.cakrawala.kompetisi.tim.index', $lomba)->with('success', 'Tim berhasil dihapus!');
	}

	public function pay($lomba, $tim)
	{
		if($tim->bayar == 0)
		{
			$tim->bayar = 1;
			$status = "sudah";
		}
		else
		{
			$tim->bayar = 0;
			$status = "belum";
		}

		if ($tim->updateUniques()) {
        	return Redirect::back()->with('success', 'Tim '.$status.' membayar!');
        } else {
            return Redirect::back()->with('success', 'Gagal mengubah status pembayaran!');
        }
	}

}