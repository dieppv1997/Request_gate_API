<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\Api\HistoryServiceInterface;
use Illuminate\Http\Request;

class HistoryController extends ApiController
{
    /**
     * CommentHistoryController constructor.
     */

    protected $serviceService;
    public function __construct(HistoryServiceInterface $serviceService)
    {
        $this->serviceService = $serviceService;
        parent::__construct();
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

    public function index(Request $request)
    {
        $params = $request->all();
        return $this->getData(function () use ($params) {
            return $this->serviceService->index($params);
        });
    }
}
