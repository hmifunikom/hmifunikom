<?php

class PanelCakrawalaKompetisiController extends BaseController {

	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('panel.pages.cakrawala.kompetisi.index');
	}
}