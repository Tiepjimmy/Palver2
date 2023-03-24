<?php

namespace App\Modules\Order\Resources;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use Common\Http\Resources\AbstractResource;
use App\Modules\Order\Exceptions\OrderException;
use OmSdk\Modules\Order\Model\OrderStatus;

class StatusResource extends AbstractResource
{
    public function toArray($request)
    {
        return $this->resource;
        try {
            if ($this->resource instanceof OrderStatus) {
                return array(
                    'id'        => $this->resource->id,
                    'store_id'  => $this->resource->store_id,
                    'name'      => $this->resource->name,
                    'code'      => $this->resource->code,
                    'color'     => $this->resource->color,
                    'level'     => $this->resource->level,
                    'type'      => $this->resource->type,
                    'description'    => $this->resource->description,
                    'action_name'   => $this->resource->action_name,
                    'is_no_revenue' => $this->resource->is_no_revenue,
                    'is_system'     => $this->resource->is_system,
                    'is_active'     => $this->resource->is_active,
                    'created_by'    => $this->resource->created_by,
                    'updated_by'    => $this->resource->updated_by
                );
            }

            if ($this->resource['data'] instanceof Collection) {
                $this->resource['data'] = $this->resource['data']->map(function ($item) {
                    return array(
                        'id'        => $item->id,
                        'store_id'  => $item->store_id,
                        'name'      => $item->name,
                        'code'      => $item->code,
                        'color'     => $item->color,
                        'level'     => $item->level,
                        'type'      => $item->type,
                        'description'    => $item->description,
                        'action_name'   => $item->action_name,
                        'is_no_revenue' => $item->is_no_revenue,
                        'is_system'     => $item->is_system,
                        'is_active'     => $item->is_active,
                        'created_by'    => $item->created_by,
                        'updated_by'    => $item->updated_by
                    );
                });
                return $this->resource;
            }

            throw new OrderException('ERR_003');
        } catch (\Exception $e) {
            throw new OrderException('ERR_003');
        }
    }
}
