<?php

namespace App\Repositories;

use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Support\Facades\Config;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    /**
     * CategoryRepository constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }

    public function getListCategory()
    {
        return $this->model->select(['id', 'name']);
    }
    public function filterCategory($params)
    {
        return $this->model->name($params);
    }

    public function getListCategoryForAssign($id, $column = ['*'])
    {
        return $this->model->select($column)->where('user_id', $id);
    }
    public function getCategoryEnable($params)
    {
        return $this->model->name($params)->where('status', config('statuses.category_status.enable'));
    }
}
