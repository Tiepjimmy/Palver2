<?php

namespace App\Modules\Product\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Modules\Product\Services\Impls\ProductServices;

/**
 * ProductJob
 */
class ProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $attributes;
    protected $danhMucId;
    protected $donViKhoiLuong;

    /**
     * Create a new job instance.
     *
     * @param  mixed $attributes
     * @param  mixed $danhMucId
     * @param  mixed $donViKhoiLuong
     * @return void
     */
    public function __construct($attributes, $danhMucId, $donViKhoiLuong)
    {
        $this->attributes = $attributes;
        $this->danhMucId = $danhMucId;
        $this->donViKhoiLuong = $donViKhoiLuong;
    }

    /**
     * Execute the job.
     *
     * @param
     * @return void
     */
    public function handle(ProductServices $productServices)
    {
        $productServices->handleImport($this->attributes, $this->danhMucId, $this->donViKhoiLuong);
    }
}