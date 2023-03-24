<?php


namespace App\Events;

use AccountSdkDb\Modules\Store\Models\Store;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
class StoreUpdateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $_old;
    private $_new;
    /**
     * Create a new event instance.
     *
     * @param Store $user
     */
    public function __construct(Store $oldUpdate,Store $newUpdate)
    {
        $this->_old = $oldUpdate;
        $this->_new = $newUpdate;
    }

}