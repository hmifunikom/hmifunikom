<?php

use LaravelBook\Ardent\Ardent;

class CakrawalaKompetisiAnggota extends Ardent {
    protected $table = 'tb_cakrawala_kompetisi_anggota';
    protected $primaryKey = 'id_anggota';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    protected $fillable = array('nama_anggota', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'no_telp');
	protected $guarded = array('id_anggota', 'id_tim');

    protected $dates = array('tanggal_lahir');

	public static $rules = array(
        'nama_anggota'  => 'required',
        'tempat_lahir'  => 'required',
        'tanggal_lahir' => 'required|date',
        'alamat'        => 'required',
        'no_telp'       => 'required|numeric',
    );

    public function tim()
    {
        return $this->belongsTo('CakrawalaKompetisiTim', 'id_tim');
    }
}
