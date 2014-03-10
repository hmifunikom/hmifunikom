<?php

class PanelEventPanitiaController extends BaseController {

	private $panitia;

	public function __construct(PanitiaRepo $panitia)
	{
		$this->panitia = $panitia;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($acara)
	{
		$panitia = $this->panitia->findByAcara($acara->kd_acara);
		return View::make('panel.pages.event.panitia.index')->with(array('acara' => $acara, 'listpanitia' => $panitia));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($acara)
	{
		$panitia = new Panitia;
		return View::make('panel.pages.event.panitia.form')->with(array('method' => 'create', 'acara' => $acara, 'panitia' => $panitia));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($acara)
	{
		$panitia = new Panitia();
		if ($acara->panitia()->save($panitia)) {
            return Redirect::action('panel.event.panitia.index', $acara->kd_acara)->with('success', 'Panitia berhasil ditambah!');
        } else {
            return Redirect::action('panel.event.panitia.create', $acara->kd_acara)->withErrors($panitia->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($acara, $panitia)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($acara, $panitia)
	{
		return View::make('panel.pages.event.panitia.form')->with(array('method' => 'edit', 'acara' => $acara, 'panitia' => $panitia));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($acara, $panitia)
	{
		if ($panitia->save()) {
            return Redirect::action('panel.event.panitia.index', $acara->kd_acara)->with('success', 'Panitia berhasil diubah!');
        } else {
            return Redirect::action('panel.event.panitia.edit', array($acara->kd_acara, $panitia->id_panitia))->withErrors($panitia->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($acara, $panitia)
	{
		if(! Input::get('safe-action')) return Redirect::back();

		$panitia->delete();
		return Redirect::action('panel.event.panitia.index', $acara->kd_acara)->with('success', 'Panitia berhasil dihapus!');
	}

}