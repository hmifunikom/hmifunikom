<?php namespace HMIF\Model\Arsip;

use LaravelBook\Ardent\Ardent;

class Dokumen extends Ardent {
    protected $table = 'tb_arsip_dokumen';
    protected $primaryKey = 'id_dokumen';

    protected $guarded = array();

    public static $rules = array();

    protected $dates = array('tgl_upload');
}