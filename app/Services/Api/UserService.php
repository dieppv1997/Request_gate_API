<?php

namespace App\Services\Api;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\Api\UserServiceInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\DepartmentRepository;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class UserService extends AbstractService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;
    protected $categoryRepository;
    protected $departmentRepository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        CategoryRepository $categoryRepository,
        DepartmentRepository $departmentRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * @param $params
     * @return array
     */
    public function index($params)
    {
        if (isset($params['name'])) {
            return $this->userRepository
                ->getListUser($params)
                ->with('department:id,name')
                ->paginate(config('constant.pagination'));
        }
        $currentPage = Input::get('page') ?? '1';
        if (!Redis::exists('user.'. $currentPage)) {
            $user = $this->userRepository
                ->getColumns()
                ->with('department:id,name')
                ->paginate(config('constant.pagination'));
            return $this->remember('user.' . $currentPage, config('constant.user.time_cache'), function () use ($user) {
                return json_encode($user);
            });
        }
        return json_decode(Redis::get('user.' . $currentPage));
    }

    public function update($params, $id)
    {
        if ($params['status'] == config::get('statuses.user_status.0') && !$this->isUserReponseCategory($id)) {
            return [
                'code' => 401,
                'message' => "Admin is responding category. Please change someone respond this category"
            ];
        }
        $this->deleteCache('user');
        if ($this->userRepository->update($params, $id)) {
            return $this->userRepository->find($id);
        }
    }

    public function store($params)
    {
        $this->deleteCache('user');
        return $this->userRepository->store($params);
    }

    public function destroy($id)
    {
        $this->deleteCache('user');
        return $this->userRepository->destroy($this->userRepository->find($id));
    }

    public function data($params)
    {
        return [
            'user' => $this->userRepository->getColumns(),
            'category' => $this->categoryRepository->getColumns(),
        ];
    }

    public function find($id)
    {
        $user_id = $this->categoryRepository->find($id, ['user_id']);
        return $this->userRepository->find($user_id);
    }

    public function getListDepartment()
    {
        return [
            'department' => $this->departmentRepository->getListDepartment()->get(),
        ];
    }

    public function getAll()
    {
        return $this->userRepository->getColumns()->get();
    }

    public function getAdmin($params)
    {
        return $this->userRepository
            ->getAdmin($params)
            ->paginate(Config::get('constant.pagination'));
    }

    public function isUserReponseCategory($id)
    {
        return !$this->categoryRepository->getListCategoryForAssign($id)->exists();
    }

    public function remember($key, $time, $callback)
    {
        if ($value = Redis::get($key)) {
            return json_decode($value);
        }
        Redis::setex($key, $time, $value = $callback());
        return json_decode($value);
    }

    public function deleteCache($key)
    {
        $keys = Redis::keys("$key*");
        foreach ($keys as $value) {
            Redis::del(Str::after($value, config('constant.prefix_cache')));
        }
    }
}
