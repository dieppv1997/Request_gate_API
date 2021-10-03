<?php

namespace App\Services\Api;

use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\Api\CategoryServiceInterface;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Config;

class CategoryService extends AbstractService implements CategoryServiceInterface
{
    protected $categoryRepository;
    protected $userRepository;

    /**
     * CategoryService constructor.
     * @param CategoryRepositoryInterface $categoryRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
    }

    public function index($params)
    {
        return [
            'code' => 200,
            'category' => $this->categoryRepository
                ->filterCategory($params)
                ->orderBy('name')
                ->with('user:id,name')
                ->paginate(config('constant.pagination')),
        ];
    }

    public function listToSelectOption()
    {
        return [
            'category' => $this->categoryRepository
                ->getColumns('*')
                ->with('user:id,name')
                ->get(),
        ];
    }

    public function store($params)
    {
        return $this->categoryRepository->store($params);
    }

    public function update($params, $id)
    {
        return $this->categoryRepository->find($id)->update($params);
    }

    public function destroy($id)
    {
        return $this->categoryRepository->find($id)->destroy($id);
    }

    public function find($id)
    {
        return $this->categoryRepository->find($id);
    }

    public function getListAssignee()
    {
        return [
            'assignee' => $this->userRepository->getListAssignee()->get(),
        ];
    }

    public function getCategoryEnable($params)
    {
        return [
            'code' => 200,
            'category' =>  $this->categoryRepository
            ->getCategoryEnable($params)
            ->orderBy('name')
            ->with('user:id,name')
            ->paginate(config('constant.pagination')),
        ];
    }
}
