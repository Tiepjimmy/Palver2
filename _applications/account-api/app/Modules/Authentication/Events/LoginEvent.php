<?php


namespace App\Modules\Authentication\Events;


use Common\Auth\Models\SessionUser;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class LoginEvent
 * @package App\Modules\Authentication\Events
 */
class LoginEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $user;

    /**
     * LoginEvent constructor.
     * @param SessionUser $user
     */
    public function __construct(SessionUser $user)
    {
        $this->user = $user;
    }
}