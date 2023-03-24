<?php

namespace App\Modules\SubChannel\Resources;

use Common\Http\Resources\AbstractResource;
use Common\Models\AbstractModel;
use OmSdk\Modules\SubChannel\Models\SubChannel;
use Symfony\Component\Translation\Exception\InvalidResourceException;

class SubChannelResources extends AbstractResource
{
    /**
     * @var SubChannel $resource
     */
    public $resource;

    /**
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (!$this->resource instanceof AbstractModel) {
            throw new InvalidResourceException();
        }

        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'channel' => $this->resource->channel,
            'channel_id' => $this->resource->channel_id,
            'code' => $this->resource->code,
            'is_active' => $this->resource->is_active,
            'content' => $this->resource->content,
            'store_id' => $this->resource->store_id,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at
        ];
    }
}