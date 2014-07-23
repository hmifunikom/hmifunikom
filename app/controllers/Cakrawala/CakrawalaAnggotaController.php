<?php

use HMIF\Model\Cakrawala\Anggota;
use HMIF\Repositories\Cakrawala\AnggotaRepoInterface;

class CakrawalaAnggotaController extends BaseController {

	private $anggota;
	private $user;
	private $tim;
	private $lomba;

	public function __construct(AnggotaRepoInterface $anggota)
	{
		$this->beforeFilter(function()
        {
        	if (Auth::cakrawala()->guest()) return Redirect::guest('login'); 
        });

		$this->anggota = $anggota;
		if(! Auth::cakrawala()->guest())
		{
			$this->user = Auth::cakrawala()->user();
			$this->tim = $this->user->userable;
			$this->lomba = $this->tim->lomba;
		}
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$anggota = $this->tim->anggota;

		return View::make('pages.cakrawala.anggota.index')->with(array('pagetitle' => 'Form Anggota', 'lomba' => $this->lomba, 'tim' => $this->tim, 'listanggota' => $anggota));
	}

	public function download()
	{
		if(! $this->tim->anggota_lengkap() || ! $this->tim->dokumen_lengkap())
		{
			return Redirect::back()->with('danger', 'Tim belum melengkapi anggota dan dokumen persyaratan!');
		}
		

		Helper::createQR($this->tim->id_tim.$this->tim->username.$this->tim->nama_tim);
		$html =  View::make('pages.cakrawala.anggota.kuitansi')->with(array('lomba' => $this->lomba, 'tim' => $this->tim))->render();
		$filename = Str::slug('kuitansi_'.$this->tim->username.'_'.$this->tim->nama_tim);
		return PDF::load($html, 'A4', 'portrait')->download($filename);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if($this->tim->bayar != 1)
			return Redirect::action('cakrawala.anggota.index');

		if($this->tim->sisa_kuota_anggota() < 1)
			return Redirect::action('cakrawala.anggota.index');

		$anggota = new Anggota;
		return View::make('pages.cakrawala.anggota.form')->with(array('pagetitle' => 'Tambah Anggota', 'method' => 'create', 'lomba' => $this->lomba, 'tim' => $this->tim, 'anggota' => $anggota));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 *
	 * 
	 * @return Response
	 */
	public function store()
	{
		if($this->tim->bayar != 1)
			return Redirect::action('cakrawala.anggota.index');

		if($this->tim->sisa_kuota_anggota() < 1)
			return Redirect::action('cakrawala.anggota.index');


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

				if ($this->tim->anggota()->save($anggota)) {
	            	return Redirect::action('cakrawala.anggota.index')->with('success', 'Anggota berhasil ditambah!');
		        } else {
		            return Redirect::action('cakrawala.anggota.create')->withErrors($anggota->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
		        }
	        } else {
	            return Redirect::action('cakrawala.anggota.create')->withErrors($validator)->with('danger', 'Foto gagal diunggah!')->withInput();
	        }
	    }
	    else
	    {
	    	return Redirect::action('cakrawala.anggota.create')->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
	    }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($anggota)
	{
		return Redirect::action('cakrawala.anggota.index');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($anggota)
	{
		if($this->tim->bayar != 1)
			return Redirect::action('cakrawala.anggota.index');

		if($anggota->id_tim != $this->tim->id_tim) 
			return Redirect::action('cakrawala.anggota.index');

		return View::make('pages.cakrawala.anggota.form')->with(array('pagetitle' => 'Edit Anggota', 'method' => 'edit', 'lomba' => $this->lomba, 'tim' => $this->tim, 'anggota' => $anggota));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($anggota)
	{
		if($this->tim->bayar != 1)
			return Redirect::action('cakrawala.anggota.index');

		if($anggota->id_tim != $this->tim->id_tim) 
			return Redirect::action('cakrawala.anggota.index');

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
		            return Redirect::action('cakrawala.anggota.edit', array($anggota->id_anggota))->withErrors($validator)->with('danger', 'Foto gagal diunggah!')->withInput();
		        }
		    }

			if ($anggota->updateUniques()) {
            	return Redirect::action('cakrawala.anggota.index')->with('success', 'Anggota berhasil diubah	!');
	        } else {
	            return Redirect::action('cakrawala.anggota.edit', array($anggota->id_anggota))->withErrors($anggota->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
	        }
	        
	    }
	    else
	    {
	    	return Redirect::action('cakrawala.anggota.edit', array($anggota->id_anggota))->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
	    }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($anggota)
	{
		if($this->tim->bayar != 1)
			return Redirect::action('cakrawala.anggota.index');

		if($anggota->id_tim != $this->tim->id_tim) 
			return Redirect::action('cakrawala.anggota.index');

		if(! Input::get('safe-action')) return Redirect::back();

		if($anggota->foto)
		{
			Helper::deleteMedia($anggota->foto);
		}

		$anggota->delete();
		return Redirect::action('cakrawala.anggota.index')->with('success', 'Anggota berhasil dihapus!');
	}
}