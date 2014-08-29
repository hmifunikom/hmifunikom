<?php namespace HMIF\Model\Cakrawala;

use Qwildz\LocalizedEloquentDate\LocalizedArdent as Ardent;

class Persyaratan extends Ardent {
    protected $table = 'tb_cakrawala_persyaratan';
    protected $primaryKey = 'id_dokumen';

    protected $fillable = array();
	protected $guarded = array('id_dokumen');

	public static $rules = array(
        'persyaratan' => 'required',
    );

    public function documentable()
    {
        return $this->morphTo();
    }
}
