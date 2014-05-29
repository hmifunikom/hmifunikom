<?php namespace HMIF\Repositories\Pelatihan;

use HMIF\Model\Pelatihan\Anggota as Anggota;

class EloquentPelatihanAnggotaRepo implements PelatihanAnggotaRepo {

    private $relations = array();
    private $per_page = 15;
    private $errors = null;
 
    public function findById($id)
    {
        return Anggota::with($this->relations)->find($id);
    }

    public function findByNim($nim)
    {
        return Anggota::with($this->relations)
               ->where('nim', '=', $nim)
               ->get()
               ->first();
    }

    public function findAll()
    {
        return Anggota::with($this->relations)
               ->orderBy('id_anggota', 'desc')
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