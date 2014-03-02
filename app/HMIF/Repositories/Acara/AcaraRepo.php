<?php namespace HMIF\Repositories\Acara;

interface AcaraRepo {
    public function findByKode($kode);
    public function findByMonth($month);
    public function findUpcoming();
    public function findAll();
    public function store($data);
    public function update($kode, $data);
    public function destroy($kode);
    public function instance();
}