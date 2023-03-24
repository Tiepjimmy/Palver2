<?php

namespace App\Modules\Product\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Modules\Product\Services\Impls\RetailProductServices;

/**
 * RetailProductJob
 */
class RetailProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $attributes;

    /**
     * Create a new job instance.
     *
     * @param  mixed $attributes
     * @return void
     */
    public function __construct($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Execute the job.
     *
     * @param
     * @return void
     */
    public function handle(RetailProductServices $productServices)
    {
        $productServices->handleImportBranch($this->attributes);
    }
}