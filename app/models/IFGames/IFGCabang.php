<?php

use LaravelBook\Ardent\Ardent;
use Felixkiss\SlugRoutes\SluggableInterface;

class IFGCabang extends Ardent implements SluggableInterface {
    protected $table = 'tb_ifgames_cabang';
    protected $primaryKey = 'id_cabang';

    public $timestamps = false;

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    protected $fillable = array('nama_cabang', 'kuota', 'biaya', 'manager', 'official', 'anggota');
	protected $guarded = array('id_cabang');

	public static $rules = array(
        'nama_cabang' => 'required',
        'kuota'       => 'required|numeric',
        'biaya'       => 'required|numeric',
        'manager'     => 'required|numeric',
        'official'    => 'required|numeric',
        'anggota'     => 'required|numeric',
    );

    public static $sluggable = array(
        'build_from' => 'nama_cabang',
    );

    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery();
        
        $query->orderBy('nama_cabang', 'asc');

        return $query;
    }

    public function jabatan()
    {
        return $this->hasMany('IFGJabatan', 'id_cabang');
    }

    public function tim()
    {
        return $this->hasMany('IFGTim', 'id_cabang');
    }

    public function getSlugIdentifier()
    {
        return 'slug';
    }

    public function sisa_kuota()
    {
        return $this->kuota_unikom - $this->tim()->count();
    }
}