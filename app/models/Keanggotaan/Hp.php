<?php namespace HMIF\Model\Keanggotaan;

use LaravelBook\Ardent\Ardent;

class Hp extends Ardent {
    protected $table = 'tb_keanggotaan_hp';
    protected $primaryKey = 'kd_hp';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

	protected $guarded = array('kd_hp');

	public static $rules = array(
        'id_anggota' => 'required',
        'no_hp'      => 'required|numeric',
    );

    public static $relationsData = array(
        'pemilik' => array(self::BELONGS_TO, 'HMIF\Model\Keanggotaan\Anggota', 'foreignKey' => 'id_anggota'),
    );
}
