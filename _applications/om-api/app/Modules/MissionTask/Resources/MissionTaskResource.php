<?php

namespace  App\Modules\MissionTask\Resources;

use Common\Http\Resources\AbstractResource;
use Common\Models\AbstractModel;
use Illuminate\Support\Collection;
use Symfony\Component\Translation\Exception\InvalidResourceException;

class MissionTaskResource extends AbstractResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        if (!$this->resource instanceof AbstractModel) {
            throw new InvalidResourceException();
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_active' => $this->is_active,
            'store_id' => $this->store_id,
            'is_default' => $this->is_default,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by
        ];
    }
}