<?php

use HMIF\Model\Cakrawala\Karya;
use HMIF\Repositories\Cakrawala\KaryaRepoInterface;

class PanelCakrawalaKompetisiKaryaController extends BaseController {
	
	private $karya;

	public function __construct(KaryaRepoInterface $karya)
	{
		$this->karya = $karya;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($lomba, $tim)
	{
		$karya = $this->karya->findByTim($tim->id_tim);

		return View::make('panel.pages.cakrawala.kompetisi.karya.index')->with(array('lomba' => $lomba, 'tim' => $tim, 'karya' => $karya));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($lomba, $tim)
	{
		$karya = new Karya;
		return View::make('panel.pages.cakrawala.kompetisi.karya.form')->with(array('method' => 'create', 'lomba' => $lomba, 'tim' => $tim, 'karya' => $karya));
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
			'max'    => 'Karya tidak boleh lebih dari 2MB.',
			'url'	=> 'Link tidak valid.'
		);

		if($lomba=="IT Contest")
		{
			$validator = Validator::make(
				Input::all(),
				array(
					'judul_karya' => 'required',
					'file_karya'  => 'required|mimes:zip|max:2048',
					'link_video_demo' => 'required|url'
				), $messages
			);
		}
		else
		{
			$validator = Validator::make(
				Input::all(),
				array(
					'judul_karya' => 'required',
					'file_karya'  => 'required|mimes:zip|max:2048',
				), $messages
			);
		}

		if($validator->passes())
		{
			$karya = new Karya();

			$filename = Str::slug($lomba.'_k_'.$tim->id_tim.'_'.$tim->nama_tim);
			$file = new FileManipulation('file_karya', $filename);
			
			if($file->isUploaded())
			{
				$karya->karya = $file->getFileName();

				if ($tim->karya()->save($karya)) {
	            	return Redirect::action('panel.cakrawala.kompetisi.tim.karya.index', array($tim->lomba, $tim->id_tim))->with('success', 'Karya karya berhasil ditambah!');
		        } else {
		            return Redirect::action('panel.cakrawala.kompetisi.tim.karya.create', array($tim->lomba, $tim->id_tim))->withErrors($karya->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
		        }
	        } else {
	            return Redirect::action('panel.cakrawala.kompetisi.tim.karya.create', array($tim->lomba, $tim->id_tim))->withErrors($validator)->with('danger', 'Karya gagal diupload!')->withInput();
	        }
	    }
	    else
	    {
	    	return Redirect::action('panel.cakrawala.kompetisi.tim.karya.create', array($tim->lomba, $tim->id_tim))->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
	    }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($lomba, $tim, $karya)
	{
		return Redirect::action('panel.cakrawala.kompetisi.tim.karya.index', array($lomba, $tim->id_tim));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($lomba, $tim, $karya)
	{
		return View::make('panel.pages.cakrawala.kompetisi.karya.form')->with(array('method' => 'edit', 'lomba' => $lomba, 'tim' => $tim, 'karya' => $karya));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($lomba, $tim, $karya)
	{
		$messages = array(
			'max'    => 'Karya tidak boleh lebih dari 2MB.',
			'url'	=> 'Link tidak valid.'
		);

		if($lomba=="IT Contest")
		{
			$validator = Validator::make(
				Input::all(),
				array(
					'judul_karya' => 'required',
					'file_karya'  => 'required|mimes:zip|max:2048',
					'link_video_demo' => 'required|url'
				), $messages
			);
		}
		else
		{
			$validator = Validator::make(
				Input::all(),
				array(
					'judul_karya' => 'required',
					'file_karya'  => 'required|mimes:zip|max:2048',
				), $messages
			);
		}

		if($validator->passes())
		{
			$filename = Str::slug($lomba.'_k_'.$tim->id_tim.'_'.$tim->nama_tim);
			$file = new FileManipulation('file_karya', $filename);
			
			if($file->isUploaded())
			{
				Helper::deleteFile($karya->karya);

				$karya->karya = $file->getFileName();

				if ($karya->updateUniques()) {
	            	return Redirect::action('panel.cakrawala.kompetisi.tim.karya.index', array($tim->lomba, $tim->id_tim))->with('success', 'Karya karya berhasil diganti!');
		        } else {
		            return Redirect::action('panel.cakrawala.kompetisi.tim.karya.create', array($tim->lomba, $tim->id_tim))->withErrors($karya->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
		        }
	        } else {
	            return Redirect::action('panel.cakrawala.kompetisi.tim.karya.create', array($tim->lomba, $tim->id_tim))->withErrors($validator)->with('danger', 'Karya gagal diupload!')->withInput();
	        }
	    }
	    else
	    {
	    	return Redirect::action('panel.cakrawala.kompetisi.tim.karya.create', array($tim->lomba, $tim->id_tim))->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
	    }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($lomba, $tim, $karya)
	{
		return Redirect::action('panel.cakrawala.kompetisi.tim.karya.index', array($lomba, $tim->id_tim));
	}

	public function download($lomba, $tim, $karya)
	{
		return Response::download(Helper::pathFile($karya->karya, true));
	}
}