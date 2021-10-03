<?php

namespace App\Services\Api;

use App\Contracts\Services\Api\CommentServiceInterface;
use App\Repositories\CommentRepository;
use App\Repositories\RequestRepository;
use App\Services\AbstractService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class CommentService extends AbstractService implements CommentServiceInterface
{
    /**
     * @var CommentRepository
     */
    protected $commentRepository;

    /**
     * CommentService constructor.
     * @param CommentRepository $commentRepository
     * @param RequestRepository $requestRepository
     */
    public function __construct(CommentRepository $commentRepository, RequestRepository $requestRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->requestRepository = $requestRepository;
    }

    /**
     * @param $params
     * @return array
     */
    public function index($id)
    {
        $comments = $this->commentRepository
            ->listComment($id)
            ->paginate(config('constant.pagination_comment'))
            ->toArray();
        return [
            'current_page' => $comments['current_page'],
            'data' => array_values(Arr::sort($comments['data'], function ($value) {
                return $value['created_at'];
            })),
            'first_page_url' => $comments['first_page_url'],
            'from' => $comments['from'],
            'last_page' => $comments['last_page'],
            'last_page_url' => $comments['last_page_url'],
            'next_page_url' => $comments['next_page_url'],
            'path' => $comments['path'],
            'per_page' => $comments['per_page'],
            'prev_page_url' => $comments['prev_page_url'],
            'to' => $comments['to'],
            'total' => $comments['total'],
        ];
    }

    public function store($param, $id)
    {
        $comment = $this->commentRepository->store([
            'content' => $param['content'],
            'request_id' => $id,
            'user_id' => auth()->user()->id,
            'type' => config('constant.type.comment'),
        ]);
        return $this->commentRepository->getComments($comment->id, ['*'])->get();
    }
}
