<?php

class PanelKeanggotaanDivisiController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$divisi = Divisi::all();
		return View::make('panel.pages.keanggotaan.divisi.index')->with(array('listdivisi' => $divisi));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$divisi = new Divisi;
		return View::make('panel.pages.keanggotaan.divisi.form')->with(array('method' => 'create', 'divisi' => $divisi));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$divisi = new Divisi;

		if ($divisi->save()) {
            return Redirect::action('panel.keanggotaan.divisi.index')->with('success', 'Divisi berhasil ditambah!');
        } else {
            return Redirect::action('panel.keanggotaan.divisi.create')->withErrors($divisi->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($divisi)
	{
		return View::make('panel.pages.keanggotaan.divisi.form')->with(array('method' => 'edit', 'divisi' => $divisi));	
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($divisi)
	{
		if ($divisi->save()) {
            return Redirect::action('panel.keanggotaan.divisi.index')->with('success', 'Divisi berhasil diubah!');
        } else {
            return Redirect::action('panel.keanggotaan.divisi.edit', $divisi->id_divisi)->withErrors($divisi->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($divisi)
	{
		$divisi->delete();
		return Redirect::action('panel.keanggotaan.divisi.index')->with('success', 'Divisi berhasil dihapus!');
	}

}