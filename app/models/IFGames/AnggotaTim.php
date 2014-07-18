<?php namespace HMIF\Model\IFGames;

use LaravelBook\Ardent\Ardent;

class AnggotaTim extends Ardent {
    protected $table = 'tb_ifgames_anggota';
    protected $primaryKey = 'id_anggota';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    protected $fillable = array('nim', 'nama', 'no_hp', 'foto', 'jabatan');
	protected $guarded = array('id_anggota', 'id_tim', 'id_cabang');

	public static $rules = array(
        'nim'   => 'required',
        'nama'  => 'required',
        'no_hp' => 'required',
        'foto'  => 'required',
    );

    public static $relationsData = array(
        'cabang' => array(self::BELONGS_TO, 'HMIF\Model\IFGames\Cabang', 'foreignKey' => 'id_cabang'),
        'tim'    => array(self::BELONGS_TO, 'HMIF\Model\IFGames\Tim', 'foreignKey' => 'id_tim'),
    );

    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery();
        
        $query->orderBy('id_anggota', 'asc');

        return $query;
    }

    public function lengkap()
    {
        return $this->ska == 1 && $this->ktm == 1;
    }
}
