<?php namespace HMIF\Model\Cakrawala;

use LaravelBook\Ardent\Ardent;

class Pembayaran extends Ardent {
    const PAYMENT_NULL = 1;
    const PAYMENT_WAITING = 2;
    const PAYMENT_VERIFIED = 3;
    const PAYMENT_INVALID = 4;

    protected $table = 'tb_cakrawala_pembayaran';
    protected $primaryKey = 'id_pembayaran';

    protected $fillable = array();
	protected $guarded = array('id_pembayaran', 'waiting', 'status', 'bukti_bayar');

	public static $rules = array(
        'waiting'     => 'required',
        'status'      => 'required'
    );

    protected $appends = array('is_verified');

    public function payment()
    {
        return $this->morphTo();
    }

    public function getIsVerifiedAttribute()
    {
        return $this->getPaymentStatus() == static::PAYMENT_VERIFIED;
    }

    public function setNotVerifying()
    {
        $this->attributes['waiting'] = 0;
        $this->attributes['status'] = 0;
    }

    public function setWaitVerifying()
    {
        $this->attributes['waiting'] = 1;
        $this->attributes['status'] = 0;
    }

    public function setVerified()
    {
        $this->attributes['waiting'] = 1;
        $this->attributes['status'] = 1;
    }

    public function setInvalid()
    {
        $this->attributes['waiting'] = 1;
        $this->attributes['status'] = -1;
    }

    public function getPaymentStatus()
    {
        $w = $this->attributes['waiting'];
        $s = $this->attributes['status'];

        if($w == 0 && $s == 0)
            return static::PAYMENT_NULL;
        elseif ($w == 1 && $s == 0)
            return static::PAYMENT_WAITING;
        elseif ($w == 1 && $s == 1)
            return static::PAYMENT_VERIFIED;
        else
            return static::PAYMENT_INVALID;
    }
}
