<?php namespace HMIF\Repositories\Cakrawala;

interface CakrawalaKompetisiAnggotaRepo {
    public function findById($id);
    public function findByTim($tim);
    public function findAll();
    public function store($data);
    public function update($id, $data);
    public function destroy($id);
    public function instance();
}