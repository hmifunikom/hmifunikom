<?php

use IFGTim as Tim;

class PanelIFGamesTimController extends BaseController {

	private $tim;

	public function __construct(TimRepo $tim)
	{
		$this->tim = $tim;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($cabang)
	{
		$tim = $this->tim->findByCabang($cabang->id_cabang);
		return View::make('panel.pages.ifgames.tim.index')->with(array('cabang' => $cabang, 'listtim' => $tim));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($cabang)
	{
		$tim = new Tim;
		return View::make('panel.pages.ifgames.tim.form')->with(array('method' => 'create', 'cabang' => $cabang, 'tim' => $tim));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($cabang)
	{
		$validator = Validator::make(
			Input::all(),
			array(
				"password"				=> "required|min:4",
				"password_confirmation"	=> "same:password",
				'angkatan'              => 'required|numeric',
		        'kelas'                 => 'required|numeric',
			)
		);

		if($validator->passes())
		{
			$tim = new Tim();
			$tim->username = 'ifgames14'.Input::get('angkatan').''.Input::get('kelas');
			$tim->password = Hash::make(Input::get('password'));
			if ($cabang->tim()->save($tim)) {
	            return Redirect::action('panel.ifgames.tim.index', $cabang->id_cabang)->with('success', 'Tim berhasil ditambah!');
	        } else {
	            return Redirect::action('panel.ifgames.tim.create', $cabang->id_cabang)->withErrors($tim->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
	        }
		}
		else
		{
			return Redirect::action('panel.ifgames.tim.create', $cabang->id_cabang)->withErrors($validator->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($cabang, $tim)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($cabang, $tim)
	{
		return View::make('panel.pages.ifgames.tim.form')->with(array('method' => 'edit', 'cabang' => $cabang, 'tim' => $tim));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($cabang, $tim)
	{
		if ($tim->save()) {
            return Redirect::action('panel.ifgames.tim.index', $cabang->id_cabang)->with('success', 'Tim berhasil diubah!');
        } else {
            return Redirect::action('panel.ifgames.tim.edit', array($cabang->id_cabang, $tim->id_tim))->withErrors($tim->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($cabang, $tim)
	{
		if(! Input::get('safe-action')) return Redirect::back();

		$tim->delete();
		return Redirect::action('panel.ifgames.tim.index', $cabang->id_cabang)->with('success', 'Tim berhasil dihapus!');
	}

}