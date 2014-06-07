<?php

use HMIF\Model\IFGames\AnggotaTim;

class IFGamesAnggota extends BaseController {

	private $anggota;

	public function __construct(AnggotaTimRepo $anggota)
	{
		$this->beforeFilter(function()
        {
        	if (Auth::ifgames()->guest()) return Redirect::guest('ifgames/login'); 
        });

		$this->anggota = $anggota;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$cabang = Auth::ifgames()->user()->cabang;
		$tim = Auth::ifgames()->user();

		if($cabang->manager > 0)
			$manager = $this->anggota->findManagerByTim($tim->id_tim);
		else
			$manager = new AnggotaTim;

		if($cabang->official > 0)
			$official = $this->anggota->findOfficialByTim($tim->id_tim);
		else
			$official = new AnggotaTim;

		$anggota = $this->anggota->findAnggotaByTim($tim->id_tim);

		return View::make('pages.ifgames.anggota.index')->with(array('pagetitle' => 'Form Anggota - IF Games', 'cabang' => $cabang, 'tim' => $tim, 'manager' => $manager, 'official' => $official, 'listanggota' => $anggota));
	}

	public function download()
	{
		$cabang = Auth::ifgames()->user()->cabang;
		$tim = Auth::ifgames()->user();

		if(! $tim->anggota_lengkap() || ! $tim->dokumen_lengkap())
		{
			return Redirect::back()->with('danger', 'Tim belum melengkapi anggota dan dokumen persyaratan!');
		}
		

		Helper::createQR($tim->id_tim.$tim->username.$tim->nama_tim);
		$html =  View::make('pages.ifgames.anggota.kuitansi')->with(array('cabang' => $cabang, 'tim' => $tim))->render();
		$filename = Str::slug('kuitansi_'.$tim->username.'_'.$tim->nama_tim);
		return PDF::load($html, 'A4', 'portrait')->download($filename);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$cabang = Auth::ifgames()->user()->cabang;
		$tim = Auth::ifgames()->user();

		if($tim->bayar != 1)
			return Redirect::action('ifgames.anggota.index');

		$jabatan = Input::get('jabatan');
		if(! in_array($jabatan, array('manager', 'official', 'anggota')) || ! Input::has('jabatan'))
			return Redirect::action('ifgames.anggota.index');

		if($tim->cabang->{$jabatan} < 1) 
			return Redirect::action('ifgames.anggota.index');

		switch($jabatan)
		{
			case 'manager':
				if($tim->sisa_kuota_manager() < 1)
					return Redirect::action('ifgames.anggota.index');
				break;

			case 'official':
				if($tim->sisa_kuota_official() < 1)
					return Redirect::action('ifgames.anggota.index');
				break;

			case 'anggota':
				if($tim->sisa_kuota_anggota() < 1)
					return Redirect::action('ifgames.anggota.index');
				break;
		}

		$anggota = new AnggotaTim;
		return View::make('pages.ifgames.anggota.form')->with(array('pagetitle' => 'Tambah Anggota - IF Games', 'method' => 'create', 'cabang' => $cabang, 'tim' => $tim, 'anggota' => $anggota));
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
		$cabang = Auth::ifgames()->user()->cabang;
		$tim = Auth::ifgames()->user();

		if($tim->bayar != 1)
			return Redirect::action('ifgames.anggota.index');

		$jabatan = Input::get('jabatan');
		if(! in_array($jabatan, array('manager', 'official', 'anggota')) || ! Input::has('jabatan'))
			return Redirect::action('ifgames.anggota.index', array($tim->cabang->id_cabang, $tim->id_tim));

		if($tim->cabang->{$jabatan} < 1) 
			return Redirect::action('ifgames.anggota.index', array($tim->cabang->id_cabang, $tim->id_tim));

		switch($jabatan)
		{
			case 'manager':
				if($tim->sisa_kuota_manager() < 1)
					return Redirect::action('ifgames.anggota.index', array($tim->cabang->id_cabang, $tim->id_tim));
				break;

			case 'official':
				if($tim->sisa_kuota_official() < 1)
					return Redirect::action('ifgames.anggota.index', array($tim->cabang->id_cabang, $tim->id_tim));
				break;

			case 'anggota':
				if($tim->sisa_kuota_anggota() < 1)
					return Redirect::action('ifgames.anggota.index', array($tim->cabang->id_cabang, $tim->id_tim));
				break;
		}

		$messages = array(
			'unique' => 'Nim sudah terdaftar pada tim di cabang yang sama.',
			'max'    => 'Foto tidak boleh lebih dari 2MB.'
		);
		$validator = Validator::make(
			Input::all(),
			array(
				'nim'   => 'required|numeric|nim|unique:tb_ifgames_anggota,nim,NULL,id_anggota,id_cabang,'.$tim->cabang->id_cabang,
		        'nama'  => 'required',
		        'no_hp' => 'required|numeric',
		        'foto_anggota'  => 'required|image|max:2048',
			), $messages
		);

		if($validator->passes())
		{
			$anggota = new AnggotaTim();
			$anggota->id_cabang = $tim->cabang->id_cabang;

			$filename = str_random(20);
			$img = new ImageManipulation('foto_anggota', $filename);
			
			if($img->isUploaded())
			{
				$img->thumb(76, 114);
				$anggota->foto = $img->getFileName();

				if ($tim->anggotatim()->save($anggota)) {
	            	return Redirect::action('ifgames.anggota.index')->with('success', 'Anggota berhasil ditambah!');
		        } else {
		            return Redirect::action('ifgames.anggota.create', array('jabatan' => $jabatan))->withErrors($anggota->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
		        }
	        } else {
	            return Redirect::action('ifgames.anggota.create', array('jabatan' => $jabatan))->withErrors($validator)->with('danger', 'Poster gagal diunggah!')->withInput();
	        }
	    }
	    else
	    {
	    	return Redirect::action('ifgames.anggota.create', array('jabatan' => $jabatan))->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
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
		return Redirect::action('ifgames.anggota.index');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($anggota)
	{
		$cabang = Auth::ifgames()->user()->cabang;
		$tim = Auth::ifgames()->user();

		if($tim->bayar != 1)
			return Redirect::action('ifgames.anggota.index');

		if($anggota->id_tim != $tim->id_tim) 
			return Redirect::action('ifgames.anggota.index');

		$cabang = Auth::ifgames()->user()->cabang;
		$tim = Auth::ifgames()->user();

		return View::make('pages.ifgames.anggota.form')->with(array('pagetitle' => 'Edit Anggota - IF Games', 'method' => 'edit', 'cabang' => $cabang, 'tim' => $tim, 'anggota' => $anggota));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($anggota)
	{
		$cabang = Auth::ifgames()->user()->cabang;
		$tim = Auth::ifgames()->user();

		if($tim->bayar != 1)
			return Redirect::action('ifgames.anggota.index');

		if($anggota->id_tim != $tim->id_tim) 
			return Redirect::action('ifgames.anggota.index');

		$messages = array(
			'unique' => 'Nim sudah terdaftar pada tim di cabang yang sama.',
			'max'    => 'Foto tidak boleh lebih dari 2MB.'
		);
		$validator = Validator::make(
			Input::all(),
			array(
				'nim'   => 'required|numeric|nim|unique:tb_ifgames_anggota,nim,'.$anggota->id_anggota.',id_anggota,id_cabang,'.$tim->cabang->id_cabang,
		        'nama'  => 'required',
		        'no_hp' => 'required|numeric',
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

					if($anggota->foto)
					{
						Helper::deleteMedia($anggota->foto);
					}

					$anggota->foto = $img->getFileName();
				} else {
		            return Redirect::action('ifgames.anggota.edit', array($anggota->id_anggota))->withErrors($validator)->with('danger', 'Foto gagal diunggah!')->withInput();
		        }
		    }

			if ($anggota->updateUniques()) {
            	return Redirect::action('ifgames.anggota.index')->with('success', 'Anggota berhasil diubah	!');
	        } else {
	            return Redirect::action('ifgames.anggota.edit', array($anggota->id_anggota))->withErrors($anggota->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
	        }
	        
	    }
	    else
	    {
	    	return Redirect::action('ifgames.anggota.edit', array($anggota->id_anggota))->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
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
		$cabang = Auth::ifgames()->user()->cabang;
		$tim = Auth::ifgames()->user();

		if($tim->bayar != 1)
			return Redirect::action('ifgames.anggota.index');

		if(! Input::get('safe-action')) return Redirect::back();

		if($anggota->foto)
		{
			Helper::deleteMedia($anggota->foto);
		}

		$anggota->delete();
		return Redirect::action('ifgames.anggota.index')->with('success', 'Anggota berhasil dihapus!');
	}
}