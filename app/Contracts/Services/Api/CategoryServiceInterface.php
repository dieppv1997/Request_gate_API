<?php

namespace App\Contracts\Services\Api;

interface CategoryServiceInterface
{
    public function index($params);
    public function store($params);
    public function destroy($id);
    public function update($params, $id);
    public function find($id);
    public function getListAssignee();
    public function getCategoryEnable($params);
}
