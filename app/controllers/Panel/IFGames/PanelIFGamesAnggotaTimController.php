<?php

use IFGAnggotaTim as AnggotaTim;

class PanelIFGamesAnggotaTimController extends BaseController {
	
	private $anggota;

	public function __construct(AnggotaTimRepo $anggota)
	{
		$this->anggota = $anggota;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($cabang, $tim)
	{
		if($cabang->manager > 0)
			$manager = $this->anggota->findManagerByTim($tim->id_tim);
		else
			$manager = new AnggotaTim;

		if($cabang->official > 0)
			$official = $this->anggota->findOfficialByTim($tim->id_tim);
		else
			$official = new AnggotaTim;

		$anggota = $this->anggota->findAnggotaByTim($tim->id_tim);

		return View::make('panel.pages.ifgames.anggota.index')->with(array('cabang' => $cabang, 'tim' => $tim, 'manager' => $manager, 'official' => $official, 'listanggota' => $anggota));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($cabang, $tim)
	{
		$jabatan = Input::get('jabatan');
		if(! in_array($jabatan, array('manager', 'official', 'anggota')) || ! Input::has('jabatan'))
			return Redirect::action('panel.ifgames.tim.anggota.index', array($tim->cabang->id_cabang, $tim->id_tim));

		if($tim->cabang->{$jabatan} < 1) 
			return Redirect::action('panel.ifgames.tim.anggota.index', array($tim->cabang->id_cabang, $tim->id_tim));

		switch($jabatan)
		{
			case 'manager':
				if($tim->sisa_kuota_manager() < 1)
					return Redirect::action('panel.ifgames.tim.anggota.index', array($tim->cabang->id_cabang, $tim->id_tim));
				break;

			case 'official':
				if($tim->sisa_kuota_official() < 1)
					return Redirect::action('panel.ifgames.tim.anggota.index', array($tim->cabang->id_cabang, $tim->id_tim));
				break;

			case 'anggota':
				if($tim->sisa_kuota_anggota() < 1)
					return Redirect::action('panel.ifgames.tim.anggota.index', array($tim->cabang->id_cabang, $tim->id_tim));
				break;
		}

		$anggota = new AnggotaTim;
		return View::make('panel.pages.ifgames.anggota.form')->with(array('method' => 'create', 'cabang' => $cabang, 'tim' => $tim, 'anggota' => $anggota));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 *
	 * 
	 * @return Response
	 */
	public function store($cabang, $tim)
	{
		$jabatan = Input::get('jabatan');
		if(! in_array($jabatan, array('manager', 'official', 'anggota')) || ! Input::has('jabatan'))
			return Redirect::action('panel.ifgames.tim.anggota.index', array($tim->cabang->id_cabang, $tim->id_tim));

		if($tim->cabang->{$jabatan} < 1) 
			return Redirect::action('panel.ifgames.tim.anggota.index', array($tim->cabang->id_cabang, $tim->id_tim));

		switch($jabatan)
		{
			case 'manager':
				if($tim->sisa_kuota_manager() < 1)
					return Redirect::action('panel.ifgames.tim.anggota.index', array($tim->cabang->id_cabang, $tim->id_tim));
				break;

			case 'official':
				if($tim->sisa_kuota_official() < 1)
					return Redirect::action('panel.ifgames.tim.anggota.index', array($tim->cabang->id_cabang, $tim->id_tim));
				break;

			case 'anggota':
				if($tim->sisa_kuota_anggota() < 1)
					return Redirect::action('panel.ifgames.tim.anggota.index', array($tim->cabang->id_cabang, $tim->id_tim));
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
	            	return Redirect::action('panel.ifgames.tim.anggota.index', array($tim->cabang->id_cabang, $tim->id_tim))->with('success', 'Anggota berhasil ditambah!');
		        } else {
		            return Redirect::action('panel.ifgames.tim.anggota.create', array($tim->cabang->id_cabang, $tim->id_tim, 'jabatan' => $jabatan))->withErrors($anggota->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
		        }
	        } else {
	            return Redirect::action('panel.ifgames.tim.anggota.create', array($tim->cabang->id_cabang, $tim->id_tim, 'jabatan' => $jabatan))->withErrors($validator)->with('danger', 'Poster gagal diunggah!')->withInput();
	        }
	    }
	    else
	    {
	    	return Redirect::action('panel.ifgames.tim.anggota.create', array($tim->cabang->id_cabang, $tim->id_tim, 'jabatan' => $jabatan))->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
	    }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($cabang, $tim, $anggota)
	{
		return Redirect::action('panel.ifgames.tim.anggota.index', array($cabang->id_cabang, $tim->id_tim));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($cabang, $tim, $anggota)
	{
		return View::make('panel.pages.ifgames.anggota.form')->with(array('method' => 'edit', 'cabang' => $cabang, 'tim' => $tim, 'anggota' => $anggota));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($cabang, $tim, $anggota)
	{
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
		            return Redirect::action('panel.ifgames.tim.anggota.edit', array($tim->cabang->id_cabang, $tim->id_tim, $anggota->id_anggota))->withErrors($validator)->with('danger', 'Foto gagal diunggah!')->withInput();
		        }
		    }

			if ($anggota->updateUniques()) {
            	return Redirect::action('panel.ifgames.tim.anggota.index', array($tim->cabang->id_cabang, $tim->id_tim))->with('success', 'Anggota berhasil diubah	!');
	        } else {
	            return Redirect::action('panel.ifgames.tim.anggota.edit', array($tim->cabang->id_cabang, $tim->id_tim, $anggota->id_anggota))->withErrors($anggota->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
	        }
	        
	    }
	    else
	    {
	    	return Redirect::action('panel.ifgames.tim.anggota.edit', array($tim->cabang->id_cabang, $tim->id_tim, $anggota->id_anggota))->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
	    }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($cabang, $tim, $anggota)
	{
		if(! Input::get('safe-action')) return Redirect::back();

		if($anggota->foto)
		{
			Helper::deleteMedia($anggota->foto);
		}

		$anggota->delete();
		return Redirect::action('panel.ifgames.tim.anggota.index', array($tim->cabang->id_cabang, $tim->id_tim))->with('success', 'Anggota berhasil dihapus!');
	}

	public function ska($cabang, $tim, $anggota)
	{
		if($anggota->ska == 0)
		{
			$anggota->ska = 1;
			$status = "sudah";
		}
		else
		{
			$anggota->ska = 0;
			$status = "belum";
		}

		if ($anggota->updateUniques()) {
            return Redirect::back()->with('success', 'Anggota '.$status.' menyerahkan SKA!');
        } else {
        	//dd($anggota->errors());
            return Redirect::back()->with('success', 'Gagal mengubah status SKA!');
        }
	}

	public function ktm($cabang, $tim, $anggota)
	{
		if($anggota->ktm == 0)
		{
			$anggota->ktm = 1;
			$status = "sudah";
		}
		else
		{
			$anggota->ktm = 0;
			$status = "belum";
		}

		if ($anggota->updateUniques()) {
            return Redirect::back()->with('success', 'Anggota '.$status.' menyerahkan KTM!');
        } else {
        	//dd($anggota->errors());
            return Redirect::back()->with('success', 'Gagal mengubah status KTM!');
        }
	}

	public function xls($cabang, $tim)
	{
		$filename = Str::slug('Daftar AnggotaTim '. $cabang->nama_cabang);

		$anggota = $cabang->anggota()->orderBy('kode', 'asc');

		$all = $this->_generateArray($cabang->anggota()->orderBy('kode', 'asc')->get());
		$bayar = $this->_generateArray($cabang->anggota()->orderBy('kode', 'asc')->where('bayar', '=', 1)->get());
		$unikom = $this->_generateArray($cabang->anggota()->orderBy('kode', 'asc')->where('kategori', '=', 'unikom')->get());
		$umum = $this->_generateArray($cabang->anggota()->orderBy('kode', 'asc')->where('kategori', '=', 'luar')->get());

		Excel::create($filename)
        ->sheet('Semua AnggotaTim')
            ->with($all)
        ->sheet('Sudah Bayar')
            ->with($bayar)
        ->sheet('Unikom')
            ->with($unikom)
        ->sheet('Umum')
            ->with($umum)
        ->export('xls');
	}

	public function vcf($cabang)
	{
		$dir = public_path().'/media/vcf/'.Str::slug($cabang->nama_cabang);

		if(! File::isDirectory($dir))
			File::makeDirectory($dir, 755, true);

		foreach($cabang->anggota()->get() as $p)
		{
			$vcard = new VObject\Component\VCard([
			    'FN'  => $cabang->nama_cabang.''.$p->kode.''.$p->nama_anggota,
			    'TEL' => $p->no_hp,
			]);

			$data =  $vcard->serialize();
			File::put($dir.'/'.Str::slug($p->kode.''.$p->nama_anggota).'.vcf', $data);
		}

		if(! File::isDirectory($dir))
			File::delete($dir.'-contact.zip');

		$zipper = new \Chumper\Zipper\Zipper;
		$zipper->make($dir.'-contact.zip')->add($dir)->close();

		File::deleteDirectory($dir);

		return Response::download($dir.'-contact.zip');
	}

	private function _generateArray($data)
	{
		foreach($data as $p)
		{
			$list[] = array($p->kode, $p->nama_anggota, $p->kategori, $p->nim, $p->no_hp, $p->bayar);
		}

		return $list;
	}
}