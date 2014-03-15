<?php namespace HMIF\Repositories\IFGames;

use IFGTim as Tim;

class EloquentTimRepo implements TimRepo {

    private $relations = array();
    private $per_page = 15;
    private $errors = null;
 
    public function findById($id)
    {
        return Tim::with($this->relations)->find($id);
    }

    public function findByCabang($id_cabang)
    {
        return Tim::with($this->relations)
               ->where('id_cabang', '=', $id_cabang)
               ->paginate($this->per_page);
    }
    
    public function findAll()
    {
        return Tim::with($this->relations)
               ->paginate($this->per_page);
    }
    
    public function store($data)
    {
        $new_item = new Tim();
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
        return new Tim();
    }
    
}