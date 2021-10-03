<?php

namespace App\Contracts\Services\Api;

interface UserServiceInterface
{
    public function index($params);
    public function store($params);
    public function update($params, $id);
    public function destroy($id);
    public function data($params);
    public function find($id);
    public function getListDepartment();
    public function getAll();
    public function getAdmin($params);
}
