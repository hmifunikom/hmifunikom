<?php namespace HMIF\Repositories\User;

interface UserRepoInterface {
    public function findById($id);
    public function findByUsername($username);
    public function findByEmail($email);
    public function findAll();
    public function store($data);
    public function update($id, $data);
    public function destroy($id);
    public function instance();
}