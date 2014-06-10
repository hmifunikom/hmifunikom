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
		$jabatan = Input::get('jabatan');
		if(! in_array($jabatan, array('manager', 'official', 'anggota')) || ! Input::has('jabatan'))
			return Redirect::action('panel.cakrawala.kompetisi.tim.anggota.index', array($tim->lomba, $tim->id_tim));

		if($tim->lomba->{$jabatan} < 1) 
			return Redirect::action('panel.cakrawala.kompetisi.tim.anggota.index', array($tim->lomba, $tim->id_tim));

		switch($jabatan)
		{
			case 'manager':
				if($tim->sisa_kuota_manager() < 1)
					return Redirect::action('panel.cakrawala.kompetisi.tim.anggota.index', array($tim->lomba, $tim->id_tim));
				break;

			case 'official':
				if($tim->sisa_kuota_official() < 1)
					return Redirect::action('panel.cakrawala.kompetisi.tim.anggota.index', array($tim->lomba, $tim->id_tim));
				break;

			case 'anggota':
				if($tim->sisa_kuota_anggota() < 1)
					return Redirect::action('panel.cakrawala.kompetisi.tim.anggota.index', array($tim->lomba, $tim->id_tim));
				break;
		}

		$messages = array(
			'unique' => 'Nim sudah terdaftar pada tim di lomba yang sama.',
			'max'    => 'Foto tidak boleh lebih dari 2MB.'
		);
		$validator = Validator::make(
			Input::all(),
			array(
				'nim'   => 'required|numeric|nim|unique:tb_cakrawala.kompetisi_anggota,nim,NULL,id_anggota,id_lomba,'.$tim->lomba,
		        'nama'  => 'required',
		        'no_hp' => 'required|numeric',
		        'foto_anggota'  => 'required|image|max:2048',
			), $messages
		);

		if($validator->passes())
		{
			$anggota = new Tim();
			$anggota = $tim->lomba;

			$filename = str_random(20);
			$img = new ImageManipulation('foto_anggota', $filename);
			
			if($img->isUploaded())
			{
				$img->thumb(76, 114);
				$anggota->foto = $img->getFileName();

				if ($tim->Tim()->save($anggota)) {
	            	return Redirect::action('panel.cakrawala.kompetisi.tim.anggota.index', array($tim->lomba, $tim->id_tim))->with('success', 'Anggota berhasil ditambah!');
		        } else {
		            return Redirect::action('panel.cakrawala.kompetisi.tim.anggota.create', array($tim->lomba, $tim->id_tim, 'jabatan' => $jabatan))->withErrors($anggota->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
		        }
	        } else {
	            return Redirect::action('panel.cakrawala.kompetisi.tim.anggota.create', array($tim->lomba, $tim->id_tim, 'jabatan' => $jabatan))->withErrors($validator)->with('danger', 'Poster gagal diunggah!')->withInput();
	        }
	    }
	    else
	    {
	    	return Redirect::action('panel.cakrawala.kompetisi.tim.anggota.create', array($tim->lomba, $tim->id_tim, 'jabatan' => $jabatan))->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
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

					if($anggota->foto)
					{
						Helper::deleteMedia($anggota->foto);
					}

					$anggota->foto = $img->getFileName();
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

		if($anggota->foto)
		{
			Helper::deleteMedia($anggota->foto);
		}

		$anggota->delete();
		return Redirect::action('panel.cakrawala.kompetisi.tim.anggota.index', array($tim->lomba, $tim->id_tim))->with('success', 'Anggota berhasil dihapus!');
	}

	public function ska($lomba, $tim, $anggota)
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

	public function ktm($lomba, $tim, $anggota)
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

	public function xls($lomba, $tim)
	{
		$filename = Str::slug('Daftar Tim '. $lomba->nama_lomba);

		$anggota = $lomba->anggota()->orderBy('kode', 'asc');

		$all = $this->_generateArray($lomba->anggota()->orderBy('kode', 'asc')->get());
		$bayar = $this->_generateArray($lomba->anggota()->orderBy('kode', 'asc')->where('bayar', '=', 1)->get());
		$unikom = $this->_generateArray($lomba->anggota()->orderBy('kode', 'asc')->where('kategori', '=', 'unikom')->get());
		$umum = $this->_generateArray($lomba->anggota()->orderBy('kode', 'asc')->where('kategori', '=', 'luar')->get());

		Excel::create($filename)
        ->sheet('Semua Tim')
            ->with($all)
        ->sheet('Sudah Bayar')
            ->with($bayar)
        ->sheet('Unikom')
            ->with($unikom)
        ->sheet('Umum')
            ->with($umum)
        ->export('xls');
	}

	public function vcf($lomba)
	{
		$dir = public_path().'/media/vcf/'.Str::slug($lomba->nama_lomba);

		if(! File::isDirectory($dir))
			File::makeDirectory($dir, 755, true);

		foreach($lomba->anggota()->get() as $p)
		{
			$vcard = new VObject\Component\VCard([
			    'FN'  => $lomba->nama_lomba.''.$p->kode.''.$p->nama_anggota,
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