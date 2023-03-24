<?php

namespace App\Modules\Order\Resources;

use Common\Models\AbstractModel;
use Illuminate\Support\Collection;
use Common\Http\Resources\AbstractResource;

class OrderStatusLogListResource extends AbstractResource
{
    
    /**
     * @param Collection $resource
     */
    public function __construct(Collection $resource)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->resource->map->all();
    }
}
