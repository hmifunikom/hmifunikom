<?php

use HMIF\Model\IFGames\Tim;

class PanelIFGamesTimController extends BaseController {

	private $tim;

	public function __construct(TimRepo $tim)
	{
		$this->tim = $tim;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($cabang)
	{
		$tim = $this->tim->findByCabang($cabang->id_cabang);
		return View::make('panel.pages.ifgames.tim.index')->with(array('cabang' => $cabang, 'listtim' => $tim));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($cabang)
	{
		$tim = new Tim;
		return View::make('panel.pages.ifgames.tim.form')->with(array('method' => 'create', 'cabang' => $cabang, 'tim' => $tim));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($cabang)
	{
		if($cabang->anggota < 2)
		{
			$validator = Validator::make(
				Input::all(),
				array(
					'username'              => 'required|unique:tb_ifgames_tim',
					"password"				=> "required|min:4|confirmed",
					"password_confirmation"	=> "same:password",
					'nama_peserta'              => 'required|unique:tb_ifgames_tim,nama_tim,NULL,id_tim,id_cabang,'.$cabang->id_cabang,
				)
			);
		}
		else
		{
			$validator = Validator::make(
				Input::all(),
				array(
					'username'              => 'required|unique:tb_ifgames_tim',
					"password"				=> "required|min:4|confirmed",
					"password_confirmation"	=> "same:password",
					'nama_tim'              => 'required|unique:tb_ifgames_tim,nama_tim,NULL,id_tim,id_cabang,'.$cabang->id_cabang,
				)
			);
		}

		if($validator->passes())
		{
			$tim = new Tim();
			if($cabang->anggota < 2) $tim->nama_tim = Input::get('nama_peserta');
			$tim->password = Hash::make(Input::get('password'));
			if ($cabang->tim()->save($tim)) {
				if($cabang->anggota < 2)
	            	return Redirect::action('panel.ifgames.tim.index', $cabang->id_cabang)->with('success', 'Tim berhasil ditambah!');
	            else
	            	return Redirect::action('panel.ifgames.tim.index', $cabang->id_cabang)->with('success', 'Peserta berhasil ditambah!');
	        } else {
	            return Redirect::action('panel.ifgames.tim.create', $cabang->id_cabang)->withErrors($tim->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
	        }
		}
		else
		{
			return Redirect::action('panel.ifgames.tim.create', $cabang->id_cabang)->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($cabang, $tim)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($cabang, $tim)
	{
		$tim->nama_peserta = $tim->nama_tim;
		return View::make('panel.pages.ifgames.tim.form')->with(array('method' => 'edit', 'cabang' => $cabang, 'tim' => $tim));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($cabang, $tim)
	{
		if(Input::has('password'))
		{
			if($tim->cabang->anggota < 2)
			{
				$validator = Validator::make(
					Input::all(),
					array(
						'username'              => 'required|unique:tb_ifgames_tim,username,'.$tim->id_tim.',id_tim',
						"password"				=> "required|min:4|confirmed",
						"password_confirmation"	=> "same:password",
						'nama_peserta'              => 'required|unique:tb_ifgames_tim,nama_tim,'.$tim->id_tim.',id_tim,id_cabang,'.$tim->cabang->id_cabang,
					)
				);
			}
			else
			{
				$validator = Validator::make(
					Input::all(),
					array(
						'username'              => 'required|unique:tb_ifgames_tim,username,'.$tim->id_tim.',id_tim',
						"password"				=> "required|min:4|confirmed",
						"password_confirmation"	=> "same:password",
						'nama_tim'              => 'required|unique:tb_ifgames_tim,nama_tim,'.$tim->id_tim.',id_tim,id_cabang,'.$tim->cabang->id_cabang,
					)
				);
			}

			$passes = $validator->passes();

			if($passes)
			{
				$tim->password = Hash::make(Input::get('password'));
			}
		}
		else
		{
			if($tim->cabang->anggota < 2)
			{
				$validator = Validator::make(
					Input::all(),
					array(
						'username'     => 'required|unique:tb_ifgames_tim,username,'.$tim->id_tim.',id_tim',
						'nama_peserta' => 'required|unique:tb_ifgames_tim,nama_tim,'.$tim->id_tim.',id_tim,id_cabang,'.$tim->cabang->id_cabang,
					)
				);
			}
			else
			{
				$validator = Validator::make(
					Input::all(),
					array(
						'username' => 'required|unique:tb_ifgames_tim,username,'.$tim->id_tim.',id_tim',
						'nama_tim' => 'required|unique:tb_ifgames_tim,nama_tim,'.$tim->id_tim.',id_tim,id_cabang,'.$tim->cabang->id_cabang,
					)
				);
			}
			
			$passes = $validator->passes();
		}

		if ($passes)
		{
			if($tim->cabang->anggota < 2) $tim->nama_tim = Input::get('nama_peserta');

			if($tim->updateUniques())
			{
				if($cabang->anggota > 1)
		        	return Redirect::action('panel.ifgames.tim.index', $cabang->id_cabang)->with('success', 'Tim berhasil diubah!');	
		        else
		        	return Redirect::action('panel.ifgames.tim.index', $cabang->id_cabang)->with('success', 'Peserta berhasil diubah!');	
			}
			else
			{
				return Redirect::action('panel.ifgames.tim.edit', array($cabang->id_cabang, $tim->id_tim))->withErrors($tim->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');	
			}
        } else {
            return Redirect::action('panel.ifgames.tim.edit', array($cabang->id_cabang, $tim->id_tim))->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($cabang, $tim)
	{
		if(! Input::get('safe-action')) return Redirect::back();

		$tim->delete();

		if($cabang->anggota > 1)
        	return Redirect::action('panel.ifgames.tim.index', $cabang->id_cabang)->with('success', 'Tim berhasil dihapus!');
        else
        	return Redirect::action('panel.ifgames.tim.index', $cabang->id_cabang)->with('success', 'Peserta berhasil dihapus!');
		
	}

	public function pay($cabang, $tim)
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
            if($cabang->anggota > 1)
	        	return Redirect::back()->with('success', 'Tim '.$status.' membayar!');
	        else
	        	return Redirect::back()->with('success', 'Peserta '.$status.' membayar!');
        } else {
            return Redirect::back()->with('success', 'Gagal mengubah status pembayaran!');
        }
	}

}