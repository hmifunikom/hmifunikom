<?php

use HMIF\Model\Acara\Peserta;
use Sabre\VObject\Component\VCard;
use PHPZip\Zip\File\Zip;

class PanelEventPesertaController extends BaseController {
	
	private $peserta;

	public function __construct(PesertaRepo $peserta)
	{
		$this->peserta = $peserta;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($acara)
	{
		if(Input::has('s'))
			$peserta = $this->peserta->findByAcaraSearch($acara->kd_acara, Input::get('s'));
		else if(Input::has('pay'))
			$peserta = $this->peserta->findByAcaraBayar($acara->kd_acara, Input::get('pay'));
		else if(Input::has('cat'))
			$peserta = $this->peserta->findByAcaraKategori($acara->kd_acara, Input::get('cat'));
		else
			$peserta = $this->peserta->findByAcara($acara->kd_acara);

		return View::make('panel.pages.event.peserta.index')->with(array('acara' => $acara, 'listpeserta' => $peserta));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($acara)
	{
		$peserta = new Peserta;
		return View::make('panel.pages.event.peserta.form')->with(array('method' => 'create', 'acara' => $acara, 'peserta' => $peserta));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($acara)
	{
		$peserta = new Peserta();
		$peserta->ticket = str_random(rand(40,50));

		switch(Input::get('kategori'))
		{
			case 'unikom':
				if($acara->sisa_kuota_unikom() <= 0)
					return Redirect::action('panel.event.peserta.create', $acara->kd_acara)->withErrors($peserta->errors())->with('danger', 'Maaf, kuota untuk kategori unikom telah habis')->withInput();
				break;

			case 'luar':
				if($acara->sisa_kuota_umum() <= 0)
					return Redirect::action('panel.event.peserta.create', $acara->kd_acara)->withErrors($peserta->errors())->with('danger', 'Maaf, kuota untuk kategori umum telah habis')->withInput();

				break;

			default:
				return Redirect::action('panel.event.peserta.create', $acara->kd_acara)->withErrors($peserta->errors())->with('danger', 'Kategori peserta tidak valid!')->withInput();
				break;
		}

		if ($acara->peserta()->save($peserta)) {
            return Redirect::action('panel.event.peserta.index', $acara->kd_acara)->with('success', 'Peserta berhasil ditambah!');
        } else {
            return Redirect::action('panel.event.peserta.create', $acara->kd_acara)->withErrors($peserta->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($acara, $peserta)
	{
		Helper::createQR($peserta->ticket);
		return View::make('panel.pages.event.peserta.show')->with(array('acara' => $acara, 'peserta' => $peserta));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($acara, $peserta)
	{
		return View::make('panel.pages.event.peserta.form')->with(array('method' => 'edit', 'acara' => $acara, 'peserta' => $peserta));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($acara, $peserta)
	{
		if($peserta->kategori != Input::get('kategori'))
		{
			switch(Input::get('kategori'))
			{
				case 'unikom':
					if($acara->sisa_kuota_unikom() <= 0)
						return Redirect::action('panel.event.peserta.edit', array($acara->kd_acara, $peserta->id_peserta))->withErrors($peserta->errors())->with('danger', 'Maaf, kuota untuk kategori unikom telah habis')->withInput();
					break;

				case 'luar':
					if($acara->sisa_kuota_umum() <= 0)
						return Redirect::action('panel.event.peserta.edit', array($acara->kd_acara, $peserta->id_peserta))->withErrors($peserta->errors())->with('danger', 'Maaf, kuota untuk kategori umum telah habis')->withInput();

					break;

				default:
					return Redirect::action('panel.event.peserta.edit', array($acara->kd_acara, $peserta->id_peserta))->withErrors($peserta->errors())->with('danger', 'Kategori peserta tidak valid!')->withInput();
					break;
			}
		}

		if ($peserta->updateUniques()) {
            return Redirect::action('panel.event.peserta.index', $acara->kd_acara)->with('success', 'Peserta berhasil diubah!');
        } else {
            return Redirect::action('panel.event.peserta.edit', array($acara->kd_acara, $peserta->id_peserta))->withErrors($peserta->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($acara, $peserta)
	{
		if(! Input::get('safe-action')) return Redirect::back();

		$peserta->delete();
		return Redirect::action('panel.event.peserta.index', $acara->kd_acara)->with('success', 'Peserta berhasil dihapus!');
	}

	public function pay($acara, $peserta)
	{
		if($peserta->bayar == 0)
		{
			$peserta->bayar = 1;
			$status = "sudah";
		}
		else
		{
			$peserta->bayar = 0;
			$status = "belum";
		}

		if ($peserta->updateUniques()) {
            return Redirect::back()->with('success', 'Peserta '.$status.' membayar!');
        } else {
        	//dd($peserta->errors());
            return Redirect::back()->with('success', 'Gagal mengubah status pembayaran!');
        }
	}

	public function xls($acara)
	{
		$filename = Str::slug('Daftar Peserta '. $acara->nama_acara);

		$peserta = $acara->peserta()->orderBy('kode', 'asc');

		$all    = $this->_generateArray($acara->peserta()->orderBy('kode', 'asc')->get());
		$bayar  = $this->_generateArray($acara->peserta()->orderBy('kode', 'asc')->where('bayar', '=', 1)->get());
		$unikom = $this->_generateArray($acara->peserta()->orderBy('kode', 'asc')->where('kategori', '=', 'unikom')->get());
		$umum   = $this->_generateArray($acara->peserta()->orderBy('kode', 'asc')->where('kategori', '=', 'luar')->get());

        Excel::create($filename, function($excel) use($all, $bayar, $unikom, $umum) {

        	$excel->sheet('Semua Peserta', function($sheet) use($all) {
        		$sheet->setColumnFormat(array(
				    'A' => '@',
				    'D' => '@',
				    'E' => '@',
				));
        		$sheet->with($all);
        	});

        	$excel->sheet('Sudah Bayar', function($sheet) use($bayar) {
        		$sheet->setColumnFormat(array(
				    'A' => '@',
				    'D' => '@',
				    'E' => '@',
				));
        		$sheet->with($bayar);
        	});

        	$excel->sheet('Unikom', function($sheet) use($unikom) {
        		$sheet->setColumnFormat(array(
				    'A' => '@',
				    'D' => '@',
				    'E' => '@',
				));
        		$sheet->with($unikom);
        	});

        	$excel->sheet('Umum', function($sheet) use($umum) {
        		$sheet->setColumnFormat(array(
				    'A' => '@',
				    'D' => '@',
				    'E' => '@',
				));
        		$sheet->with($umum);
        	});

		})->export('xls');
	}

	public function vcf($acara)
	{
		$dir = public_path().'/media/vcf/'.Str::slug($acara->nama_acara);

		$zip = new Zip();
		$zip->setZipFile($dir.'-contact.zip');

		foreach($acara->peserta()->get() as $p)
		{
			$vcard = new VCard([
			    'FN'  => $acara->nama_acara.''.$p->kode.''.$p->nama_peserta,
			    'TEL' => $p->no_hp,
			]);

			$data =  $vcard->serialize();
			
			$zip->addFile($data, $acara->nama_acara.'/'.Str::slug($p->kode.''.$p->nama_peserta).'.vcf');
		}
		
		$zip->finalize();

		return Response::download($dir.'-contact.zip');
	}

	private function _generateArray($data)
	{
		$list = [];
		foreach($data as $p)
		{
			$bayar = ($p->bayar)? 'Sudah' : 'Belum';
			$list[] = array(Helper::code($p->kode), $p->nama_peserta, $p->kategori, $p->nim, $p->no_hp, $bayar);
		}

		return $list;
	}
}