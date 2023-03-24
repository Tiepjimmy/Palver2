<?php

namespace App\Modules\Provider\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use AccountSdkDb\Modules\Provider\Models\ProviderGroup;

class ProviderGroupInsertEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $providerGroup;

    /**
     * Create a new event instance.
     *
     * @param ProviderGroup $providerGroup
     */
    public function __construct(ProviderGroup $providerGroup)
    {
        $this->providerGroup = $providerGroup;
    }

    /**
     * @return ProviderGroup
     */
    public function getModel()
    {
        return $this->providerGroup;
    }
}
