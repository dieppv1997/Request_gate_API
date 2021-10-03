<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $table = "users";
    protected $fillable = [
        'name',
        'email',
        'role_id',
        'department_id',
        'password',
        'status',
        'employee_id'
    ];

    public function department(): \Illuminate\Database\Eloquent\Relations\BeLongsTo
    {
        return $this->belongsTo(Department::class);
    }
    public function categories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Request::class);
    }
    public function scopeName($query, $params)
    {
        if (isset($params['name'])) {
            return $query->where('name', 'LIKE', "%" . $params['name'] . "%");
        }
    }
}
