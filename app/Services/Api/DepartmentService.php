<?php

namespace App\Services\Api;

use App\Contracts\Repositories\DepartmentRepositoryInterface;
use App\Contracts\Services\Api\DepartmentServiceInterface;
use App\Services\AbstractService;

class DepartmentService extends AbstractService implements DepartmentServiceInterface
{
    protected $departmentRepository;

    /**
     * DepartmentService constructor.
     * @param DepartmentRepositoryInterface $departmentRepository
     */
    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function index($params)
    {
        return [
            'code' => 200,
            'department' => $this->departmentRepository
                ->filterDepartment($params)
                ->orderBy('name')
                ->paginate(config('constant.pagination_department')),
        ];
    }
    public function store($params)
    {
        return $this->departmentRepository->store($params);
    }
    public function update($params, $id)
    {
        return $this->departmentRepository->find($id)->update($params);
    }
}
