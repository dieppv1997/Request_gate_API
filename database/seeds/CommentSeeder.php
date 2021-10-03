<?php

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comment = new Comment;
        $comment->request_id=1;
        $comment->user_id=1;
        $comment->content = 'Seeder trong Laravel là class cho phép chúng ta xử lý dữ liệu';
        $comment->save();
    }
}
