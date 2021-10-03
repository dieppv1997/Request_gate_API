<?php

namespace App\Services\Api;

use App\Contracts\Repositories\RequestHistoryRepositoryInterface;
use App\Contracts\Services\Api\RequestHistoryServiceInterface;
use App\Services\AbstractService;

class RequestHistoryService extends AbstractService implements RequestHistoryServiceInterface
{
    /**
     * @var RequestHistoryRepositoryInterface
     */
    protected $requestHistoryRepository;

    /**
     * CommentHistoryService constructor.
     * @param RequestHistoryRepositoryInterface $requestHistoryrRepository
     */
    public function __construct(RequestHistoryRepositoryInterface $requestHistoryRepository)
    {
        $this->requestHistoryRepository = $requestHistoryRepository;
    }

    /**
     * @param $params
     * @return array
     */
    public function index($params)
    {
        return $this->requestHistoryRepository->getColumns()->get();
    }
    public function store($params)
    {
        return $this->requestHistoryRepository->store($params);
    }
}
