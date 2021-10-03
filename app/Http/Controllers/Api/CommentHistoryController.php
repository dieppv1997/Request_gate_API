<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\Api\CommentHistoryServiceInterface;
use App\Http\Requests\Api\CommentHistories\IndexRequest;

class CommentHistoryController extends ApiController
{
    /**
     * CommentHistoryController constructor.
     */

    protected $serviceService;
    public function __construct(CommentHistoryServiceInterface $serviceService)
    {
        parent::__construct();
        $this->serviceService = $serviceService;
    }

    /**
     * @param IndexRequest $request
     * @param CommentHistoryServiceInterface $serviceService
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
}
