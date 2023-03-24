<?php

namespace App\Modules\Store\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use AccountSdkDb\Modules\Store\Models\JobTitle;

class JobTitleInsertEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $jobTitle;

    /**
     * Create a new event instance.
     *
     * @param JobTitle $jobTitle
     */
    public function __construct(JobTitle $jobTitle)
    {
        $this->jobTitle = $jobTitle;
    }

    /**
     * @return JobTitle
     */
    public function getModel()
    {
        return $this->jobTitle;
    }
}
