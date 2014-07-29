<?php

use HMIF\Model\Cakrawala\Tim;
use HMIF\Model\Cakrawala\User;
use Sabre\VObject\Component\VCard;
use HMIF\Model\Cakrawala\Pembayaran;
use HMIF\Repositories\Cakrawala\TimRepoInterface;
use PHPZip\Zip\File\ZipArchive as ZipArchiveFile;

class PanelCakrawalaKompetisiTimController extends BaseController {

	private $tim;

	public function __construct(TimRepoInterface $tim)
	{
		$this->beforeFilter(function($route) {
		    $param = $route->getParameter('kompetisi');
		    $lomba = array('IT Contest', 'Debat', 'LKTI');
		    if(! in_array($param, $lomba)) App::abort(404);
		});

		$this->tim = $tim;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($lomba)
	{
		if(Input::has('s'))
			$tim = $this->tim->findByLombaSearch($lomba, Input::get('s'));
		else
			$tim = $this->tim->findByLomba($lomba);
		
		return View::make('panel.pages.cakrawala.kompetisi.tim.index')->with(array('lomba' => $lomba, 'listtim' => $tim));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($lomba)
	{
		$tim = new Tim;
		return View::make('panel.pages.cakrawala.kompetisi.tim.form')->with(array('method' => 'create', 'lomba' => $lomba, 'tim' => $tim->load('user')));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($lomba)
	{
		$validator = Validator::make(
			Input::all(),
			array(
				'username'              => 'required|unique:tb_cakrawala_user',
				'email'                 => 'required|email',
				"password"				=> "required|min:8|confirmed",
				"password_confirmation"	=> "same:password",
				
				'nama_tim'              => 'required|unique:tb_cakrawala_kompetisi_tim,nama_tim,NULL,id_tim,lomba,'.$lomba,
				'asal'					=> 'required',
				'alamat'				=> 'required',
				'no_telp'      			=> 'required|numeric',
				'nama_pembimbing'		=> 'required',
			)
		);
	
		if($validator->passes())
		{
			$tim = new Tim();
			$tim->lomba = $lomba;
			$user = new User();
			$user->password = Input::get('password');
			if ($tim->save()) {
				if($tim->user()->save($user))
				{
					$pembayaran = new Pembayaran();
					$pembayaran->setNotVerifying();
					$tim->pembayaran()->save($pembayaran);

            		return Redirect::action('panel.cakrawala.kompetisi.tim.index', $lomba)->with('success', 'Tim berhasil ditambah!');
            	}
            	else
            	{
            		$tim->delete();
            		return Redirect::action('panel.cakrawala.kompetisi.tim.create', $lomba)->withErrors($user->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
            	}
	        } else {
	            return Redirect::action('panel.cakrawala.kompetisi.tim.create', $lomba)->withErrors($tim->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
	        }
		}
		else
		{
			return Redirect::action('panel.cakrawala.kompetisi.tim.create', $lomba)->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($lomba, $tim)
	{
		return View::make('panel.pages.cakrawala.kompetisi.tim.show')->with(array('lomba' => $lomba, 'tim' => $tim));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($lomba, $tim)
	{
		return View::make('panel.pages.cakrawala.kompetisi.tim.form')->with(array('method' => 'edit', 'lomba' => $lomba, 'tim' => $tim->load('user')));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($lomba, $tim)
	{
		$user = $tim->user;

		if(Input::has('password'))
		{
			$validator = Validator::make(
				Input::all(),
				array(
					'username'              => 'required|unique:tb_cakrawala_user,username,'.$tim->user->id_user.',id_user',
					'email'                 => 'required|email',
					"password"				=> "required|min:8|confirmed",
					"password_confirmation"	=> "same:password",

					'nama_tim'              => 'required|unique:tb_cakrawala_kompetisi_tim,nama_tim,'.$tim->id_tim.',id_tim,lomba,'.$lomba,
					'asal'					=> 'required',
					'alamat'				=> 'required',
					'no_telp'      			=> 'required|numeric',
					'nama_pembimbing'		=> 'required',
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
					'username'        => 'required|unique:tb_cakrawala_user,username,'.$tim->user->id_user.',id_user',
					'email'                 => 'required|email',
					
					'nama_tim'        => 'required|unique:tb_cakrawala_kompetisi_tim,nama_tim,'.$tim->id_tim.',id_tim,lomba,'.$lomba,
					'asal'            => 'required',
					'alamat'		  => 'required',
					'no_telp'      	  => 'required|numeric',
					'nama_pembimbing' => 'required',
				)
			);
			
			$passes = $validator->passes();
		}

        if($passes)
		{

			$save_tim = $tim->updateUniques();
			$save_user = $user->updateUniques();

			if(! $save_tim)
			{
	        	return Redirect::action('panel.cakrawala.kompetisi.tim.edit', array($lomba, $tim->id_tim))->withErrors($tim->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');	

			}
			else if(! $save_user)
			{
	        	return Redirect::action('panel.cakrawala.kompetisi.tim.edit', array($lomba, $tim->id_tim))->withErrors($user->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');	
	        	
			}
			else
			{
				return Redirect::action('panel.cakrawala.kompetisi.tim.index', $lomba)->with('success', 'Tim berhasil diubah!');	
			}
		}
		else
		{
			return Redirect::action('panel.cakrawala.kompetisi.tim.edit', array($lomba, $tim->id_tim))->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($lomba, $tim)
	{
		if(! Input::get('safe-action')) return Redirect::back();

		$tim->delete();

		return Redirect::action('panel.cakrawala.kompetisi.tim.index', $lomba)->with('success', 'Tim berhasil dihapus!');
	}

	public function pay($lomba, $tim)
	{
		if($tim->bayar == 0)
		{
			$tim->bayar = 1;
			$status = "sudah";
		}
		else
		{
			$tim->bayar = 0;
			$status = "belum";
		}

		if ($tim->updateUniques()) {
        	return Redirect::back()->with('success', 'Tim '.$status.' membayar!');
        } else {
            return Redirect::back()->with('success', 'Gagal mengubah status pembayaran!');
        }
	}

	public function xls($lomba)
	{
		$filename = Str::slug('Daftar Tim '. $lomba);

		$peserta = Tim::where('lomba', '=', $lomba);

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

	public function vcf($lomba)
	{
		$dir = public_path().'/media/vcf/'.Str::slug($lomba);

		if(! File::isDirectory($dir))
			File::makeDirectory($dir, 755, true);

		$tim = Tim::where('lomba', '=', $lomba)->get();

		foreach($tim as $p)
		{
			$vcard = new VCard([
			    'FN'  => $lomba.'-'.$p->nama_tim,
			    'TEL' => $p->no_telp,
			]);

			$data =  $vcard->serialize();
			File::put($dir.'/'.Str::slug($p->nama_tim).'.vcf', $data);
		}

		if(! File::isDirectory($dir))
			File::delete($dir.'-contact.zip');

		$zip = new ZipArchiveFile();
		$zip->setZipFile($dir.'-contact.zip');
		$zip->addDirectoryContent($dir, $lomba);
		$zip->finalize();

		File::deleteDirectory($dir);

		return Response::download($dir.'-contact.zip');
	}

	public function zip($lomba)
	{
		$file = Helper::pathFile(Str::slug($lomba).'-data.zip', false);

		$zip = new ZipArchiveFile();
		$zip->setZipFile($file);

		$tim = Tim::with(array('karya', 'persyaratan'))->where('lomba', '=', $lomba)->get();

		foreach($tim as $p)
		{
			$zip_path = $lomba."/".$p->nama_tim."/";
			$real_path_persyaratan = Helper::pathFile($p->persyaratan->persyaratan, true);
			$real_path_karya = Helper::pathFile($p->karya->karya, true);


			$zip->addLargeFile($real_path_persyaratan, $zip_path."persyaratan.zip");
			$zip->addLargeFile($real_path_karya, $zip_path."karya.zip");
			$zip->addFile($p->karya->judul_karya, $zip_path."judul.txt");
			$zip->addFile($p->karya->link_video_demo, $zip_path."link_video.txt");
		}
		
		$zip->finalize();

		return Response::download($file);
	}

	private function _generateArray($data)
	{
		$list = [];
		foreach($data as $p)
		{
			$bayar = ($p->bayar)? 'Sudah' : 'Belum';
			$list[] = array($p->nama_tim, $p->kategori, $p->nim, $p->no_hp, $bayar);
		}

		return $list;
	}

}