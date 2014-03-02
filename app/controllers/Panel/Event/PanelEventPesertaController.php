<?php

class PanelEventPesertaController extends BaseController {
	
	private $peserta;

	public function __construct(PesertaRepo $peserta)
	{
		$this->peserta = $peserta;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($acara)
	{
		$peserta = $this->peserta->findByAcara($acara->kd_acara);
		return View::make('panel.pages.event.peserta.index')->with(array('acara' => $acara, 'listpeserta' => $peserta));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($acara)
	{
		$peserta = new Peserta;
		$peserta->ticket = str_random(rand(40,50));
		return View::make('panel.pages.event.peserta.form')->with(array('method' => 'create', 'acara' => $acara, 'peserta' => $peserta));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($acara)
	{
		$peserta = new Peserta();
		$peserta->ticket = str_random(rand(40,50));
		if ($acara->peserta()->save($peserta)) {
            return Redirect::action('panel.event.peserta.index', $acara->kd_acara)->with('success', 'Peserta berhasil ditambah!');
        } else {
        	//die($peserta->errors());
            return Redirect::action('panel.event.peserta.create', $acara->kd_acara)->withErrors($peserta->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($acara, $peserta)
	{
		Helper::createQR($peserta->ticket);
		return View::make('panel.pages.event.peserta.show')->with(array('acara' => $acara, 'peserta' => $peserta));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($acara, $peserta)
	{
		return View::make('panel.pages.event.peserta.form')->with(array('method' => 'edit', 'acara' => $acara, 'peserta' => $peserta));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($acara, $peserta)
	{
		if ($peserta->save()) {
            return Redirect::action('panel.event.peserta.index', $acara->kd_acara)->with('success', 'Peserta berhasil diubah!');
        } else {
            return Redirect::action('panel.event.peserta.edit', array($acara->kd_acara, $peserta->id_peserta))->withErrors($peserta->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($acara, $peserta)
	{
		$peserta->delete();
		return Redirect::action('panel.event.peserta.index', $acara->kd_acara)->with('message', 'Peserta berhasil dihapus!');
	}

}