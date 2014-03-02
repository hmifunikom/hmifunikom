<?php namespace HMIF\Repositories\Acara;

use DivAcara;

class EloquentDivAcaraRepo implements DivAcaraRepo {

    private $relations = array();
    private $per_page = 15;
    private $errors = null;
 
    public function findById($id)
    {
        return DivAcara::find($id);
    }

    public function findByAcara($kd_acara)
    {
        return DivAcara::where('kd_acara', '=', $kd_acara)
               ->orderBy('id_div', 'asc')
               ->paginate($this->per_page);
    }
    
    public function store($data)
    {
        $new_item = new DivAcara();
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
        return new DivAcara();
    }
    
}