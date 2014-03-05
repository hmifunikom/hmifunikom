<?php

class PanelKeanggotaanKasController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($anggota)
	{
		$kas = Kas::paginate(12);
		return View::make('panel.pages.keanggotaan.kas.index')->with(array('anggota' => $anggota, 'listkas' => $kas));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($anggota)
	{
		$kas = new Kas;
		return View::make('panel.pages.keanggotaan.kas.form')->with(array('method' => 'create', 'anggota' => $anggota, 'kas' => $kas));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($anggota)
	{
		$kas = new Kas;

		if ($anggota->kas()->save($kas)) {
            return Redirect::action('panel.keanggotaan.kas.index', $anggota->id_anggota)->with('success', 'Kas berhasil ditambah!');
        } else {
            return Redirect::action('panel.keanggotaan.kas.create', $anggota->id_anggota)->withErrors($kas->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($anggota, $kas)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($anggota, $kas)
	{
		return View::make('panel.pages.keanggotaan.kas.form')->with(array('method' => 'edit', 'anggota' => $anggota, 'kas' => $kas));	
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($anggota, $kas)
	{
		if ($kas->save()) {
            return Redirect::action('panel.keanggotaan.kas.index', $anggota->id_anggota)->with('success', 'Kas berhasil diubah!');
        } else {
            return Redirect::action('panel.keanggotaan.kas.edit', array($anggota->id_anggota, $kas->kd_kas))->withErrors($kas->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($anggota, $kas)
	{
		$kas->delete();
		return Redirect::action('panel.keanggotaan.kas.index', $anggota->id_anggota)->with('success', 'Kas berhasil dihapus!');
	}

}