<?php 

use LaravelBook\Ardent\Ardent;

class Panitia extends Ardent {
    protected $table = 'tb_panitia';
    protected $primaryKey = 'id_panitia';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

	protected $guarded = array();

	public static $rules = array(
        'id_anggota' => 'required',
        'kd_acara'   => 'required',
        'id_div'     => 'required',
        'jabatan'    => 'required'
    );

    public function identitas()
    {
        return $this->belongsTo('Anggota', 'id_anggota');
    }

    public function panitiaAcara()
    {
        return $this->belongsTo('Acara', 'kd_acara');
    }

    public function divisi()
    {
        return $this->belongsTo('DivAcara', 'id_div');
    }
}
