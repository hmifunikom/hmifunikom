<?php namespace HMIF\Repositories\Acara;

use Acara;

class EloquentAcaraRepo implements AcaraRepo {

    private $relations = array();
    private $per_page = 15;
    private $errors = null;
 
    public function findByKode($kode)
    {
        return Acara::with($this->relations)->find($kode);
    }

    public function findByYear($date)
    {
        return Acara::with($this->relations)
               ->whereRaw("YEAR(tgl) = YEAR(?)", array($date))
               ->orderBy('tgl', 'asc')
               ->paginate($this->per_page);
    }

    public function findByMonth($date)
    {
        return Acara::with($this->relations)
               ->whereRaw("MONTH(tgl) = MONTH(?) AND YEAR(tgl) = YEAR(?)", array($date, $date))
               ->orderBy('tgl', 'asc')
               ->paginate($this->per_page);
    }
    
    public function findUpcoming()
    {
        return Acara::with($this->relations)
               ->orderBy('tgl', 'asc')
               ->take(1)
               ->get()
               ->first();
    }
    
    public function findAll()
    {
        return Acara::with($this->relations)
               ->orderBy('tgl', 'asc')
               ->paginate($this->per_page);
    }
    
    public function store($data)
    {
        $new_item = new Acara();
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
    
    public function update($kode, $data)
    {
        $item = $this->findByKode($kode);
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
    
    public function destroy($kode)
    {
        $this->findByKode($kode)->delete();
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
        return new Acara();
    }
    
}