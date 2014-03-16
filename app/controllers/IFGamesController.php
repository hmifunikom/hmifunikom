<?php

use IFGTim as Tim;

class IFGamesController extends BaseController {

	public function __construct()
	{
		
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('pages.ifgames.index')->with(array('pagetitle' => 'IF Games'));
	}

	public function pendaftaran()
	{
		return View::make('pages.ifgames.pendaftaran')->with(array('pagetitle' => 'Panduan Pendaftaran - IF Games'));
	}
	
	public function create()
	{
		$tim = new Tim;
		return View::make('pages.ifgames.form')->with(array('pagetitle' => 'Daftar - IF Games', 'tim' => $tim));
	}


}