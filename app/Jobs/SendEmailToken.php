<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use Illuminate\Support\Facades\Config;

class SendEmailToken implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $email;
    protected $token;
    
    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url = config('app.url_client') . '/change_password/' . $this->token;
        Mail::send(
            'Mails.forgot',
            ['url' => $url,
            'email' => $this->email,
            'token' => $this->token ],
            function ($message) {
                $message->from(config('mail.from.address'), 'REQUEST GATE');
                $message->to($this->email);
                $message->subject('Reset your password');
            }
        );
    }
}
