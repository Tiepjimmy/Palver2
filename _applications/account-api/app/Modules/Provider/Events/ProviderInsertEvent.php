<?php

namespace App\Modules\Provider\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use AccountSdkDb\Modules\Provider\Models\Provider;

class ProviderInsertEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $provider;

    /**
     * Create a new event instance.
     *
     * @param Provider $provider
     */
    public function __construct(Provider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @return Provider
     */
    public function getModel()
    {
        return $this->provider;
    }
}
