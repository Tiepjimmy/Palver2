<?php

namespace App\Modules\Example\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Example implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $_exampleInterface;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($exampleInterface)
    {
        $this->_exampleInterface = $exampleInterface;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $result = $this->_exampleInterface->getOne();
            print_r($result->name.'-jobs');
        } catch (\Throwable $e) {
            print_r($e);
        }
    }
}
