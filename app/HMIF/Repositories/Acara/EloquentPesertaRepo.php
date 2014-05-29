<?php namespace HMIF\Repositories\Acara;

use HMIF\Model\Acara\Peserta;

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

    public function findByAcaraSearch($kd_acara, $search)
    {
        return Peserta::where('kd_acara', '=', $kd_acara)
               ->where('nama_peserta', 'LIKE', '%'.$search.'%')
               ->orwhere('kode', '=', $search)
               ->orwhere('nim', 'LIKE', '%'.$search.'%')
               ->orderBy('id_peserta', 'desc')
               ->paginate($this->per_page);
    }

    public function findByAcaraKategori($kd_acara, $kategori)
    {
        return Peserta::where('kd_acara', '=', $kd_acara)
               ->where('kategori', '=', $kategori)
               ->orderBy('id_peserta', 'desc')
               ->paginate($this->per_page);
    }

    public function findByAcaraBayar($kd_acara, $pay)
    {
        return Peserta::where('kd_acara', '=', $kd_acara)
               ->where('bayar', '=', $pay)
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
        return new Peserta();
    }
    
}