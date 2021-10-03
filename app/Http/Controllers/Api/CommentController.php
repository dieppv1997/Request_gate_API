<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\Api\CommentServiceInterface;
use App\Http\Requests\Api\Comments\StoreRequest;

class CommentController extends ApiController
{
    /**
     * CommentController constructor.
     */

    protected $serviceService;

    public function __construct(CommentServiceInterface $serviceService)
    {
        parent::__construct();
        $this->serviceService = $serviceService;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\CheckAuthenticationException
     * @throws \App\Exceptions\CheckAuthorizationException
     * @throws \App\Exceptions\NotFoundException
     * @throws \App\Exceptions\QueryException
     * @throws \App\Exceptions\ServerException
     * @throws \App\Exceptions\UnprocessableEntityException
     */
    public function index($id)
    {
        return $this->getData(function () use ($id) {
            return $this->serviceService->index($id);
        });
    }

    /**
     * @param StoreRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\CheckAuthenticationException
     * @throws \App\Exceptions\CheckAuthorizationException
     * @throws \App\Exceptions\NotFoundException
     * @throws \App\Exceptions\QueryException
     * @throws \App\Exceptions\ServerException
     * @throws \App\Exceptions\UnprocessableEntityException
     */
    public function store(StoreRequest $request, $id)
    {
        $param = $request->all();
        return $this->getData(function () use ($param, $id) {
            return $this->serviceService->store($param, $id);
        });
    }
}
