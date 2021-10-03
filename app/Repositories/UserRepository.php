<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
    public function store($data)
    {
        return $this->model->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => $data['role_id'],
            'department_id' => $data['department_id'],
            'password' => Hash::make(123456),
            'status' => $data['status'],
            'employee_id' => Str::before($data['email'], '@hblab.vn'),
        ]);
    }
    public function update($params, $id)
    {
        return $this->model->find($id)->update([
            'name' => $params['name'],
            'email' => $params['email'],
            'role_id' => $params['role_id'],
            'department_id' => $params['department_id'],
            'status' => $params['status'],
            'employee_id' => Str::before($params['email'], '@hblab.vn'),
        ]);
    }
    public function getListAssignee()
    {
        return $this->model->select(['id', 'name'])->where('role_id', config('role.admin'));
    }
    public function getListAuthor()
    {
        return $this->model->select(['id', 'name']);
    }
    public function getListUser($params)
    {
        return $this->model->name($params);
    }
    public function getAdmin($params)
    {
        return $this->model->name($params)->where('role_id', config('role.admin'));
    }
}
