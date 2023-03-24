<?php

namespace App\Modules\MissionScript\Resources;

use Common\Http\Resources\AbstractResource;
use Common\Models\AbstractModel;
use OmSdk\Modules\MissionResult\Models\MissionScript;
use Symfony\Component\Translation\Exception\InvalidResourceException;

class MissionScriptResources extends AbstractResource
{
    /** @var MissionScript $resource */
    public $resource;

    public function toArray($request)
    {
        if (!$this->resource instanceof AbstractModel) {
            throw new InvalidResourceException();
        }
        return [
            'id' => $this->resource->id,
            'store_id' => $this->resource->store_id,
            'task_id' => $this->resource->task_id,
            'result_id' => $this->resource->result_id,
            'next_task_id' => $this->resource->next_task_id,
            'next_task_end_at' => $this->resource->next_task_end_at,
            'created_by' => $this->resource->created_by,
            'updated_by' =>$this->resource->updated_by,
            'task' => $this->resource->task,
            'next_task' => $this->resource->nextTask,
            'result' => $this->resource->result
        ];
    }
}