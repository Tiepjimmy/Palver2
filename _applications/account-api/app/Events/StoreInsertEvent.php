<?php


namespace App\Events;

use AccountSdkDb\Modules\Store\Models\Store;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoreInsertEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $_store;

    /**
     * Create a new event instance.
     *
     * @param Store $toChuc
     */
    public function __construct(Store $store)
    {
        $this->_store = $store;
    }

}