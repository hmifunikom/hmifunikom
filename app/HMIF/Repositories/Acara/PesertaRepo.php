<?php namespace HMIF\Repositories\Acara;

interface PesertaRepo {
  public function findById($id);
  public function findByTicket($ticket);
  public function findByKategori($kategori);
  public function findByAcara($kd_acara);
  public function store($data);
  public function update($id, $data);
  public function destroy($id);
  public function instance();
}