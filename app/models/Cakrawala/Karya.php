<?php namespace HMIF\Model\Cakrawala;

use Qwildz\Ardent\Ardent;

class Karya extends Ardent {
    protected $table = 'tb_cakrawala_kompetisi_karya';
    protected $primaryKey = 'id_karya';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    protected $fillable = array('judul_karya', 'karya', 'link_video_demo');
	protected $guarded = array('id_karya', 'id_tim');

	public static $rules = array(
        'judul_karya'     => 'required',
        'karya'           => 'required',
        'link_video_demo' => '',
    );

    public function tim()
    {
        return $this->belongsTo('HMIF\Model\Cakrawala\Tim', 'id_tim');
    }
}
