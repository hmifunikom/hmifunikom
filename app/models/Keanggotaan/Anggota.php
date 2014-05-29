<?php namespace HMIF\Model\Keanggotaan;

use LaravelBook\Ardent\Ardent;

class Anggota extends Ardent {
    protected $table = 'tb_keanggotaan';
    protected $primaryKey = 'id_anggota';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

	protected $guarded = array('id_anggota');

	public static $rules = array(
        'nim'       => 'required|numeric|unique:tb_anggota',
        'nama'      => 'required',
        'alamat'    => 'required',
        'asal'      => 'required',
        'id_divisi' => 'required',
        'jabatan'   => 'required',
    );

    public static $relationsData = array(
        'kas'         => array(self::HAS_MANY, 'HMIF\Model\Keanggotaan\Kas', 'foreignKey' => 'id_anggota'),
        'hp'          => array(self::HAS_MANY, 'HMIF\Model\Keanggotaan\Hp', 'foreignKey' => 'id_anggota'),
        'email'       => array(self::HAS_MANY, 'HMIF\Model\Keanggotaan\Email', 'foreignKey' => 'id_anggota'),
        'divisi'      => array(self::BELONGS_TO_MANY, 'HMIF\Model\Keanggotaan\Divisi', 'table' => 'tb_keanggotaan_jabatan', 'foreignKey' => 'id_anggota', 'otherKey' => 'id_divisi', 'pivotKeys' => array('tahun')),
        'kepanitiaan' => array(self::HAS_MANY, 'HMIF\Model\Acara\Panitia', 'foreignKey' => 'id_anggota'),
        'user'        => array(self::BELONGS_TO, 'HMIF\Model\User\User', 'foreignKey' => 'id_user'),
    );

    // public function petugas_perpus()
    // {
    //  return $this->hasMany('Petugas', 'id_anggota');
    // }
}
