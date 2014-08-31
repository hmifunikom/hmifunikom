<?php namespace HMIF\Repositories\Cakrawala\Eloquent;

use HMIF\Repositories\Cakrawala\PembayaranRepoInterface;
use HMIF\Model\Cakrawala\Pembayaran;

class PembayaranRepo implements PembayaranRepoInterface {

    private $relations = array();
    private $per_page = 15;
    private $errors = null;
 
    public function findById($id)
    {
        return Pembayaran::with($this->relations)->find($id);
    }

    public function findAll()
    {
        return Pembayaran::with($this->relations)
               ->orderBy('updated_at', 'desc')
               ->paginate($this->per_page);
    }

    public function findByBayar($bayar)
    {
        if($bayar == 1)
        {
            return Pembayaran::with($this->relations)
                   ->where('waiting', 1)
                   ->where('status', 1)
                   ->orderBy('updated_at', 'desc')
                   ->paginate($this->per_page);
        }
        else
        {
            return Pembayaran::with($this->relations)
                   ->where('status', '<', 1)
                   ->orderBy('updated_at', 'desc')
                   ->paginate($this->per_page);
        }
    }
    
    public function store($data)
    {
        $new_item = new Pembayaran();
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
        return new Pembayaran();
    }
    
}