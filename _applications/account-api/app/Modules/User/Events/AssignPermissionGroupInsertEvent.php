<?php

namespace App\Modules\User\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use AccountSdkDb\Modules\User\Models\AssignPermissionGroup;

class AssignPermissionGroupInsertEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $assignPermissionGroup;

    /**
     * Create a new event instance.
     *
     * @param AssignPermissionGroup $assignPermissionGroup
     */
    public function __construct(AssignPermissionGroup $assignPermissionGroup)
    {
        $this->assignPermissionGroup = $assignPermissionGroup;
    }

    /**
     * @return AssignPermissionGroup
     */
    public function getModel()
    {
        return $this->assignPermissionGroup;
    }
}
