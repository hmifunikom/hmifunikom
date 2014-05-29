<?php namespace HMIF\Repositories\Keanggotaan;

use HMIF\Model\Keanggotaan\Anggota as Anggota;
use HMIF\Model\User\User as User;
use HMIF\Model\Keanggotaan\Divisi as Divisi;

class EloquentAnggotaRepo implements AnggotaRepo {

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

    public function findByUsername($username)
    {
        return User::where('username', '=', $username)
                ->take(1)
                ->get()
                ->first()
                ->anggota();
    }
    
    public function findByDivisi($divisi)
    {
        return Divisi::find($divisi)->anggota()
               ->orderBy('nama', 'asc')
               ->paginate($this->per_page);
    }
    
    public function findAll()
    {
        return Anggota::with($this->relations)
               ->orderBy('nama', 'asc')
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

    public function getErrors()
    {
        return $this->errors;
    }

    public function instance()
    {
        return new Anggota();
    }
    
}