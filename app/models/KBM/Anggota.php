<?php namespace HMIF\Model\KBM;

use Qwildz\LocalizedEloquentDate\LocalizedArdent as Ardent;

class Anggota extends Ardent {
    protected $table = 'tb_kbm_anggota';
    protected $primaryKey = 'id_anggota';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    protected $fillable = array('nama', 'nim', 'angkatan', 'no_hp', 'matkul');
	protected $guarded = array('id_anggota');

	public static $rules = array(
        'nama'     => 'required',
        'nim'      => 'required|numeric|unique:tb_kbm_anggota|nim',
        'angkatan' => 'required|numeric',
        'no_hp'    => 'required|numeric',
        'matkul'   => 'required',
    );
}
