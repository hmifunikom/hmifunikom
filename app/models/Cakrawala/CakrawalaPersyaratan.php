<?php

use LaravelBook\Ardent\Ardent;

class CakrawalaPersyaratan extends Ardent {
    protected $table = 'tb_cakrawala_persyaratan';
    protected $primaryKey = 'id_dokumen';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    protected $fillable = array('persyaratan');
	protected $guarded = array('id_dokumen');

	public static $rules = array(
        'persyaratan' => 'required',
    );

    public function documentable()
    {
        return $this->morphTo();
    }
}
