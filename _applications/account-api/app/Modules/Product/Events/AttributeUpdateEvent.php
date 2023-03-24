<?php

namespace App\Modules\Product\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use AccountSdkDb\Modules\Product\Models\ProductAttribute;

class AttributeUpdateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $productAttribute;

    /**
     * Create a new event instance.
     *
     * @param ProductAttribute $productAttribute
     */
    public function __construct(ProductAttribute $productAttribute)
    {
        $this->productAttribute = $productAttribute;
    }

    /**
     * @return ProductAttribute
     */
    public function getModel()
    {
        return $this->productAttribute;
    }
}
