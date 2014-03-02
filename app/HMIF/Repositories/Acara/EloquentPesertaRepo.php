<?php namespace HMIF\Repositories\Acara;

use Peserta;

class EloquentPesertaRepo implements PesertaRepo {

    private $relations = array();
    private $per_page = 15;
    private $errors = null;
 
    public function findById($id)
    {
        return Peserta::find($id);
    }

    public function findByTicket($ticket)
    {
        return Peserta::where('ticket', '=', $ticket)->first();
    }

    public function findByKategori($kategori)
    {
        return Peserta::where('kategori', '=', $kategori)
               ->orderBy('id_peserta', 'desc')
               ->paginate($this->per_page);
    }

    public function findByAcara($kd_acara)
    {
        return Peserta::where('kd_acara', '=', $kd_acara)
               ->orderBy('id_peserta', 'desc')
               ->paginate($this->per_page);
    }
    
    public function store($data)
    {
        $new_item = new Peserta();
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
        return new Peserta();
    }
    
}