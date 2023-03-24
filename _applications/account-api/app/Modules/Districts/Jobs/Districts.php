<?php

namespace App\Modules\Districts\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
class Districts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $_districtsInterface;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($districtsInterface)
    {
        $this->_districtsInterface = $districtsInterface;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $result = $this->_districtsInterface->getOne();
            print_r($result->name.'-jobs');
        } catch (\Throwable $e) {
            print_r($e);
        }
    }
}
