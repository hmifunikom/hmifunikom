<?php

use HMIF\Model\IFGames\Cabang as Cabang;

class PanelIFGamesCabangController extends BaseController {

	private $cabang;

	public function __construct(CabangRepo $cabang)
	{
		$this->cabang = $cabang;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$cabang = $this->cabang->findAll();
		return View::make('panel.pages.ifgames.index')->with(array('listcabang' => $cabang));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$cabang = new Cabang;
		return View::make('panel.pages.ifgames.form')->with(array('method' => 'create', 'cabang' => $cabang));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$cabang = new Cabang;

		if ($cabang->save()) {
            return Redirect::action('panel.ifgames.index')->with('success', 'Cabang berhasil ditambah!');
        } else {
            return Redirect::action('panel.ifgames.create')->withErrors($cabang->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $cabang
	 * @return Response
	 */
	public function show($cabang)
	{
		return View::make('panel.pages.ifgames.show')->with(array('cabang' => $cabang));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $cabang
	 * @return Response
	 */
	public function edit($cabang)
	{
		return View::make('panel.pages.ifgames.form')->with(array('method' => 'edit', 'cabang' => $cabang));	
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $cabang
	 * @return Response
	 */
	public function update($cabang)
	{
		if ($cabang->save()) {
            return Redirect::action('panel.ifgames.index')->with('success', 'Cabang berhasil diubah!');
        } else {
            return Redirect::action('panel.ifgames.edit', $cabang->id_cabang)->withErrors($cabang->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $cabang
	 * @return Response
	 */
	public function destroy($cabang)
	{
		if(! Input::get('safe-action')) return Redirect::back();

		$cabang->delete();
		return Redirect::action('panel.ifgames.index')->with('success', 'Cabang berhasil dihapus!');
	}
}