<?php

use HMIF\Model\Cakrawala\Anggota;
use HMIF\Repositories\Cakrawala\AnggotaRepoInterface;

class PanelCakrawalaKompetisiAnggotaController extends BaseController {
	
	private $anggota;

	public function __construct(AnggotaRepoInterface $anggota)
	{
		$this->anggota = $anggota;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($lomba, $tim)
	{
		$anggota = $this->anggota->findByTim($tim->id_tim);

		return View::make('panel.pages.cakrawala.kompetisi.anggota.index')->with(array('lomba' => $lomba, 'tim' => $tim, 'listanggota' => $anggota));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($lomba, $tim)
	{
		if($tim->sisa_kuota_anggota() < 1)
			return Redirect::action('panel.cakrawala.kompetisi.tim.anggota.index', array($tim->lomba, $tim->id_tim));
		
		$anggota = new Anggota;
		return View::make('panel.pages.cakrawala.kompetisi.anggota.form')->with(array('method' => 'create', 'lomba' => $lomba, 'tim' => $tim, 'anggota' => $anggota));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 *
	 * 
	 * @return Response
	 */
	public function store($lomba, $tim)
	{
		if($tim->sisa_kuota_anggota() < 1)
			return Redirect::action('panel.cakrawala.kompetisi.tim.anggota.index', array($tim->lomba, $tim->id_tim));


		$messages = array(
			'unique' => 'Nim sudah terdaftar pada tim di lomba yang sama.',
			'max'    => 'Foto tidak boleh lebih dari 2MB.'
		);
		$validator = Validator::make(
			Input::all(),
			array(
				'nama_anggota'  => 'required',
		        'tempat_lahir'  => 'required',
		        'tanggal_lahir' => 'required|date',
		        'alamat'        => 'required',
		        'no_telp'       => 'required|numeric',
		        'foto_anggota'  => 'required|image|max:2048',
			), $messages
		);

		if($validator->passes())
		{
			$anggota = new Anggota();

			$filename = str_random(20);
			$img = new ImageManipulation('foto_anggota', $filename);
			
			if($img->isUploaded())
			{
				$img->thumb(76, 114);
				$anggota->foto_anggota = $img->getFileName();

				if ($tim->anggota()->save($anggota)) {
	            	return Redirect::action('panel.cakrawala.kompetisi.tim.anggota.index', array($tim->lomba, $tim->id_tim))->with('success', 'Anggota berhasil ditambah!');
		        } else {
		            return Redirect::action('panel.cakrawala.kompetisi.tim.anggota.create', array($tim->lomba, $tim->id_tim))->withErrors($anggota->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
		        }
	        } else {
	            return Redirect::action('panel.cakrawala.kompetisi.tim.anggota.create', array($tim->lomba, $tim->id_tim))->withErrors($validator)->with('danger', 'Foto gagal diunggah!')->withInput();
	        }
	    }
	    else
	    {
	    	return Redirect::action('panel.cakrawala.kompetisi.tim.anggota.create', array($tim->lomba, $tim->id_tim))->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
	    }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($lomba, $tim, $anggota)
	{
		return Redirect::action('panel.cakrawala.kompetisi.tim.anggota.index', array($lomba, $tim->id_tim));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($lomba, $tim, $anggota)
	{
		return View::make('panel.pages.cakrawala.kompetisi.anggota.form')->with(array('method' => 'edit', 'lomba' => $lomba, 'tim' => $tim, 'anggota' => $anggota));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($lomba, $tim, $anggota)
	{
		$messages = array(
			'unique' => 'Nim sudah terdaftar pada tim di lomba yang sama.',
			'max'    => 'Foto tidak boleh lebih dari 2MB.'
		);
		$validator = Validator::make(
			Input::all(),
			array(
				'nama_anggota'  => 'required',
		        'tempat_lahir'  => 'required',
		        'tanggal_lahir' => 'required|date',
		        'alamat'        => 'required',
		        'no_telp'       => 'required|numeric',
		        'foto_anggota'  => 'image|max:2048',
			), $messages
		);

		if($validator->passes())
		{
			if(Input::hasFile('foto_anggota'))
			{
				$filename = str_random(20);
				$img = new ImageManipulation('foto_anggota', $filename);
				
				if($img->isUploaded())
				{
					$img->thumb(76, 114);

					if($anggota->foto_anggota)
					{
						Helper::deleteMedia($anggota->foto_anggota);
					}

					$anggota->foto_anggota = $img->getFileName();
				} else {
		            return Redirect::action('panel.cakrawala.kompetisi.tim.anggota.edit', array($tim->lomba, $tim->id_tim, $anggota->id_anggota))->withErrors($validator)->with('danger', 'Foto gagal diunggah!')->withInput();
		        }
		    }

			if ($anggota->updateUniques()) {
            	return Redirect::action('panel.cakrawala.kompetisi.tim.anggota.index', array($tim->lomba, $tim->id_tim))->with('success', 'Anggota berhasil diubah	!');
	        } else {
	            return Redirect::action('panel.cakrawala.kompetisi.tim.anggota.edit', array($tim->lomba, $tim->id_tim, $anggota->id_anggota))->withErrors($anggota->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
	        }
	        
	    }
	    else
	    {
	    	return Redirect::action('panel.cakrawala.kompetisi.tim.anggota.edit', array($tim->lomba, $tim->id_tim, $anggota->id_anggota))->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
	    }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($lomba, $tim, $anggota)
	{
		if(! Input::get('safe-action')) return Redirect::back();

		if($anggota->foto_anggota)
		{
			Helper::deleteMedia($anggota->foto_anggota);
		}

		$anggota->delete();
		return Redirect::action('panel.cakrawala.kompetisi.tim.anggota.index', array($tim->lomba, $tim->id_tim))->with('success', 'Anggota berhasil dihapus!');
	}
}