<?php

namespace App\Modules\Example\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Modules\Example\Models\Example as ExampleModel;
use App\Modules\Example\Repositories\Contracts\ExampleInterface;

class Warehouse implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $_WarehouseInterface;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($WarehouseInterface)
    {
        $this->_WarehouseInterface = $WarehouseInterface;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $result = $this->_WarehouseInterface->getOne();
            print_r($result->name.'-jobs');
        } catch (\Throwable $e) {
            print_r($e);
        }
    }
}
