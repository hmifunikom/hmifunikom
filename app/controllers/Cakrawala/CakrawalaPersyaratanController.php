<?php

use HMIF\Model\Cakrawala\Persyaratan;
use HMIF\Repositories\Cakrawala\PersyaratanRepoInterface;

class CakrawalaPersyaratanController extends BaseController {

	private $persyaratan;
	private $user;
	private $tim;
	private $lomba;

	public function __construct(PersyaratanRepoInterface $persyaratan)
	{
		$this->beforeFilter(function()
        {
        	if (Auth::cakrawala()->guest()) return Redirect::guest('login'); 
        	if (! (Auth::cakrawala()->user()->userable instanceof HMIF\Model\Cakrawala\Tim)) return Redirect::guest('logout');
        });

		$this->persyaratan = $persyaratan;
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
		if($this->tim->bayar != 1)
			return Redirect::action('cakrawala.pembayaran.edit');

		$persyaratan = $this->tim->persyaratan;

		return View::make('pages.cakrawala.persyaratan.index')->with(array('pagetitle' => 'Form Persyaratan', 'lomba' => $this->lomba, 'tim' => $this->tim, 'persyaratan' => $persyaratan));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if($this->tim->bayar != 1)
			return Redirect::action('cakrawala.pembayaran.edit');

		if($this->tim->persyaratan)
			return Redirect::action('cakrawala.persyaratan.index');

		$persyaratan = new Persyaratan;
		return View::make('pages.cakrawala.persyaratan.form')->with(array('pagetitle' => 'Upload Persyaratan', 'method' => 'create', 'lomba' => $this->lomba, 'tim' => $this->tim, 'anggota' => $persyaratan));
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
			return Redirect::action('cakrawala.pembayaran.edit');

		if($this->tim->persyaratan)
			return Redirect::action('cakrawala.persyaratan.index');


		$messages = array(
			'max'    => 'Dokumen tidak boleh lebih dari 2MB.'
		);
		$validator = Validator::make(
			Input::all(),
			array(
				'dokumen'  => 'required|mimes:zip|max:2048',
			), $messages
		);

		if($validator->passes())
		{
			$persyaratan = new Persyaratan();

			$filename = Str::slug($this->lomba.'_s_'.$this->tim->id_tim.'_'.$this->tim->nama_tim);
			$file = new FileManipulation('dokumen', $filename);
			
			if($file->isUploaded())
			{
				$persyaratan->persyaratan = $file->getFileName();

				if ($this->tim->persyaratan()->save($persyaratan)) {
	            	return Redirect::action('cakrawala.persyaratan.index')->with('success', 'Dokumen persyaratan berhasil ditambah!');
		        } else {
		            return Redirect::action('cakrawala.persyaratan.create')->withErrors($persyaratan->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
		        }
	        } else {
	            return Redirect::action('cakrawala.persyaratan.create')->withErrors($validator)->with('danger', 'Dokumen gagal diupload!')->withInput();
	        }
	    }
	    else
	    {
	    	return Redirect::action('cakrawala.persyaratan.create')->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
	    }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($persyaratan)
	{
		if($this->tim->bayar != 1)
			return Redirect::action('cakrawala.pembayaran.edit');
		
		return Redirect::action('cakrawala.persyaratan.index');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($persyaratan)
	{
		if($this->tim->bayar != 1)
			return Redirect::action('cakrawala.pembayaran.edit');
		
		if($persyaratan->documentable->id_tim != $this->tim->id_tim) 
			return Redirect::action('cakrawala.persyaratan.index');

		return View::make('pages.cakrawala.persyaratan.form')->with(array('pagetitle' => 'Edit Persyaratan', 'method' => 'edit', 'lomba' => $this->lomba, 'tim' => $this->tim, 'persyaratan' => $persyaratan));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($persyaratan)
	{
		if($this->tim->bayar != 1)
			return Redirect::action('cakrawala.pembayaran.edit');
		
		if($persyaratan->documentable->id_tim != $this->tim->id_tim) 
			return Redirect::action('cakrawala.persyaratan.index');

		$messages = array(
			'max'    => 'Dokumen tidak boleh lebih dari 2MB.'
		);
		$validator = Validator::make(
			Input::all(),
			array(
				'dokumen'  => 'required|mimes:zip|max:2048',
			), $messages
		);	

		if($validator->passes())
		{
			$filename = Str::slug($this->lomba.'_s_'.$this->tim->id_tim.'_'.$this->tim->nama_tim);
			$file = new FileManipulation('dokumen', $filename);
			
			if($file->isUploaded())
			{
				Helper::deleteFile($persyaratan->persyaratan);

				$persyaratan->persyaratan = $file->getFileName();

				if ($persyaratan->updateUniques()) {
	            	return Redirect::action('cakrawala.persyaratan.index')->with('success', 'Dokumen persyaratan berhasil diganti!');
		        } else {
		            return Redirect::action('cakrawala.persyaratan.edit', array($persyaratan->id_dokumen))->withErrors($persyaratan->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
		        }
	        } else {
	            return Redirect::action('cakrawala.persyaratan.edit', array($persyaratan->id_dokumen))->withErrors($validator)->with('danger', 'Dokumen gagal diupload!')->withInput();
	        }
	    }
	    else
	    {
	    	return Redirect::action('cakrawala.persyaratan.edit', array($persyaratan->id_dokumen))->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
	    }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($persyaratan)
	{
		if($this->tim->bayar != 1)
			return Redirect::action('cakrawala.pembayaran.edit');
		
		return Redirect::action('cakrawala.persyaratan.index');
	}

	public function download($persyaratan)
	{
		if($this->tim->bayar != 1)
			return Redirect::action('cakrawala.pembayaran.edit');
		
		if($persyaratan->documentable->id_tim != $this->tim->id_tim) 
			return Redirect::action('cakrawala.persyaratan.index');

		return Response::download(Helper::pathFile($persyaratan->persyaratan, true));
	}
}