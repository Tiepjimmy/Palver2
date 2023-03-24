<?php


namespace App\Events;


use AccountSdkDb\Modules\Product\Models\ProductCatalog;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductCatalogInsertEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $_catalog;

    /**
     * Create a new event instance.
     *
     * @param Store $toChuc
     */
    public function __construct(ProductCatalog $catalog)
    {
        $this->_catalog = $catalog;
    }

}