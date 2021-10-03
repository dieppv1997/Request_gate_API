<?php

namespace App\Repositories;

use App\Contracts\Repositories\CommentRepositoryInterface;
use App\Models\Comment;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(Comment $comment)
    {
        parent::__construct($comment);
    }

    public function listComment($id)
    {
        return $this->model->select('*')->with('user:id,name')->where('request_id', $id)->orderBy('created_at', 'DESC');
    }

    public function getComments($id, $columns = ['*'])
    {
        return $this->model->select($columns)->with('user:id,name')->where('id', $id);
    }
}
