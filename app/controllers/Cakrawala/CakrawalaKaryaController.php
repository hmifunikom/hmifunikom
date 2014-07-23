<?php

use HMIF\Model\Cakrawala\Karya;
use HMIF\Repositories\Cakrawala\KaryaRepoInterface;

class CakrawalaKaryaController extends BaseController {

	private $karya;
	private $user;
	private $tim;
	private $lomba;

	public function __construct(KaryaRepoInterface $karya)
	{
		$this->beforeFilter(function()
        {
        	if (Auth::cakrawala()->guest()) return Redirect::guest('login'); 
        });

		$this->karya = $karya;
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
		$karya = $this->tim->karya;

		return View::make('pages.cakrawala.karya.index')->with(array('pagetitle' => 'Form Karya', 'lomba' => $this->lomba, 'tim' => $this->tim, 'karya' => $karya));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if($this->tim->bayar != 1)
			return Redirect::action('cakrawala.karya.index');

		if($this->tim->karya)
			return Redirect::action('cakrawala.karya.index');

		$karya = new Karya;
		return View::make('pages.cakrawala.karya.form')->with(array('pagetitle' => 'Upload Karya', 'method' => 'create', 'lomba' => $this->lomba, 'tim' => $this->tim, 'anggota' => $karya));
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
			return Redirect::action('cakrawala.karya.index');

		if($this->tim->karya)
			return Redirect::action('cakrawala.karya.index');


		$messages = array(
			'max'    => 'Karya tidak boleh lebih dari 2MB.',
			'url'	=> 'Link tidak valid.'
		);

		if($this->lomba=="IT Contest")
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

			$filename = Str::slug($this->lomba.'_k_'.$this->tim->id_tim.'_'.$this->tim->nama_tim);
			$file = new FileManipulation('file_karya', $filename);
			
			if($file->isUploaded())
			{
				$karya->karya = $file->getFileName();

				if ($this->tim->karya()->save($karya)) {
	            	return Redirect::action('cakrawala.karya.index')->with('success', 'Karya karya berhasil ditambah!');
		        } else {
		            return Redirect::action('cakrawala.karya.create')->withErrors($karya->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
		        }
	        } else {
	            return Redirect::action('cakrawala.karya.create')->withErrors($validator)->with('danger', 'Karya gagal diupload!')->withInput();
	        }
	    }
	    else
	    {
	    	return Redirect::action('cakrawala.karya.create')->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
	    }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($karya)
	{
		return Redirect::action('cakrawala.karya.index');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($karya)
	{
		if($this->tim->bayar != 1)
			return Redirect::action('cakrawala.karya.index');

		if($karya->tim->id_tim != $this->tim->id_tim) 
			return Redirect::action('cakrawala.karya.index');

		return View::make('pages.cakrawala.karya.form')->with(array('pagetitle' => 'Edit Karya', 'method' => 'edit', 'lomba' => $this->lomba, 'tim' => $this->tim, 'karya' => $karya));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($karya)
	{
		if($this->tim->bayar != 1)
			return Redirect::action('cakrawala.karya.index');

		if($karya->tim->id_tim != $this->tim->id_tim) 
			return Redirect::action('cakrawala.karya.index');

		$messages = array(
			'max'    => 'Karya tidak boleh lebih dari 2MB.',
			'url'	=> 'Link tidak valid.'
		);

		if($this->lomba=="IT Contest")
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
			$filename = Str::slug($this->lomba.'_k_'.$this->tim->id_tim.'_'.$this->tim->nama_tim);
			$file = new FileManipulation('file_karya', $filename);
			
			if($file->isUploaded())
			{
				Helper::deleteFile($karya->karya);

				$karya->karya = $file->getFileName();

				if ($karya->updateUniques()) {
	            	return Redirect::action('cakrawala.karya.index')->with('success', 'Karya karya berhasil diganti!');
		        } else {
		            return Redirect::action('cakrawala.karya.edit', array($karya->id_karya))->withErrors($karya->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
		        }
	        } else {
	            return Redirect::action('cakrawala.karya.edit', array($karya->id_karya))->withErrors($validator)->with('danger', 'Karya gagal diupload!')->withInput();
	        }
	    }
	    else
	    {
	    	return Redirect::action('cakrawala.karya.edit', array($karya->id_karya))->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
	    }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($karya)
	{
		if($this->tim->bayar != 1)
			return Redirect::action('cakrawala.karya.index');

		if($karya->tim->id_tim != $this->tim->id_tim) 
			return Redirect::action('cakrawala.karya.index');

		if(! Input::get('safe-action')) return Redirect::back();

		if($karya->foto)
		{
			Helper::deleteMedia($karya->foto);
		}

		$karya->delete();
		return Redirect::action('cakrawala.karya.index')->with('success', 'Karya berhasil dihapus!');
	}

	public function download($karya)
	{
		if($karya->tim->id_tim != $this->tim->id_tim) 
			return Redirect::action('cakrawala.karya.index');

		return Response::download(Helper::pathFile($karya->karya, true));
	}
}