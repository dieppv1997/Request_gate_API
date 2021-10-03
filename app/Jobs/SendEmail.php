<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $data;
    protected $view;
    protected $subject;
    protected $author;
    protected $assign;
    public function __construct($data, $view, $subject, $author, $assign)
    {
        $this->data = $data;
        $this->view = $view;
        $this->subject = $subject;
        $this->author = $author;
        $this->assign = $assign;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send(
            'Mails.'.$this->view,
            ['data' => $this->data, 'author' => $this->author, 'assign' => $this->assign, 'subject' => $this->subject],
            function ($message) {
                $message->from(config('mail.from.address'), 'REQUEST GATE');
                $message->to($this->author);
                $message->to($this->assign);
                $message->subject($this->subject);
            }
        );
    }
}
