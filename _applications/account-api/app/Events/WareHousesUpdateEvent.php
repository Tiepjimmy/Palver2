<?php


namespace App\Events;


use AccountSdkDb\Modules\Warehouse\Models\Warehouse;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WareHousesUpdateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $_old;
    private $_new;
    /**
     * Create a new event instance.
     *
     * @param Warehouse $user
     */
    public function __construct(Warehouse $oldUpdate,Warehouse $newUpdate)
    {
        $this->_old = $oldUpdate;
        $this->_new = $newUpdate;
    }

}