<?php namespace HMIF\Model\Keanggotaan;

use LaravelBook\Ardent\Ardent;

class Divisi extends Ardent {
    protected $table = 'tb_keanggotaan_divisi';
    protected $primaryKey = 'id_divisi';

    public $timestamps = false;

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

	protected $guarded = array('id_divisi');

	public static $rules = array(
        'divisi' => 'required',
    );

    public static $relationsData = array(
        'anggota'      => array(self::BELONGS_TO_MANY, 'HMIF\Model\Keanggotaan\Anggota', 'table' => 'tb_keanggotaan_jabatan', 'foreignKey' => 'id_divisi', 'otherKey' => 'id_anggota', 'pivotKeys' => array('tahun')),
    );
}
