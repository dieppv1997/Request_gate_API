<?php

namespace App\Repositories;

use App\Contracts\Repositories\RequestRepositoryInterface;
use App\Models\Category;
use App\Models\Request;
use App\Models\User;
use Illuminate\Support\Facades\Config;

class RequestRepository extends BaseRepository implements RequestRepositoryInterface
{
    /**
     * UserRepository constructor.
     * @param Request $request
     */
    protected $request;

    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function getListRequest($params)
    {
        return $this->model->query()->filter($params);
    }

    public function getListRequestDueDate($limit)
    {
        return $this->model->select('*')
        ->where('due_date', '>', $limit)
        ->where('status_admin', '=', Config::get('statuses.request_status.open'))
        ->where('status_manager', '=', Config::get('statuses.request_status.open'));
    }
}
