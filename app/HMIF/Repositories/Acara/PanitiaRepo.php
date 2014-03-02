<?php namespace HMIF\Repositories\Acara;

interface PanitiaRepo {
  public function findById($id);
  public function findByDiv($id_div);
  public function findByAcara($kd_acara);
  public function store($data);
  public function update($id, $data);
  public function destroy($id);
  public function instance();
}