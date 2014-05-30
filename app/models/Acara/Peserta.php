<?php namespace HMIF\Model\Acara;

use Qwildz\Ardent\Ardent;
use Felixkiss\SlugRoutes\SluggableInterface;
use DB;

class Peserta extends Ardent implements SluggableInterface {
    protected $table = 'tb_acara_peserta';
    protected $primaryKey = 'id_peserta';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

	protected $guarded = array('id_peserta', 'kd_acara');

    protected $dates = array('tgl_daftar');

	public static $rules = array(
        'nama_peserta' => 'required',
        'alamat'       => 'required',
        'kategori'     => 'required',
        'kd_acara'     => 'required',
        'tgl_daftar'   => 'required|date',
        'nim'          => 'required_if:kategori,unikom|numeric|nim_if:kategori,unikom|unique_if:tb_acara_peserta,kd_acara,kategori,luar',
        'no_hp'        => 'required|numeric',
        'email'        => 'email',
    );

    public static $relationsData = array(
        'acara'   => array(self::BELONGS_TO, 'HMIF\Model\Acara\Acara', 'foreignKey' => 'kd_acara'),
    );

    public function getSlugIdentifier()
    {
        return 'ticket';
    }

    public function beforeValidate()
    {
        $exist = $this->find($this->id_peserta);

        if(! $exist)
        {
            $result = DB::select('SELECT kode FROM tb_acara_peserta WHERE kd_acara = ? ORDER BY kode DESC LIMIT 1', array($this->kd_acara));

            if($result)
            {
                $this->kode = $result[0]->kode + 1;
            }
            else
            {
                $this->kode = 1;
            }
        }
    }
}