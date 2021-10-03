<?php

namespace App\Repositories;

use App\Contracts\Repositories\CommentHistoryRepositoryInterface;
use App\Models\CommentHistory;

class CommentHistoryRepository extends BaseRepository implements CommentHistoryRepositoryInterface
{
    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(CommentHistory $comment)
    {
        parent::__construct($comment);
    }
}
