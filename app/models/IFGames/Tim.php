<?php namespace HMIF\Model\IFGames;

use LaravelBook\Ardent\Ardent;
use DB;

class Tim extends Ardent {
    protected $table = 'tb_ifgames_tim';
    protected $primaryKey = 'id_tim';

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    protected $fillable = array('nama_tim');
    protected $guarded = array('id_tim', 'bayar');

    public static $rules = array(
        'nama_tim' => 'required',
    );

    public static $relationsData = array(
        'cabang'     => array(self::BELONGS_TO, 'HMIF\Model\IFGames\Cabang', 'foreignKey' => 'id_cabang'),
        'anggotatim' => array(self::HAS_MANY, 'HMIF\Model\IFGames\AnggotaTim', 'foreignKey' => 'id_tim'),
    );

    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery();
        
        $query->orderBy('id_tim', 'desc');

        return $query;
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