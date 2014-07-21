<?php namespace HMIF\Repositories\Cakrawala\Eloquent;

use HMIF\Repositories\Cakrawala\KaryaRepoInterface;
use HMIF\Model\Cakrawala\Karya;
use HMIF\Model\Cakrawala\Tim;

class KaryaRepo implements KaryaRepoInterface {

    private $relations = array();
    private $per_page = 15;
    private $errors = null;
 
    public function findById($id)
    {
        return Karya::with($this->relations)->find($id);
    }

    public function findByTim($tim)
    {
        return Tim::find($tim)->karya()->get();
    }

    public function findAll()
    {
        return Karya::with($this->relations)
               ->orderBy('id_karya', 'desc')
               ->paginate($this->per_page);
    }
    
    public function store($data)
    {
        $new_item = new Karya();
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
        return new Karya();
    }
    
}