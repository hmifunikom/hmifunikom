<?php namespace HMIF\Model\IFCenter;

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

    public static $relationsData = array(
        'credential'   => array(self::BELONGS_TO, 'HMIF\Model\User\User', 'foreignKey' => 'id_user'),
    );
}
