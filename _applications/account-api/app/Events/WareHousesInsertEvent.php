<?php


namespace App\Events;


use AccountSdkDb\Modules\Warehouse\Models\Warehouse;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WareHousesInsertEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $_warehouse;

    /**
     * Create a new event instance.
     *
     * @param Warehouse $warehouse
     */
    public function __construct(Warehouse $warehouse)
    {
        $this->_warehouse = $warehouse;
    }

}