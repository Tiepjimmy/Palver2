<?php

namespace App\Modules\PrintForm\Resources;

use Common\Models\AbstractModel;
use Illuminate\Support\Collection;
use Common\Http\Resources\AbstractResource;

class PrintFormSystemResource extends AbstractResource
{
    public function __construct(Collection $resource)
    {
        $this->resource = $resource;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->resource->pipe(function ($collection) {
            return [
                'items' => $collection->map(fn($item) => [
                    # [auto-gen-resource]
                    'id' => $item->id,
                    'store_id' => $item->store_id,
                    'title' => $item->title,
                    'type' => $item->type,
                    'content' => $item->content,
                    'is_default' => $item->is_default,
                    'is_active' => $item->is_active,
                    'created_by' => $item->created_by,
                    'updated_by' => $item->updated_by,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    # [/auto-gen-resource]
                ]),
                'total' => $collection->count()
            ];
        });
    }
}
