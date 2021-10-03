<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'user_id',
    ];
    public function requests(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Request::class);
    }
    public function user(): \Illuminate\Database\Eloquent\Relations\BeLongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function scopeName($query, $name)
    {
        if (isset($name)) {
            return $query->where('name', 'LIKE', "%" . $name . "%");
        }
    }
}
