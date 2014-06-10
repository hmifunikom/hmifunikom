<?php namespace HMIF\Model\Cakrawala;

use Qwildz\Ardent\Ardent;

class Tim extends Ardent {
    protected $table = 'tb_cakrawala_kompetisi_tim';
    protected $primaryKey = 'id_tim';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    protected $fillable = array('lomba', 'nama_tim', 'kategori', 'asal', 'nama_pembimbing', 'alamat');
	protected $guarded = array('id_tim', 'bayar');

	public static $rules = array(
        'lomba'           => 'required',
        'nama_tim'        => 'required',
        'kategori'        => 'required',
        'asal'            => 'required',
        'nama_pembimbing' => 'required_if:kategori,SMA',
        'alamat'          => 'required',
    );

    public function anggota()
    {
        return $this->hasMany('HMIF\Model\Cakrawala\Anggota', 'id_tim');
    }

    public function karya()
    {
        return $this->hasOne('HMIF\Model\Cakrawala\Karya', 'id_tim');
    }

    public function persyaratan()
    {
        return $this->morphOne('HMIF\Model\Cakrawala\Persyaratan', 'documentable');
    }

    public function user()
    {
        return $this->morphOne('HMIF\Model\Cakrawala\User', 'userable');
    }    

    public function sisa_kuota_anggota()
    {
        return 3 - $this->anggota()->count();
    }
}
