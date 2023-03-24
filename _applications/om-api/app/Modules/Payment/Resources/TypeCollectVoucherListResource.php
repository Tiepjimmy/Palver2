<?php

namespace App\Modules\Payment\Resources;

use Common\Http\Resources\AbstractResource;

/**
 * Class TypeCollectVoucherListResource
 * @package App\Modules\Payment\Resources
 */
class TypeCollectVoucherListResource extends AbstractResource
{
    /**
     * @param mixed $request
     * @return array
     */
    public function toArray($request)
    {
        return array(
            'current_page' => $this->resource['current_page'],
            'total_page' => $this->resource['total_page'],
            'per_page' => $this->resource['per_page'],
            'total' => $this->resource['total'],
            'items' => $this->resource['items']->map(function ($item) {
                return array(
                    'id' => $item['id'],
                    'type_code' => $item['type_code'],
                    'type_name' => $item['type_name'],
                    'note' => $item['note'],
                    'is_active' => $item['is_active'],
                    'is_business_result' => $item['is_business_result'],
                    'created_at' => date_format($item['created_at'],"H:i:s d/m/Y"),
                    'updated_at' => date_format($item['updated_at'],"H:i:s d/m/Y")
                );
            })
        );
    }
}