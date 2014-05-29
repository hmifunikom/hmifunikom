<?php

use HMIF\Model\Acara\Acara;

class EventController extends BaseController {

	private $acara;

	public function __construct(AcaraRepo $acara)
	{
		$this->acara = $acara;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$date = Carbon::now();

		if(Input::has('month'))
		{
			$date = $date->month(Input::get('month'));
		}

		if(Input::has('year'))
		{
			$date = $date->year(Input::get('year'));
		}
		
		$acara = $this->acara->findByMonth($date);
		$total = $this->acara->findByYear($date)->getTotal();

		return View::make('pages.event.index')->with(array('pagetitle' => 'Event' , 'date' => $date, 'listacara' => $acara, 'total' => $total));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Acara $acara)
	{
		return View::make('pages.event.item')->with(array('pagetitle' => $acara->nama_acara, 'acara' => $acara));
	}
}