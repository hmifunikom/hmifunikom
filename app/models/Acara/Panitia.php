<?php namespace HMIF\Model\Acara;

use Qwildz\LocalizedEloquentDate\LocalizedArdent as Ardent;

class Panitia extends Ardent {
    protected $table = 'tb_acara_panitia';
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

    public static $relationsData = array(
        'panitia' => array(self::BELONGS_TO, 'HMIF\Model\Keanggotaan\Anggota', 'foreignKey' => 'id_anggota'),
        'acara'   => array(self::BELONGS_TO, 'HMIF\Model\Acara\Acara', 'foreignKey' => 'kd_acara'),
        'divisi'  => array(self::BELONGS_TO, 'HMIF\Model\Acara\DivAcara', 'foreignKey' => 'id_div'),
    );
}
