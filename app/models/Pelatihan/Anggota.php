<?php namespace HMIF\Model\Pelatihan;

use LaravelBook\Ardent\Ardent;

class Anggota extends Ardent {
    protected $table = 'tb_pelatihan_anggota';
    protected $primaryKey = 'id_anggota';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    protected $fillable = array('nama', 'nim', 'tahun_masuk', 'no_hp', 'email', 'alamat', 'divisi', 'tingkat', 'motivasi');
	protected $guarded = array('id_anggota');

	public static $rules = array(
        'nama'     => 'required',
        'nim'      => 'required|numeric|unique:tb_pelatihan_anggota|nim',
        'tahun_masuk'    => 'required|numeric',
        'no_hp'    => 'required|numeric',
        'email'    => 'required|email',
        'alamat'   => 'required',
        'divisi'   => 'required',
        'tingkat'  => 'required',
        'motivasi' => '',
    );
}
