<?php

use LaravelBook\Ardent\Ardent;

class UserUmum extends Ardent {
    protected $table = 'tb_user_umum';
    protected $primaryKey = 'id_user_umum';

    protected $guarded = array();

    public static $rules = array(
        'nim'       => 'required|numeric',
        'nama'      => 'required|alpha',
        'alamat'    => 'required',
        'asal'      => 'required',
        'id_divisi' => 'required',
    );

    public function credential()
    {
        return $this->hasOne('User', 'id_user');
    }
}
