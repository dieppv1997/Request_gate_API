<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;

class Request extends Model
{
    use SoftDeletes;

    protected $table = "requests";
    protected $fillable = [
        'category_id',
        'due_date',
        'user_id',
        'admin_id',
        'status_admin',
        'status_manager',
        'content',
        'priority',
        'department_id',
        'created_at',
        'title',
    ];
    public $timestamps = true;

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function admin(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function scopeTitle($query, $value)
    {
        return $query->where('title', 'LIKE', "%" . $value . "%")->orderBy('title');
    }

    public function scopeContent($query, $value)
    {
        return $query->where('content', 'LIKE', "%" . $value . "%")->orderBy('content');
    }

    public function scopeStatusAdmin($query, $value)
    {
        if ($value === 'notClose') {
            return $query->whereIn('status_admin', [Config::get('statuses.request_status.open'),
            Config::get('statuses.request_status.inprogress')]);
        } else {
            return $query->where('status_admin', $value);
        }
    }

    public function scopeCreatedAt($query, $value)
    {
        return $query->whereDate('created_at', $value);
    }

    public function scopeCategory($query, $value)
    {
        return $query->where('category_id', $value);
    }

    public function scopeAdminId($query, $value)
    {
        return $query->where('admin_id', $value);
    }

    public function scopeDepartmentId($query, $value)
    {
        return $query->where('department_id', $value);
    }

    public function scopeUserId($query, $value)
    {
        return $query->where('user_id', $value);
    }

    public function scopeFilter($query, $params)
    {
        foreach ($params as $field => $value) {
            $method = 'scope' . Str::studly($field);
            if ($value != '') {
                if (method_exists($this, $method)) {
                    $this->{$method}($query, $value);
                }
            }
        }
        return $query;
    }
}
