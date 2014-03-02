<?php 

use LaravelBook\Ardent\Ardent;

class Email extends Ardent {
    protected $table = 'tb_email';
    protected $primaryKey = 'kd_email';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

	protected $guarded = array('kd_email');

	public static $rules = array(
        'id_anggota' => 'required',
        'email'      => 'required|email',
    );

    public function pemilik()
    {
        return $this->belongsTo('Anggota', 'id_anggota');
    }
}
