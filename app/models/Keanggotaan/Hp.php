<?php 

use LaravelBook\Ardent\Ardent;

class Hp extends Ardent {
    protected $table = 'tb_hp';
    protected $primaryKey = 'kd_hp';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

	protected $guarded = array('kd_hp');

	public static $rules = array(
        'id_anggota' => 'required',
        'no_hp'      => 'required|numeric',
    );

    public function pemilik()
    {
        return $this->belongsTo('Anggota', 'id_anggota');
    }
}
