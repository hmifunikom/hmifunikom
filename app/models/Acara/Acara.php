<?php

use LaravelBook\Ardent\Ardent;
use Felixkiss\SlugRoutes\SluggableInterface;

class Acara extends Ardent implements SluggableInterface {
    protected $table = 'tb_acara';
    protected $primaryKey = 'kd_acara';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

	protected $guarded = array('kd_acara');

	public static $rules = array(
        'nama_acara'      => 'required',
        'tgl'             => 'required|date',
        'tempat'          => 'required|max:30',
        'info'            => '',
        'pj'              => 'required',
        'tgl_selesai_LPJ' => '',
        'tema'            => 'required',
    );

    protected $dates = array('tgl', 'tgl_selesai_LPJ');

    public static $sluggable = array(
        'build_from' => 'nama_acara',
    );

    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery();
        
        $query->orderBy('tgl', 'asc');

        return $query;
    }

    public function waktu()
    {
        return $this->hasMany('WaktuAcara', 'kd_acara');
    }

    public function peserta()
    {
        return $this->hasMany('Peserta', 'kd_acara');
    }

    public function panitia()
    {
        return $this->hasMany('Panitia', 'kd_acara');
    }

    public function divisi()
    {
        return $this->hasMany('DivAcara', 'kd_acara');
    }

    public function getSlugIdentifier()
    {
        return 'slug';
    }
}