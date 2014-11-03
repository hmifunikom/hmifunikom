<?php namespace HMIF\Model\Keanggotaan;

use Qwildz\LocalizedEloquentDate\LocalizedArdent as Ardent;

class OpRec extends Ardent {
    protected $table = 'lkmm';
    protected $primaryKey = 'id_anggota';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    protected $fillable = array('nim', 'nama', 'panggilan', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'agama', 'alamat', 'alamat_ortu', 'no_hp', 'email', 'kelas', 'angkatan', 'tujuan');
	protected $guarded = array('id_anggota');

	public static $rules = array(
        'nim'           => 'required|numeric|unique:lkmm|nim',
        'nama'          => 'required',
        'panggilan'     => 'required',
        'jenis_kelamin' => 'required',
        'tempat_lahir'  => 'required',
        'tanggal_lahir' => 'required',
        'agama'         => 'required',
        'alamat'        => 'required',
        'alamat_ortu'   => 'required',
        'no_hp'         => 'required|numeric',
        'email'         => 'required|email',
        'kelas'         => 'required',
        'angkatan'      => 'required|numeric',
        'tujuan'        => 'required',
    );
}
