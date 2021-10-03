<?php

namespace App\Contracts\Services\Api;

interface DepartmentServiceInterface
{
    public function index($params);
    public function store($params);
    public function update($params, $id);
}
