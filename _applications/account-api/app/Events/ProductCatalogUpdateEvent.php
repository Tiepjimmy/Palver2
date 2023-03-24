<?php


namespace App\Events;


use AccountSdkDb\Modules\Product\Models\ProductCatalog;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductCatalogUpdateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $_old;
    private $_new;
    /**
     * Create a new event instance.
     *
     * @param ProductCatalog $productcatalog
     */
    public function __construct(ProductCatalog $oldUpdate,ProductCatalog $newUpdate)
    {
        $this->_old = $oldUpdate;
        $this->_new = $newUpdate;
    }

}