<?php

class EventBookController extends BaseController {

	private $acara;

	public function __construct(AcaraRepo $acara)
	{
		$this->acara = $acara;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function show($acara, $ticket)
	{
		Helper::createQR($ticket->ticket);
		return View::make('pages.event.book.show')->with(array('acara' => $acara, 'ticket' => $ticket));
	}

	public function create($acara)
	{
		$peserta = new Peserta;
		return View::make('pages.event.book.form')->with(array('acara' => $acara));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($acara)
	{
		$peserta = new Peserta();
		$peserta->tgl_daftar = Carbon::now()->toDateString();
		$peserta->ticket = str_random(rand(40,50));
		if ($acara->peserta()->save($peserta)) {
            return Redirect::action('event.book.show', array($acara->kd_acara, $peserta->ticket))->with('success', 'Berhasil! Silahkan cetak tiket di bawah ini.');
        } else {
            return Redirect::action('event.book.create', $acara->kd_acara)->withErrors($peserta->errors())->with('alert', 'Harap perbaiki kesalahan di bawah!');
        }
	}
}