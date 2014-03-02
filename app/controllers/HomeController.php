<?php 

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	private $acara;

	public function __construct(AcaraRepo $acara)
	{
		$this->acara = $acara;
	}

	public function index()
	{
		$upcoming = $this->acara->findUpcoming();
		return View::make('pages.index')->with('acara', $upcoming);
	}
}