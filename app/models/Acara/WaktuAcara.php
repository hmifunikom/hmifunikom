<?php namespace HMIF\Model\Acara;

use Qwildz\Ardent\Ardent;

class WaktuAcara extends Ardent {
    protected $table = 'tb_acara_waktu';
    protected $primaryKey = 'id_waktu';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

	protected $guarded = array();

	public static $rules = array(
        'kd_acara' => 'required',
        'waktu'    => 'required',
    );

    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery();
        
        $query->orderBy('waktu', 'asc');

        return $query;
    }
}
