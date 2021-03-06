<?php

use HMIF\Model\Acara\Peserta;

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
		return View::make('pages.event.book.show')->with(array('pagetitle' => 'Tiket - '.$acara->nama_acara, 'acara' => $acara, 'ticket' => $ticket));
	}

	public function download($acara, $ticket)
	{
		Helper::createQR($ticket->ticket);
		$html =  View::make('pages.event.book.ticket')->with(array('acara' => $acara, 'ticket' => $ticket))->render();
		$filename = Str::slug(Helper::code($ticket->kode).'_'.$acara->nama_acara.'_'.$ticket->nama_peserta);
		return PDF::load($html, 'A4', 'portrait')->download($filename);
	}
	
	public function email($acara, $peserta)
	{
		Mail::send('emails.event.ticket', array('acara' => $acara, 'ticket' => $peserta), function($message) use ($acara, $peserta){
	    	$message->to($peserta->email, $peserta->nama_peserta)->subject('[TIKET] '.$acara->nama_acara.' - HMIF Unikom');
		});
		
		return Redirect::action('event.book.show', array($acara->slug, $peserta->ticket))->with('success', 'Berhasil! Silahkan download dan cetak tiket dan bawa ketika melakukan pembayaran.');
	}

	public function create($acara)
	{
		$peserta = new Peserta;
		return View::make('pages.event.book.form')->with(array('pagetitle' => 'Pesan Tiket - '.$acara->nama_acara, 'acara' => $acara));
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

		$peserta->validate();

		switch(Input::get('kategori'))
		{
			case 'unikom':
				if($acara->sisa_kuota_unikom() <= 0)
					return Redirect::action('event.book.create', $acara->slug)->withErrors($peserta->errors())->with('danger', 'Maaf, kuota untuk kategori unikom telah habis')->withInput();
				break;

			case 'luar':
				if($acara->sisa_kuota_umum() <= 0)
					return Redirect::action('event.book.create', $acara->slug)->withErrors($peserta->errors())->with('danger', 'Maaf, kuota untuk kategori umum telah habis')->withInput();

				break;

			default:
				return Redirect::action('event.book.create', $acara->slug)->withErrors($peserta->errors())->with('danger', 'Kategori peserta tidak valid!')->withInput();
				break;
		}

		if ($acara->peserta()->save($peserta)) {
		
		if($peserta->email) {
			Mail::send('emails.event.ticket', array('acara' => $acara, 'ticket' => $peserta), function($message) use ($acara, $peserta){
			    $message->to($peserta->email, $peserta->nama_peserta)->subject('[TIKET] '.$acara->nama_acara.' - HMIF Unikom');
			});
		}
		
            return Redirect::action('event.book.show', array($acara->slug, $peserta->ticket))->with('success', 'Berhasil! Silahkan download dan cetak tiket dan bawa ketika melakukan pembayaran.');
        } else {
            return Redirect::action('event.book.create', $acara->slug)->withErrors($peserta->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}
}