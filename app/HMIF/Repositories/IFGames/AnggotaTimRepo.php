<?php namespace HMIF\Repositories\IFGames;

interface AnggotaTimRepo {
    public function findById($id);
    public function findAll();
    public function store($data);
    public function update($id, $data);
    public function destroy($id);
    public function instance();
}