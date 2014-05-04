<?php namespace HMIF\Repositories\Cakrawala;

interface CakrawalaKompetisiTimRepo {
    public function findById($id);
    public function findByLomba($lomba);
    public function findAll();
    public function store($data);
    public function update($id, $data);
    public function destroy($id);
    public function instance();
}