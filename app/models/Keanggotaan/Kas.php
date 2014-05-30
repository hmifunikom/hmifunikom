<?php namespace HMIF\Model\Keanggotaan;

use Qwildz\Ardent\Ardent;

class Kas extends Ardent {
    protected $table = 'tb_keanggotaan_kas';
    protected $primaryKey = 'kd_kas';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

	protected $guarded = array('kd_kas');

	public static $rules = array(
        'id_anggota' => 'required',
        'bulan'      => 'required|date',
    );

    protected $dates = array('bulan');

    public static $relationsData = array(
        'pemilik' => array(self::BELONGS_TO, 'HMIF\Model\Keanggotaan\Anggota', 'foreignKey' => 'id_anggota'),
    );

    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery();
        
        $query->orderBy('bulan', 'desc');

        return $query;
    }
}
