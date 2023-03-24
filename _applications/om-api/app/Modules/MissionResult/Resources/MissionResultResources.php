<?php

namespace App\Modules\MissionResult\Resources;

use Common\Http\Resources\AbstractResource;
use Common\Models\AbstractModel;
use Symfony\Component\Translation\Exception\InvalidResourceException;

class MissionResultResources extends AbstractResource
{
    /**
     * @param $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (!$this->resource instanceof AbstractModel) {
            throw new InvalidResourceException();
        }

        return [
            'id' => $this->id,
            'store_id' => $this->store_id,
            'name' => $this->name,
            'lead_status_id' => $this->lead_status_id,
            'is_active' => $this->is_active,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'task_id' => $this->task_id,
            'tasks' => $this->tasks
        ];
    }
}