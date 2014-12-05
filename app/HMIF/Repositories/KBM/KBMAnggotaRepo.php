<?php namespace HMIF\Repositories\KBM;

interface KBMAnggotaRepo {
    public function findById($id);
    public function findByNim($nim);
    public function findAll();
    public function store($data);
    public function update($id, $data);
    public function destroy($id);
    public function instance();
}