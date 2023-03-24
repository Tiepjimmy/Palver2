<?php

namespace App\Modules\PrintForm\Resources;

use Common\Http\Resources\AbstractResource;
use Common\Models\AbstractModel;

class PrintFormResource extends AbstractResource
{
    public $resource;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) {
        return [
            # [auto-gen-resource]
            'id' => $this->resource->id,
            'store_id' => $this->resource->store_id,
            'title' => $this->resource->title,
            'type' => $this->resource->type,
            'content' => $this->resource->content,
            'is_default' => $this->resource->is_default,
            'is_active' => $this->resource->is_active,
            'created_by' => $this->resource->created_by,
            'updated_by' => $this->resource->updated_by,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            # [/auto-gen-resource]
        ];
    }
}