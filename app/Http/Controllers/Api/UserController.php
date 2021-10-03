<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\Api\UserServiceInterface;
use App\Http\Requests\Api\Users\IndexRequest;
use App\Http\Requests\Api\Users\StoreRequest;
use App\Http\Requests\Api\Users\UpdateRequest;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * UserController constructor.
     */
    protected $serviceService;
    public function __construct(UserServiceInterface $serviceService)
    {
        $this->serviceService = $serviceService;
        parent::__construct();
    }

    /**
     * @param IndexRequest $request
     * @param UserServiceInterface $serviceService
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\CheckAuthenticationException
     * @throws \App\Exceptions\CheckAuthorizationException
     * @throws \App\Exceptions\NotFoundException
     * @throws \App\Exceptions\QueryException
     * @throws \App\Exceptions\ServerException
     * @throws \App\Exceptions\UnprocessableEntityException
     */
    public function index(IndexRequest $request)
    {
        $params = $request->all();
        return $this->getData(function () use ($params) {
            return $this->serviceService->index($params);
        });
    }
    public function store(StoreRequest $request)
    {
        $params = $request->all();
        return $this->getData(function () use ($params) {
            return $this->serviceService->store($params);
        });
    }
    public function update($id, UpdateRequest $request)
    {
        $params = $request->all();
        return $this->doRequest(function () use ($id, $params) {
            return $this->serviceService->update($params, $id);
        });
    }
    public function destroy($id)
    {
        return $this->doRequest(function () use ($id) {
            return $this->serviceService->destroy($id);
        });
    }
    public function data(IndexRequest $request)
    {
        $params = $request->all();
        return $this->getData(function () use ($params) {
            return $this->serviceService->data($params);
        });
    }
    public function getUserByCategoryId($id)
    {
        return $this->doRequest(function () use ($id) {
            return $this->serviceService->find($id);
        });
    }
    public function getListDepartment()
    {
        return $this->getData(function () {
            return $this->serviceService->getListDepartment();
        });
    }
    public function getMe()
    {
        return auth()->user();
    }
    public function getAll()
    {
        return $this->getData(function () {
            return $this->serviceService->getAll();
        });
    }
    public function getAdmin(Request $request)
    {
        $params = $request->all();
        return $this->getData(function () use ($params) {
            return $this->serviceService->getAdmin($params);
        });
    }
}
