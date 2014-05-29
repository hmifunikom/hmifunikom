<?php namespace HMIF\Repositories\Acara;

use HMIF\Model\Acara\Panitia;

class EloquentPanitiaRepo implements PanitiaRepo {

    private $relations = array();
    private $per_page = 15;
    private $errors = null;
 
    public function findById($id)
    {
        return Panitia::find($id);
    }

    public function findByDiv($id_div)
    {
        return Panitia::where('id_div', '=', $id_div)
               ->orderBy('id_panitia', 'asc')
               ->paginate($this->per_page);
    }

    public function findByAcara($kd_acara)
    {
        return Panitia::where('kd_acara', '=', $kd_acara)
               ->orderBy('id_panitia', 'asc')
               ->paginate($this->per_page);
    }
    
    public function store($data)
    {
        $new_item = new Panitia();
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
        return new Panitia();
    }
    
}