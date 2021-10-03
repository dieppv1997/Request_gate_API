<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Departments\StoreRequest;
use App\Http\Requests\Api\Departments\UpdateRequest;
use Illuminate\Http\Request;
use App\Services\Api\DepartmentService;

class DepartmentController extends ApiController
{
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        parent::__construct();
        $this->departmentService = $departmentService;
    }

    /**
     * @throws \App\Exceptions\NotFoundException
     * @throws \App\Exceptions\ServerException
     * @throws \App\Exceptions\CheckAuthenticationException
     * @throws \App\Exceptions\CheckAuthorizationException
     * @throws \App\Exceptions\UnprocessableEntityException
     * @throws \App\Exceptions\QueryException
     */
    public function index(Request $request)
    {
        $params = $request->name;
        return $this->getData(function () use ($params) {
            return $this->departmentService->index($params);
        });
    }
    public function store(StoreRequest $request)
    {
        $params = $request->all();
        return $this->doRequest(function () use ($params) {
            return $this->departmentService->store($params);
        });
    }
    public function update(UpdateRequest $request, $id)
    {
        $params = $request->all();
        return $this->doRequest(function () use ($params, $id) {
            return $this->departmentService->update($params, $id);
        });
    }
}
