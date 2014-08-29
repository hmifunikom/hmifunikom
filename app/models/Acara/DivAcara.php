<?php namespace HMIF\Model\Acara;

use Qwildz\LocalizedEloquentDate\LocalizedArdent as Ardent;

class DivAcara extends Ardent {
    protected $table = 'tb_acara_divisi';
    protected $primaryKey = 'id_div';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

	protected $guarded = array();

	public static $rules = array(
        'nama_div' => 'required',
        'kd_acara' => 'required',
    );

    public static $relationsData = array(
        'panitia'   => array(self::HAS_MANY, 'HMIF\Model\Acara\Panitia', 'foreignKey' => 'id_div'),
    );
}
