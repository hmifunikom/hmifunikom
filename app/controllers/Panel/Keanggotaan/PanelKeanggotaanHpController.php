<?php

class PanelKeanggotaanHpController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($anggota)
	{
		$hp = Hp::all();
		return View::make('panel.pages.keanggotaan.hp.index')->with(array('anggota' => $anggota, 'listhp' => $hp));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($anggota)
	{
		$hp = new Hp;
		return View::make('panel.pages.keanggotaan.hp.form')->with(array('method' => 'create', 'anggota' => $anggota, 'hp' => $hp));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($anggota)
	{
		$hp = new Hp;

		if ($anggota->hp()->save($hp)) {
            return Redirect::action('panel.keanggotaan.hp.index', $anggota->id_anggota)->with('success', 'No. Handphone berhasil ditambah!');
        } else {
            return Redirect::action('panel.keanggotaan.hp.create', $anggota->id_anggota)->withErrors($hp->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($anggota, $hp)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($anggota, $hp)
	{
		return View::make('panel.pages.keanggotaan.hp.form')->with(array('method' => 'edit', 'anggota' => $anggota, 'hp' => $hp));	
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($anggota, $hp)
	{
		if ($hp->save()) {
            return Redirect::action('panel.keanggotaan.hp.index', $anggota->id_anggota)->with('success', 'No. Handphone berhasil diubah!');
        } else {
            return Redirect::action('panel.keanggotaan.hp.edit', array($anggota->id_anggota, $hp->kd_hp))->withErrors($hp->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($anggota, $hp)
	{
		if(! Input::get('safe-action')) return Redirect::back();

		$hp->delete();
		return Redirect::action('panel.keanggotaan.hp.index', $anggota->id_anggota)->with('success', 'No. Handphone berhasil dihapus!');
	}

}