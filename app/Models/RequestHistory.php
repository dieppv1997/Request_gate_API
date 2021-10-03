<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class RequestHistory extends Model
{
    use Notifiable;
    protected $table = "request_histories";
    protected $fillable = [
        'category_id_before',
        'category_id_current',
        'due_date_before',
        'due_date_current',
        'request_id',
        'admin_id_before',
        'admin_id_current',
        'status_admin_before',
        'status_admin_current',
        'status_manager_before',
        'status_manager_current',
        'content_before',
        'content_current',
        'priority_before',
        'priority_current',
        'title_before',
        'title_current',
        'user_id'
    ];
    public $timestamps = true;

    public function categoryBefore(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id_before', 'id');
    }

    public function categoryCurrent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id_current', 'id');
    }

    public function adminBefore(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id_before', 'id');
    }

    public function adminCurrent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id_current', 'id');
    }
}
