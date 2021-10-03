<?php

namespace App\Repositories;

use App\Contracts\Repositories\RequestHistoryRepositoryInterface;
use App\Models\RequestHistory;

class RequestHistoryRepository extends BaseRepository implements RequestHistoryRepositoryInterface
{
    /**
     * UserRepository constructor.
     * @param RequestHistory $request
     */
    public function __construct(RequestHistory $request)
    {
        parent::__construct($request);
    }
}
