<?php

namespace App\Modules\Product\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use AccountSdkDb\Modules\Product\Models\AttributeGroup;

class AttributeGroupUpdateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $attributeGroup;

    /**
     * Create a new event instance.
     *
     * @param AttributeGroup $attributeGroup
     */
    public function __construct(AttributeGroup $attributeGroup)
    {
        $this->attributeGroup = $attributeGroup;
    }

    /**
     * @return AttributeGroup
     */
    public function getModel()
    {
        return $this->attributeGroup;
    }
}
