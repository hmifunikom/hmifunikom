<?php

class PanelKeanggotaanController extends BaseController {

	private $anggota;

	public function __construct(AnggotaRepo $anggota)
	{
		$this->anggota = $anggota;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$anggota = $this->anggota->findAll();
		return View::make('panel.pages.keanggotaan.anggota.index')->with(array('listanggota' => $anggota));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$anggota = new Anggota;
		return View::make('panel.pages.keanggotaan.anggota.form')->with(array('method' => 'create', 'anggota' => $anggota));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$anggota = new Anggota;

		if ($anggota->save()) {
            return Redirect::action('panel.keanggotaan.index')->with('success', 'Anggota berhasil ditambah!');
        } else {
            return Redirect::action('panel.keanggotaan.create')->withErrors($anggota->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($anggota)
	{
		return View::make('panel.pages.keanggotaan.anggota.show')->with(array('anggota' => $anggota));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($anggota)
	{
		return View::make('panel.pages.keanggotaan.anggota.form')->with(array('method' => 'edit', 'anggota' => $anggota));	
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($anggota)
	{
		if ($anggota->updateUniques()) {
            return Redirect::action('panel.keanggotaan.show', $anggota->id_anggota)->with('success', 'Anggota berhasil diubah!');
        } else {
            return Redirect::action('panel.keanggotaan.edit', $anggota->id_anggota)->withErrors($anggota->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($anggota)
	{
		$anggota->delete();
		return Redirect::action('panel.keanggotaan.index')->with('message', 'Anggota berhasil dihapus!');
	}

}