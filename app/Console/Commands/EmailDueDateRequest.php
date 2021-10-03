<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\NotifyDueDateRequest;
use Carbon\Carbon;
use App\Repositories\RequestRepository;
use Illuminate\Support\Facades\Config;

class EmailDueDateRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:mail_due_date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $requestRepository;

    public function __construct(RequestRepository $requestRepository)
    {
        parent::__construct();
        $this->requestRepository = $requestRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $limit = Carbon::now();
        $requestDueDate =  $this->requestRepository->getListRequestDueDate($limit)->get();
        foreach ($requestDueDate as $request) {
            $request->admin->notify(new NotifyDueDateRequest($request));
        }
    }
}
