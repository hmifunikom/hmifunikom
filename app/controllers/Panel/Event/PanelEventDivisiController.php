<?php

use HMIF\Model\Acara\DivAcara;

class PanelEventDivisiController extends BaseController {

	private $div;

	public function __construct(DivAcaraRepo $div)
	{
		$this->div = $div;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($acara)
	{
		$div = $this->div->findByAcara($acara->kd_acara);
		return View::make('panel.pages.event.div.index')->with(array('acara' => $acara, 'listdiv' => $div));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($acara)
	{
		$div = new DivAcara;
		return View::make('panel.pages.event.div.form')->with(array('method' => 'create', 'acara' => $acara, 'div' => $div));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($acara)
	{
		$div = new DivAcara();
		if ($acara->divisi()->save($div)) {
            return Redirect::action('panel.event.div.index', $acara->kd_acara)->with('success', 'Divisi berhasil ditambah!');
        } else {
            return Redirect::action('panel.event.div.create', $acara->kd_acara)->withErrors($div->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($acara, $div)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($acara, $div)
	{
		return View::make('panel.pages.event.div.form')->with(array('method' => 'edit', 'acara' => $acara, 'div' => $div));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($acara, $div)
	{
		if ($div->save()) {
            return Redirect::action('panel.event.div.index', $acara->kd_acara)->with('success', 'Divisi berhasil diubah!');
        } else {
            return Redirect::action('panel.event.div.edit', array($acara->kd_acara, $div->id_div))->withErrors($div->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($acara, $div)
	{
		if(! Input::get('safe-action')) return Redirect::back();

		$div->delete();
		return Redirect::action('panel.event.div.index', $acara->kd_acara)->with('success', 'Divisi berhasil dihapus!');
	}

}