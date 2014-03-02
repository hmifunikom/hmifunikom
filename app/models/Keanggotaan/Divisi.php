<?php 

use LaravelBook\Ardent\Ardent;

class Divisi extends Ardent {
    protected $table = 'tb_divisi';
    protected $primaryKey = 'id_divisi';

    public $timestamps = false;

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

	protected $guarded = array('id_divisi');

	public static $rules = array(
        'divisi' => 'required',
    );

    public function anggota()
    {
        return $this->hasMany('Anggota', 'id_divisi');
    }
}
