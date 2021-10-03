<?php

namespace App\Services\Api;

use App\Contracts\Repositories\CommentHistoryRepositoryInterface;
use App\Contracts\Services\Api\CommentHistoryServiceInterface;
use App\Services\AbstractService;

class CommentHistoryService extends AbstractService implements CommentHistoryServiceInterface
{
    /**
     * @var CommentHistoryRepositoryInterface
     */
    protected $commentHistoryRepository;

    /**
     * CommentHistoryService constructor.
     * @param CommentHistoryRepositoryInterface $commentHistoryrRepository
     */
    public function __construct(CommentHistoryRepositoryInterface $commentHistoryRepository)
    {
        $this->commentHistoryRepository = $commentHistoryRepository;
    }

    /**
     * @param $params
     * @return array
     */
    public function index($params)
    {
        return $this->commentHistoryRepository->getColumns()->get();
    }
}
