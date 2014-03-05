<?php

class PanelEventController extends BaseController {

	private $acara;

	public function __construct(AcaraRepo $acara)
	{
		$this->acara = $acara;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$acara = $this->acara->findAll();
		return View::make('panel.pages.event.index')->with(array('listacara' => $acara));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$acara = new Acara;
		return View::make('panel.pages.event.form')->with(array('method' => 'create', 'acara' => $acara));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$acara = new Acara;

		if ($acara->save()) {
            return Redirect::action('panel.event.waktu.create', $acara->kd_acara)->with('success', 'Acara berhasil ditambah!');
        } else {
            return Redirect::action('panel.event.create')->withErrors($acara->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $acara
	 * @return Response
	 */
	public function show($acara)
	{
		return View::make('panel.pages.event.show')->with(array('acara' => $acara));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $acara
	 * @return Response
	 */
	public function edit($acara)
	{
		return View::make('panel.pages.event.form')->with(array('method' => 'edit', 'acara' => $acara));	
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $acara
	 * @return Response
	 */
	public function update($acara)
	{
		if ($acara->save()) {
            return Redirect::action('panel.event.show', $acara->kd_acara)->with('success', 'Acara berhasil diubah!');
        } else {
            return Redirect::action('panel.event.edit', $acara->kd_acara)->withErrors($acara->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $acara
	 * @return Response
	 */
	public function destroy($acara)
	{
		$acara->delete();
		return Redirect::action('panel.event.index')->with('success', 'Acara berhasil dihapus!');
	}

}