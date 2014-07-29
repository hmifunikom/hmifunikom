<?php namespace HMIF\Model\Cakrawala;

use LaravelBook\Ardent\Ardent;

class Tim extends Ardent {
    protected $table = 'tb_cakrawala_kompetisi_tim';
    protected $primaryKey = 'id_tim';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    protected $fillable = array('lomba', 'nama_tim', 'asal', 'nama_pembimbing', 'alamat', 'no_telp');
	protected $guarded = array('id_tim');

	public static $rules = array(
        'lomba'           => 'required',
        'nama_tim'        => 'required',
        'asal'            => 'required',
        'alamat'          => 'required',
        'no_telp'         => 'required|numeric',
        'nama_pembimbing' => 'required',
    );

    protected $appends = array('bayar');

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

    public function pembayaran()
    {
        return $this->morphOne('HMIF\Model\Cakrawala\Pembayaran', 'payment');
    }    

    public function sisa_kuota_anggota()
    {
        return 3 - $this->anggota()->count();
    }

    public function anggota_lengkap()
    {
        return $this->sisa_kuota_anggota() < 1;
    }

    public function getBayarAttribute()
    {
        $pembayaran = $this->pembayaran;
        if($pembayaran)
            return $this->pembayaran->isVerified == true;
        else 
            return false;
    }
}
