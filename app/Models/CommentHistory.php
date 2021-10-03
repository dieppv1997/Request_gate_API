<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class CommentHistory extends Model
{
    use Notifiable;
    protected $fillable = [
        'comment_id',
        'content_before',
        'content_current'
    ];
}
