<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Categories\StoreRequest;
use App\Http\Requests\Api\Categories\UpdateRequest;
use App\Services\Api\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        parent::__construct();
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $params = $request->name;
        return $this->getData(function () use ($params) {
            return $this->categoryService->index($params);
        });
    }

    public function store(StoreRequest $request)
    {
        $params = $request->all();
        return $this->doRequest(function () use ($params) {
            return $this->categoryService->store($params);
        });
    }

    public function update(UpdateRequest $request, $id)
    {
        $params = $request->all();
        return $this->doRequest(function () use ($params, $id) {
            return $this->categoryService->update($params, $id);
        });
    }

    public function destroy($id)
    {
        return $this->doRequest(function () use ($id) {
            return $this->categoryService->destroy($id);
        });
    }

    public function show($id)
    {
        return $this->doRequest(function () use ($id) {
            return $this->categoryService->find($id);
        });
    }

    public function getListAssignee()
    {
        return $this->getData(function () {
            return $this->categoryService->getListAssignee();
        });
    }

    public function getListToSelectOption()
    {
        return $this->getData(function () {
            return $this->categoryService->listToSelectOption();
        });
    }

    public function getCategoryEnable(Request $request)
    {
        $params = $request->name;
        return $this->getData(function () use ($params) {
            return $this->categoryService->getCategoryEnable($params);
        });
    }
}
