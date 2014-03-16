<?php namespace HMIF\Repositories\IFGames;

use IFGAnggotaTim as AnggotaTim;

class EloquentAnggotaTimRepo implements AnggotaTimRepo {

    private $relations = array();
    private $errors = null;
 
    public function findById($id)
    {
        return AnggotaTim::with($this->relations)->find($id);
    }

    public function findManagerByTim($id_tim)
    {
        return AnggotaTim::with($this->relations)
               ->where('id_tim', '=', $id_tim)
               ->where('jabatan', '=', 'manager')
               ->get()->first();
    }

    public function findOfficialByTim($id_tim)
    {
        return AnggotaTim::with($this->relations)
               ->where('id_tim', '=', $id_tim)
               ->where('jabatan', '=', 'official')
               ->get()->first();
    }

    public function findAnggotaByTim($id_tim)
    {
        return AnggotaTim::with($this->relations)
               ->where('id_tim', '=', $id_tim)
               ->where('jabatan', '=', 'anggota')->get();
    }
    
    public function findAll()
    {
        return AnggotaTim::with($this->relations);
    }
    
    public function store($data)
    {
        $new_item = new AnggotaTim();
        if($new_item->save())
        {
            return TRUE;
        }
        else
        {
            $this->errors = $new_item->errors();
            return FALSE;
        }
    }
    
    public function update($id, $data)
    {
        $item = $this->findById($id);
        if($item->save())
        {
            return TRUE;
        }
        else
        {
            $this->errors = $new_item->errors();
            return FALSE;
        }
    }
    
    public function destroy($id)
    {
        $this->findById($id)->delete();
        return true;
    }
    
    public function setRelations($relations = array())
    {
        $this->relations = $relations;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function instance()
    {
        return new AnggotaTim();
    }
    
}