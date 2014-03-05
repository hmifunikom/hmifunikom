<?php 

use LaravelBook\Ardent\Ardent;
use Felixkiss\SlugRoutes\SluggableInterface;

class Peserta extends Ardent implements SluggableInterface {
    protected $table = 'peserta';
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
        'nim'          => 'required|numeric',
        'no_hp'        => 'required|numeric',
        'email'        => 'email',
    );

    public function acara()
    {
        return $this->belongsTo('Acara', 'kd_acara');
    }

    public function getSlugIdentifier()
    {
        return 'ticket';
    }

    public function beforeValidate()
    {
        $result = DB::select('SELECT kode FROM peserta WHERE kd_acara = ? ORDER BY kode DESC LIMIT 1', array($this->kd_acara));

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
