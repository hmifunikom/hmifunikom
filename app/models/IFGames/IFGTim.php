<?php

use LaravelBook\Ardent\Ardent;

class IFGTim extends Ardent {
    protected $table = 'tb_ifgames_tim';
    protected $primaryKey = 'id_tim';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    protected $fillable = array('angkatan', 'kelas', 'username');
	protected $guarded = array('id_tim', 'password');

	public static $rules = array(
        'angkatan'              => 'required|numeric',
        'kelas'                 => 'required|numeric',
        'username'              => 'required',
        'password'              => 'required|min:4',
    );

    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery();
        
        $query->orderBy('id_tim', 'desc');

        return $query;
    }

    public function cabang()
    {
        return $this->belongsTo('IFGCabang', 'id_cabang');
    }

    public function anggota()
    {
        return $this->hasMany('IFGAnggota', 'id_tim');
    }

    public function sisa_kuota()
    {
        return $this->kuota_unikom - $this->tim()->count();
    }
}