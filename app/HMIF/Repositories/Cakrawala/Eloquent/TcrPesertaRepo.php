<?php namespace HMIF\Repositories\Cakrawala\Eloquent;

use HMIF\Repositories\Cakrawala\TcrPesertaRepoInterface;
use HMIF\Model\Cakrawala\TcrPeserta;

class TcrPesertaRepo implements TcrPesertaRepoInterface {

    private $relations = array();
    private $per_page = 15;
    private $errors = null;
 
    public function findById($id)
    {
        return TcrPeserta::with($this->relations)->find($id);
    }

    public function findAllSearch($search)
    {
        return TcrPeserta::with($this->relations)
               ->where('kode', '=', $search)
               ->orwhere('nama_peserta', 'LIKE', '%'.$search.'%')
               ->orwhere('alamat', 'LIKE', '%'.$search.'%')
               ->orderBy('id_peserta', 'desc')
               ->paginate($this->per_page);
    }

    public function findAll()
    {
        return TcrPeserta::with($this->relations)
               ->orderBy('id_peserta', 'desc')
               ->paginate($this->per_page);
    }
    
    public function store($data)
    {
        $new_item = new TcrPeserta();
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
        return new TcrPeserta();
    }
    
}