<?php namespace HMIF\Repositories\Cakrawala;

use CakrawalaKompetisiAnggota as Anggota;

class EloquentCakrawalaKompetisiAnggotaRepo implements CakrawalaKompetisiAnggotaRepo {

    private $relations = array();
    private $per_page = 15;
    private $errors = null;
 
    public function findById($id)
    {
        return Anggota::with($this->relations)->find($id);
    }

    public function findByTim($tim)
    {
        return Anggota::with($this->relations)
               ->where('id_tim', '=', $tim)
               ->get();
    }

    public function findAll()
    {
        return Anggota::with($this->relations)
               ->orderBy('nama_anggota', 'asc')
               ->paginate($this->per_page);
    }
    
    public function store($data)
    {
        $new_item = new Anggota();
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

    public function setPerPage($per_page)
    {
        $this->per_page = $per_page;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function instance()
    {
        return new Anggota();
    }
    
}