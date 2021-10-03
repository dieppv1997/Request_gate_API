<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\Api\RequestServiceInterface;
use App\Http\Requests\Api\Requests\IndexRequest;
use App\Http\Requests\Api\Requests\StoreRequest;
use App\Http\Requests\Api\Requests\UpdateRequest;

class RequestController extends ApiController
{
    protected $serviceService;

    /**
     * UserController constructor.
     */
    public function __construct(RequestServiceInterface $serviceService)
    {
        $this->serviceService = $serviceService;
        parent::__construct();
    }

    /**
     * @param IndexRequest $request
     * @param StoreRequest $request
     * @param RequestServiceInterface $serviceService
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
        return $this->doRequest(function () use ($params) {
            return $this->serviceService->store($params);
        });
    }

    public function update(UpdateRequest $request, $id)
    {
        $params = $request->all();
        return $this->doRequest(function () use ($params, $id) {
            return $this->serviceService->update($params, $id);
        });
    }

    public function destroy($id)
    {
        return $this->doRequest(function () use ($id) {
            return $this->serviceService->destroy($id);
        });
    }

    public function show($id)
    {
        return $this->doRequest(function () use ($id) {
            return $this->serviceService->find($id);
        });
    }

    public function getListToSearch()
    {
        return $this->doRequest(function () {
            return $this->serviceService->getListToSearch();
        });
    }

    public function getListCategoryForAssign($id)
    {
        return $this->doRequest(function () use ($id) {
            return $this->serviceService->getCategoryForAssign($id);
        });
    }
}
