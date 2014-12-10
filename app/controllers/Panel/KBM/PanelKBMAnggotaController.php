<?php

use HMIF\Model\KBM\Anggota;
use Sabre\VObject\Component\VCard;
use PHPZip\Zip\File\Zip;

class PanelKBMAnggotaController extends BaseController {

    private $anggota;

    public function __construct(KBMAnggotaRepo $anggota)
    {
        $this->anggota = $anggota;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $anggota = $this->anggota->findAll();
        return View::make('panel.pages.kbm.anggota.index')->with(array('listanggota' => $anggota));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $anggota = new Anggota;
        return View::make('panel.pages.kbm.anggota.form')->with(array('method' => 'create'));
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
                'nama'                     => 'required',
                'nim'                      => 'required|numeric|unique:tb_kbm_anggota|nim',
                'tahun_masuk'              => 'required|numeric',
                'no_hp'                    => 'required|numeric',
                'email'                    => 'required|email',
                'alamat'                   => 'required',
                'divisi'                   => 'required',
                'tingkat'                  => 'required',
                'motivasi'                 => '',
            )
        );

        if($validator->passes())
        {
            $anggota = new Anggota();

            if ($anggota->save()) {
                return Redirect::action('panel.kbm.anggota.index')->with('success', 'Anggota berhasil ditambahkan!');
            } else {
                return Redirect::action('panel.kbm.anggota.create')->withErrors($anggota->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
            }
        }
        else
        {
            return Redirect::action('panel.kbm.anggota.create')->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $anggota
     * @return Response
     */
    public function show($anggota)
    {
        //return View::make('panel.pages.kbm.anggota.form')->with(array('method' => 'create'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $anggota
     * @return Response
     */
    public function edit($anggota)
    {
        return View::make('panel.pages.kbm.anggota.form')->with(array('method' => 'edit', 'anggota' => $anggota));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $anggota
     * @return Response
     */
    public function update($anggota)
    {
        // if ($anggota->save()) {
        //     return Redirect::action('panel.ifgames.index')->with('success', 'Anggota berhasil diubah!');
        // } else {
        //     return Redirect::action('panel.ifgames.edit', $anggota->id_anggota)->withErrors($anggota->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
        // }
        $validator = Validator::make(
            Input::all(),
            array(
                'nama'     => 'required',
                'nim'   => 'required|numeric|nim|unique:tb_kbm_anggota,nim,'.$anggota->id_anggota.',id_anggota',
                'angkatan' => 'required|numeric',
                'no_hp'    => 'required|numeric',
                'matkul'   => 'required',
            )
        );

        if($validator->passes())
        {
            if ($anggota->updateUniques()) {
                return Redirect::action('panel.kbm.anggota.index')->with('success', 'Anggota berhasil diubah!');
            } else {
                return Redirect::action('panel.kbm.anggota.edit', $anggota->id_anggota)->withErrors($anggota->errors())->with('danger', 'Harap perbaiki kesalahan di bawah!');
            }
        }
        else
        {
            return Redirect::action('panel.kbm.anggota.edit', $anggota->id_anggota)->withErrors($validator)->with('danger', 'Harap perbaiki kesalahan di bawah!')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $anggota
     * @return Response
     */
    public function destroy($anggota)
    {
        if(! Input::get('safe-action')) return Redirect::back();

        $anggota->delete();
        return Redirect::action('panel.kbm.anggota.index')->with('success', 'Anggota berhasil dihapus!');
    }

    public function xls()
    {
        $filename = Str::slug('Daftar Peserta KBM');

        $peserta = Anggota::all();

        $all = $this->_generateArray($peserta);

        Excel::create($filename, function($excel) use($all) {

            $excel->sheet('Peserta', function($sheet) use($all) {
                $sheet->setColumnFormat(array(
                    'E' => '@',
                ));
                $sheet->with($all);
            });

        })->export('xls');
    }

    public function vcf()
    {
        $dir = public_path().'/media/vcf/kbm';

        $zip = new Zip();
        $zip->setZipFile($dir.'-contact.zip');

        $peserta = Anggota::all();

        foreach($peserta as $p)
        {
            $vcard = new VCard([
                'FN'  => $p->nama,
                'TEL' => $p->no_hp,
            ]);

            $data =  $vcard->serialize();

            $zip->addFile($data, Str::slug($p->nama).'.vcf');
        }

        $zip->finalize();

        return Response::download($dir.'-contact.zip');
    }

    private function _generateArray($data)
    {
        $list = [];
        $i = 1;
        foreach($data as $p)
        {
            $list[] = array(
                'No'          => $i,
                'Nama'        => $p->nama,
                'NIM'         => $p->nim,
                'Angkatan'    => $p->angkatan,
                'No. HP'      => ' ' . $p->no_hp,
                'Mata Kuliah' => $p->matkul
            );
            $i++;
        }

        return $list;
    }
}