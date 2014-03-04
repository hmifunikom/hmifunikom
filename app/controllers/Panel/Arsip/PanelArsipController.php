<?php

class PanelArsipController extends BaseController {

	private $dokumen;

	public function __construct(DokumenRepo $dokumen)
	{
		$this->dokumen = $dokumen;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$dokumen = $this->dokumen->findAll();
		return View::make('panel.pages.arsip.index')->with(array('listdokumen' => $dokumen));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$dokumen = new Dokumen;
		return View::make('panel.pages.arsip.form')->with(array('method' => 'create', 'dokumen' => $dokumen));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$dokumen = new Dokumen;

		if ($dokumen->save()) {
            return Redirect::action('panel.arsip.waktu.create', $dokumen->kd_dokumen)->with('success', 'dokumen berhasil ditambah!');
        } else {
            return Redirect::action('panel.arsip.create')->withErrors($dokumen->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $dokumen
	 * @return Response
	 */
	public function show($dokumen)
	{
		return View::make('panel.pages.arsip.show')->with(array('dokumen' => $dokumen));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $dokumen
	 * @return Response
	 */
	public function edit($dokumen)
	{
		return View::make('panel.pages.arsip.form')->with(array('method' => 'edit', 'dokumen' => $dokumen));	
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $dokumen
	 * @return Response
	 */
	public function update($dokumen)
	{
		if ($dokumen->save()) {
            return Redirect::action('panel.arsip.show', $dokumen->kd_dokumen)->with('success', 'dokumen berhasil diubah!');
        } else {
            return Redirect::action('panel.arsip.edit', $dokumen->kd_dokumen)->withErrors($dokumen->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $dokumen
	 * @return Response
	 */
	public function destroy($dokumen)
	{
		$dokumen->delete();
		return Redirect::action('panel.arsip.index')->with('message', 'dokumen berhasil dihapus!');
	}

}