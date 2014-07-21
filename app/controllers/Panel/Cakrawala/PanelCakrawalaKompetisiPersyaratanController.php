<?php

use HMIF\Model\Cakrawala\Persyaratan;
use HMIF\Repositories\Cakrawala\PersyaratanRepoInterface;

class PanelCakrawalaKompetisiPersyaratanController extends BaseController {
	
	private $persyaratan;

	public function __construct(PersyaratanRepoInterface $persyaratan)
	{
		$this->persyaratan = $persyaratan;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($lomba, $tim)
	{
		$persyaratan = $this->persyaratan->findByTim($tim->id_tim);

		return View::make('panel.pages.cakrawala.kompetisi.persyaratan.index')->with(array('lomba' => $lomba, 'tim' => $tim, 'persyaratan' => $persyaratan));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($lomba, $tim)
	{
		$persyaratan = new Persyaratan;
		return View::make('panel.pages.cakrawala.kompetisi.persyaratan.form')->with(array('method' => 'create', 'lomba' => $lomba, 'tim' => $tim, 'persyaratan' => $persyaratan));
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

			$filename = Str::slug($lomba.'_s_'.$tim->id_tim.'_'.$tim->nama_tim);
			$file = new FileManipulation('dokumen', $filename);
			
			if($file->isUploaded())
			{
				$persyaratan->persyaratan = $file->getFileName();

				if ($tim->persyaratan()->save($persyaratan)) {
	            	return Redirect::action('panel.cakrawala.kompetisi.tim.persyaratan.index', array($tim->lomba, $tim->id_tim))->with('success', 'Dokumen persyaratan berhasil ditambah!');
		        } else {
		            return Redirect::action('panel.cakrawala.kompetisi.tim.persyaratan.create', array($tim->lomba, $tim->id_tim))->withErrors($persyaratan->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
		        }
	        } else {
	            return Redirect::action('panel.cakrawala.kompetisi.tim.persyaratan.create', array($tim->lomba, $tim->id_tim))->withErrors($validator)->with('danger', 'Dokumen gagal diupload!')->withInput();
	        }
	    }
	    else
	    {
	    	return Redirect::action('panel.cakrawala.kompetisi.tim.persyaratan.create', array($tim->lomba, $tim->id_tim))->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
	    }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($lomba, $tim, $persyaratan)
	{
		return Redirect::action('panel.cakrawala.kompetisi.tim.persyaratan.index', array($lomba, $tim->id_tim));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($lomba, $tim, $persyaratan)
	{
		return View::make('panel.pages.cakrawala.kompetisi.persyaratan.form')->with(array('method' => 'edit', 'lomba' => $lomba, 'tim' => $tim, 'persyaratan' => $persyaratan));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($lomba, $tim, $persyaratan)
	{
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
			$filename = Str::slug($lomba.'_s_'.$tim->id_tim.'_'.$tim->nama_tim);
			$file = new FileManipulation('dokumen', $filename);
			
			if($file->isUploaded())
			{
				Helper::deleteFile($persyaratan->persyaratan);

				$persyaratan->persyaratan = $file->getFileName();

				if ($persyaratan->updateUniques()) {
	            	return Redirect::action('panel.cakrawala.kompetisi.tim.persyaratan.index', array($tim->lomba, $tim->id_tim))->with('success', 'Dokumen persyaratan berhasil diganti!');
		        } else {
		            return Redirect::action('panel.cakrawala.kompetisi.tim.persyaratan.create', array($tim->lomba, $tim->id_tim))->withErrors($persyaratan->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
		        }
	        } else {
	            return Redirect::action('panel.cakrawala.kompetisi.tim.persyaratan.create', array($tim->lomba, $tim->id_tim))->withErrors($validator)->with('danger', 'Dokumen gagal diupload!')->withInput();
	        }
	    }
	    else
	    {
	    	return Redirect::action('panel.cakrawala.kompetisi.tim.persyaratan.create', array($tim->lomba, $tim->id_tim))->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
	    }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($lomba, $tim, $persyaratan)
	{
		return Redirect::action('panel.cakrawala.kompetisi.tim.persyaratan.index', array($lomba, $tim->id_tim));
	}

	public function download($lomba, $tim, $persyaratan)
	{
		return Response::download(Helper::pathFile($persyaratan->persyaratan, true));
	}
}