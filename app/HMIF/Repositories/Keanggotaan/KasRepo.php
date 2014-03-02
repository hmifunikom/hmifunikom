<?php namespace HMIF\Repositories\Acara;

interface KasRepo {
  public function findByKode($kode);
  public function findByAnggota($kode);
  public function findAll();
  public function paginate($limit = null);
  public function store($data);
  public function update($kode, $data);
  public function destroy($kode);
  public function validate($data);
  public function instance();
}