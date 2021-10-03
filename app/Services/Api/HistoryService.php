<?php

namespace App\Services\Api;

use App\Contracts\Repositories\HistoryRepositoryInterface;
use App\Contracts\Services\Api\HistoryServiceInterface;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Config;

class HistoryService extends AbstractService implements HistoryServiceInterface
{
    /**
     * @var HistoryRepositoryInterface
     */
    protected $historyRepository;

    /**
     * CommentHistoryService constructor.
     * @param HistoryRepositoryInterface $historyrRepository
     */
    public function __construct(HistoryRepositoryInterface $historyRepository)
    {
        $this->historyRepository = $historyRepository;
    }

    /**
     * @param $params
     * @return array
     */
    public function index($params)
    {
        return $this->historyRepository->getListHistory()->paginate(Config::get('constant.pagination_history'));
    }
}
