<?php namespace HMIF\Repositories\Keanggotaan;

interface AnggotaRepo {
    public function findById($id);
    public function findByNim($nim);
    public function findByUsername($username);
    public function findByDivisi($divisi);
    public function findAll();
    public function store($data);
    public function update($id, $data);
    public function destroy($id);
    public function instance();
}