<?php 

use LaravelBook\Ardent\Ardent;

class Dokumen extends Ardent {
    protected $table = 'tb_dokumen';
    protected $primaryKey = 'id_dokumen';

    protected $guarded = array();

    public static $rules = array();

    protected $dates = array('tgl_upload');
}