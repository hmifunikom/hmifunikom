<?php namespace HMIF\Repositories\IFGames;

use IFGCabang as Cabang;

class EloquentCabangRepo implements CabangRepo {

    private $relations = array();
    private $per_page = 15;
    private $errors = null;
 
    public function findById($id)
    {
        return Cabang::with($this->relations)->find($id);
    }
    
    public function findAll()
    {
        return Cabang::with($this->relations)
               ->orderBy('nama_cabang', 'asc')
               ->paginate($this->per_page);
    }
    
    public function store($data)
    {
        $new_item = new Cabang();
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
        return new Cabang();
    }
    
}