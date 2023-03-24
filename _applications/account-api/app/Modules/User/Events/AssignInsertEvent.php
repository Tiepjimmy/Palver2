<?php

namespace App\Modules\User\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use AccountSdkDb\Modules\User\Models\Assign;

class AssignInsertEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $assign;

    /**
     * Create a new event instance.
     *
     * @param Assign $assign
     */
    public function __construct(Assign $assign)
    {
        $this->assign = $assign;
    }

    /**
     * @return Assign
     */
    public function getModel()
    {
        return $this->assign;
    }
}
