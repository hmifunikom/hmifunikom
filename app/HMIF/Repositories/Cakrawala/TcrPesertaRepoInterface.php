<?php namespace HMIF\Repositories\Cakrawala;

interface TcrPesertaRepoInterface {
    public function findById($id);
    public function findAll();
    public function store($data);
    public function update($id, $data);
    public function destroy($id);
    public function instance();
}