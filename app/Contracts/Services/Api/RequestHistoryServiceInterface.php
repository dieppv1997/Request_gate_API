<?php

namespace App\Contracts\Services\Api;

interface RequestHistoryServiceInterface
{
    public function index($params);
    public function store($params);
}
