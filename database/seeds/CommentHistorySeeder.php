<?php

use Illuminate\Database\Seeder;
use App\Models\CommentHistory;

class CommentHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $commentHistory = new CommentHistory;
        $commentHistory->comment_id = 2;
        $commentHistory->content_before = 'Seeder trong Laravel là class cho phép chúng ta xử lý dữ liệu';
        $commentHistory->content_current = 'Seeder trong Laravel';
        $commentHistory->save();
    }
}
