<?php

namespace App\Repositories;

use App\Contracts\Repositories\HistoryRepositoryInterface;
use App\Models\History;

class HistoryRepository extends BaseRepository implements HistoryRepositoryInterface
{
    /**
     * UserRepository constructor.
     * @param History $history
     */
    public function __construct(History $history)
    {
        parent::__construct($history);
    }

    public function getListHistory()
    {
        return $this->model->select('*')->with('user:id,name', 'userUpdate:id,name')
        ->orderBy('created_at', 'DESC');
    }
}
