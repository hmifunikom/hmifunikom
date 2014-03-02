<?php

use LaravelBook\Ardent\Ardent;

class Anggota extends Ardent {
    protected $table = 'tb_anggota';
    protected $primaryKey = 'id_anggota';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

	protected $guarded = array('id_anggota');

	public static $rules = array(
        'nim'       => 'required|numeric|unique:tb_anggota',
        'nama'      => 'required',
        'alamat'    => 'required',
        'asal'      => 'required',
        'id_divisi' => 'required',
        'jabatan'   => 'required',
    );

    public function kas()
    {
        return $this->hasMany('Kas', 'id_anggota');
    }

    public function hp()
    {
        return $this->hasMany('Hp', 'id_anggota');
    }

    public function email()
    {
        return $this->hasMany('Email', 'id_anggota');
    }

    public function divisi()
    {
        return $this->belongsTo('Divisi', 'id_divisi');
    }    

    public function kepanitiaan()
    {
        return $this->hasMany('Panitia', 'id_anggota');
    }

    public function user()
    {
        return $this->hasOne('user', 'id_anggota');
    }

    // public function petugas_perpus()
    // {
    //  return $this->hasMany('Petugas', 'id_anggota');
    // }
}
