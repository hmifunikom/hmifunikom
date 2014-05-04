<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use LaravelBook\Ardent\Ardent;

class IFGTim extends Ardent implements UserInterface, RemindableInterface {
    protected $table = 'tb_ifgames_tim';
    protected $primaryKey = 'id_tim';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    protected $fillable = array('nama_tim', 'username');
	protected $guarded = array('id_tim', 'password', 'bayar');

	public static $rules = array(
        'nama_tim'              => 'required',
        'username'              => 'required',
    );

    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery();
        
        $query->orderBy('id_tim', 'desc');

        return $query;
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return null;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function cabang()
    {
        return $this->belongsTo('IFGCabang', 'id_cabang');
    }

    public function anggotatim()
    {
        return $this->hasMany('IFGAnggotaTim', 'id_tim');
    }

    public function sisa_kuota_manager()
    {
        return $this->cabang->manager - $this->anggotatim()->where('jabatan', '=', 'manager')->count();
    }

    public function sisa_kuota_official()
    {
        return $this->cabang->official - $this->anggotatim()->where('jabatan', '=', 'official')->count();
    }

    public function sisa_kuota_anggota()
    {
        return $this->cabang->anggota - $this->anggotatim()->where('jabatan', '=', 'anggota')->count();
    }

    public function anggota_lengkap()
    {
        return $this->sisa_kuota_manager() < 1 && $this->sisa_kuota_official() < 1 && $this->sisa_kuota_anggota() < 1;
    }

    public function dokumen_lengkap()
    {
        if($this->anggota_lengkap() == false) return false;
        
        $result = DB::select('select *  from `tb_ifgames_anggota` where `tb_ifgames_anggota`.`id_tim` = '.$this->id_tim.' and (`ska` = 0 or `ktm` = 0)');

        return $result == false;
    }
}