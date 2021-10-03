<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

class SendEmailUpdateRequest implements ShouldQueue
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
    protected $updatedBy;
    protected $assignBefore;
    protected $assignCurrent;
    public function __construct($data, $view, $author, $assignBefore, $updatedBy, $subject, $assignCurrent)
    {
        $this->data = $data;
        $this->view = $view;
        $this->author = $author;
        $this->assignBefore = $assignBefore;
        $this->updatedBy = $updatedBy;
        $this->subject = $subject;
        $this->assginCurrent = $assignCurrent;
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
            ['data' => $this->data, 'author' => $this->author, 'assign_before' => $this->assignBefore,
            'updated_by' => $this->updatedBy, 'assign_current' => $this->assignCurrent, 'subject' => $this->subject],
            function ($message) {
                $message->from(config('mail.from.address'), 'REQUEST GATE');
                $message->to($this->author);
                $message->to($this->assignBefore);
                $message->to($this->updatedBy);
                $message->to($this->assignCurrent);
                $message->to($this->assignBefore);
                $message->subject($this->subject);
            }
        );
    }
}
