<?php namespace HMIF\Model\Cakrawala;

use Qwildz\LocalizedEloquentDate\LocalizedArdent as Ardent;
use DB;

class TcrPeserta extends Ardent {
    protected $table = 'tb_cakrawala_tcr_peserta';
    protected $primaryKey = 'id_peserta';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    protected $fillable = array('nama_peserta', 'alamat', 'no_telp');
	protected $guarded = array('id_peserta');

	public static $rules = array(
        'nama_peserta'        => 'required',
        'alamat'          => 'required',
        'no_telp'         => 'required|numeric',
    );

    protected $appends = array('bayar');

    public static function boot()
    {
        parent::boot();

        static::deleting(function($peserta)
        {
            $peserta->user()->delete();
            $peserta->pembayaran()->delete();
        });
    }

    public function user()
    {
        return $this->morphOne('HMIF\Model\Cakrawala\User', 'userable');
    }    

    public function pembayaran()
    {
        return $this->morphOne('HMIF\Model\Cakrawala\Pembayaran', 'payment');
    }    

    public function getBayarAttribute()
    {
        $pembayaran = $this->pembayaran;
        if($pembayaran)
            return $this->pembayaran->isVerified == true;
        else 
            return false;
    }

    public function beforeValidate()
    {
        $exist = $this->find($this->id_peserta);

        if(! $exist)
        {
            $result = DB::select('SELECT kode FROM tb_cakrawala_tcr_peserta ORDER BY kode DESC LIMIT 1');

            if($result)
            {
                $this->kode = $result[0]->kode + 1;
            }
            else
            {
                $this->kode = 1;
            }
        }
    }
}
