<?php

use LaravelBook\Ardent\Ardent;

class DivAcara extends Ardent {
    protected $table = 'tb_div_acara';
    protected $primaryKey = 'id_div';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

	protected $guarded = array();

	public static $rules = array(
        'nama_div' => 'required',
        'kd_acara' => 'required',
    );

    public function panitia()
    {
        return $this->hasMany('Panitia', 'id_div');
    }
}
