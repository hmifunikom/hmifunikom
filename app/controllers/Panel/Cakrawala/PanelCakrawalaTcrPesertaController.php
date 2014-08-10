<?php

use HMIF\Model\Cakrawala\TcrPeserta;
use HMIF\Model\Cakrawala\User;
use Sabre\VObject\Component\VCard;
use HMIF\Model\Cakrawala\Pembayaran;
use HMIF\Repositories\Cakrawala\TcrPesertaRepoInterface;
use PHPZip\Zip\File\Zip;

class PanelCakrawalaTcrPesertaController extends BaseController {

	private $peserta;

	public function __construct(TcrPesertaRepoInterface $peserta)
	{
		$this->peserta = $peserta;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Input::has('s'))
			$peserta = $this->peserta->findAllSearch(Input::get('s'));
		else
			$peserta = $this->peserta->findAll();
		return View::make('panel.pages.cakrawala.tcr.index')->with(array('listpeserta' => $peserta));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$peserta = new TcrPeserta;
		return View::make('panel.pages.cakrawala.tcr.form')->with(array('method' => 'create', 'peserta' => $peserta->load('user')));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make(
			Input::all(),
			array(
				'username'              => 'required|unique:tb_cakrawala_user',
				'email'                 => 'required|email|unique:tb_cakrawala_user',
				"password"              => "required|min:8|confirmed",
				"password_confirmation" => "same:password",
				
				'nama_peserta'          => 'required',
				'alamat'                => 'required',
				'no_telp'               => 'required|numeric',
			)
		);
	
		if($validator->passes())
		{
			$peserta = new TcrPeserta();

			$user = new User();
			$user->password = Input::get('password');
			if ($peserta->save()) {
				if($peserta->user()->save($user))
				{
					$pembayaran = new Pembayaran();
					$pembayaran->setNotVerifying();
					$peserta->pembayaran()->save($pembayaran);

            		return Redirect::action('panel.cakrawala.tcr.index')->with('success', 'Peserta berhasil ditambah!');
            	}
            	else
            	{
            		$peserta->delete();
            		var_dump($user->errors());die();
            		return Redirect::action('panel.cakrawala.tcr.create')->withErrors($user->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
            	}
	        } else {
	        	var_dump($peserta->errors());die();
	            return Redirect::action('panel.cakrawala.tcr.create')->withErrors($peserta->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
	        }
		}
		else
		{
			var_dump($validator);die();
			return Redirect::action('panel.cakrawala.tcr.create')->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($peserta)
	{
		return View::make('panel.pages.cakrawala.tcr.show')->with(array('peserta' => $peserta));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($peserta)
	{
		return View::make('panel.pages.cakrawala.tcr.form')->with(array('method' => 'edit', 'peserta' => $peserta->load('user')));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($peserta)
	{
		$user = $peserta->user;

		if(Input::has('password'))
		{
			$validator = Validator::make(
				Input::all(),
				array(
					'username'              => 'required|unique:tb_cakrawala_user,username,'.$peserta->user->id_user.',id_user',
					'email'                 => 'required|email|unique:tb_cakrawala_user,email,'.$peserta->user->id_user.',id_user',
					"password"				=> "required|min:8|confirmed",
					"password_confirmation"	=> "same:password",

					'nama_peserta'          => 'required',
					'alamat'				=> 'required',
					'no_telp'      			=> 'required|numeric',
				)
			);

			$passes = $validator->passes();

			if($passes)
			{
				$user->password = Input::get('password');
			}
		}
		else
		{
			$validator = Validator::make(
				Input::all(),
				array(
					'username'        => 'required|unique:tb_cakrawala_user,username,'.$peserta->user->id_user.',id_user',
					'email'           => 'required|email|unique:tb_cakrawala_user,email,'.$peserta->user->id_user.',id_user',
					
					'nama_peserta'          => 'required',
					'alamat'				=> 'required',
					'no_telp'      			=> 'required|numeric',
				)
			);
			
			$passes = $validator->passes();
		}

        if($passes)
		{
			$save_peserta = $peserta->updateUniques();
			$save_user = $user->updateUniques();

			if(! $save_peserta)
			{
	        	return Redirect::action('panel.cakrawala.tcr.edit', array($peserta->id_peserta))->withErrors($peserta->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');	

			}
			else if(! $save_user)
			{
	        	return Redirect::action('panel.cakrawala.tcr.edit', array($peserta->id_peserta))->withErrors($user->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');	
	        	
			}
			else
			{
				return Redirect::action('panel.cakrawala.tcr.index')->with('success', 'Peserta berhasil diubah!');	
			}
		}
		else
		{
			return Redirect::action('panel.cakrawala.tcr.edit', array($peserta->id_peserta))->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($peserta)
	{
		if(! Input::get('safe-action')) return Redirect::back();

		$peserta->delete();

		return Redirect::action('panel.cakrawala.tcr.index')->with('success', 'Peserta berhasil dihapus!');
	}

	public function xls()
	{
		$filename = Str::slug('Daftar Peserta The Color Run');

		$peserta = new TcrPeserta;

		$all    = $this->_generateArray($peserta->orderBy('kode', 'asc')->get());
		$bayar  = array_where($all, function ($key, $value)
		{
			return $value['Bayar'] == 'Sudah';
		});
		
        Excel::create($filename, function($excel) use($all, $bayar) {

        	$excel->sheet('Semua Peserta', function($sheet) use($all) {
        		$sheet->setColumnFormat(array(
				    'A' => '@',
				    'C' => '@',
				));
        		$sheet->with($all);
        	});

        	$excel->sheet('Sudah Bayar', function($sheet) use($bayar) {
        		$sheet->setColumnFormat(array(
				    'A' => '@',
				    'C' => '@',
				));
        		$sheet->with($bayar);
        	});

		})->export('xls');
	}

	public function vcf()
	{
		$dir = public_path().'/media/vcf/'.Str::slug('tcr');

		$zip = new Zip();
		$zip->setZipFile($dir.'-contact.zip');

		$peserta = TcrPeserta::all();

		foreach($peserta as $p)
		{
			$vcard = new VCard([
			    'FN'  => Helper::code($p->kode, 'TCR-', 4) . '-'.$p->nama_peserta,
			    'TEL' => $p->no_telp,
			]);

			$data =  $vcard->serialize();

			$zip->addFile($data, 'tcr/'.Str::slug($p->nama_peserta).'.vcf');
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
			$list[] = array(
							'Kode'     => Helper::code($p->kode, 'TCR-', 4),
							'Nama'     => $p->nama_peserta, 
							'Alamat'   => $p->alamat,
							'No. Telp' => ' '.$p->no_telp,
							'Bayar'    => $bayar
						);
		}

		return $list;
	}

}