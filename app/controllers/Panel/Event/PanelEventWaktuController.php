<?php

class PanelEventWaktuController extends BaseController {

	private $waktu;

	public function __construct(WaktuAcaraRepo $waktu)
	{
		$this->waktu = $waktu;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($acara)
	{
		$waktu = $this->waktu->findByAcara($acara->kd_acara);
		return View::make('panel.pages.event.waktu.index')->with(array('acara' => $acara, 'listwaktu' => $waktu));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($acara)
	{
		$waktu = new WaktuAcara;
		return View::make('panel.pages.event.waktu.form')->with(array('method' => 'create', 'acara' => $acara, 'waktu' => $waktu));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($acara)
	{
		$waktu = new WaktuAcara();
		if ($acara->waktu()->save($waktu)) {
            return Redirect::action('panel.event.waktu.index', $acara->kd_acara)->with('success', 'Waktu berhasil ditambah!');
        } else {
            return Redirect::action('panel.event.waktu.create', $acara->kd_acara)->withErrors($waktu->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($acara, $waktu)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($acara, $waktu)
	{
		return View::make('panel.pages.event.waktu.form')->with(array('method' => 'edit', 'acara' => $acara, 'waktu' => $waktu));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($acara, $waktu)
	{
		if ($waktu->save()) {
            return Redirect::action('panel.event.waktu.index', $acara->kd_acara)->with('success', 'Waktu berhasil diubah!');
        } else {
            return Redirect::action('panel.event.waktu.edit', array($acara->kd_acara, $waktu->id_waktu))->withErrors($waktu->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($acara, $waktu)
	{
		$waktu->delete();
		return Redirect::action('panel.event.waktu.index', $acara->kd_acara)->with('success', 'Waktu berhasil dihapus!');
	}

}