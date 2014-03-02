<?php namespace HMIF\Repositories\Acara;

interface WaktuAcaraRepo {
  public function findById($id);
  public function findByAcara($kd_acara);
  public function store($data);
  public function update($id, $data);
  public function destroy($id);
  public function instance();
}