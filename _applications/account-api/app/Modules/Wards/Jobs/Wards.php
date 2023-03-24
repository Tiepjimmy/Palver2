<?php

namespace App\Modules\Wards\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
class Wards implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $_wardsInterface;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($wardsInterface)
    {
        $this->_wardsInterface = $wardsInterface;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $result = $this->_wardsInterface->getOne();
            print_r($result->name.'-jobs');
        } catch (\Throwable $e) {
            print_r($e);
        }
    }
}
