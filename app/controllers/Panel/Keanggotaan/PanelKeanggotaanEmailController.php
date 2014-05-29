<?php

use HMIF\Model\Keanggotaan\Email;

class PanelKeanggotaanEmailController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($anggota)
	{
		$email = Email::all();
		return View::make('panel.pages.keanggotaan.email.index')->with(array('anggota' => $anggota, 'listemail' => $email));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($anggota)
	{
		$email = new Email;
		return View::make('panel.pages.keanggotaan.email.form')->with(array('method' => 'create', 'anggota' => $anggota, 'email' => $email));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($anggota)
	{
		$email = new Email;

		if ($anggota->email()->save($email)) {
            return Redirect::action('panel.keanggotaan.email.index', $anggota->id_anggota)->with('success', 'E-Mail berhasil ditambah!');
        } else {
            return Redirect::action('panel.keanggotaan.email.create', $anggota->id_anggota)->withErrors($email->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($anggota, $email)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($anggota, $email)
	{
		return View::make('panel.pages.keanggotaan.email.form')->with(array('method' => 'edit', 'anggota' => $anggota, 'email' => $email));	
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($anggota, $email)
	{
		if ($email->save()) {
            return Redirect::action('panel.keanggotaan.email.index', $anggota->id_anggota)->with('success', 'E-Mail berhasil diubah!');
        } else {
            return Redirect::action('panel.keanggotaan.email.edit', array($anggota->id_anggota, $email->kd_email))->withErrors($email->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($anggota, $email)
	{
		if(! Input::get('safe-action')) return Redirect::back();

		$email->delete();
		return Redirect::action('panel.keanggotaan.email.index', $anggota->id_anggota)->with('success', 'E-mail berhasil dihapus!');
	}

}