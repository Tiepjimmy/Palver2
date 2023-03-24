<?php

namespace App\Modules\TypePaymentVoucher\Resources;

use Common\Http\Resources\AbstractResource;

class ListTypePaymentVoucherResource extends AbstractResource
{
    /**
     * @var ListTypePaymentVoucherResource $resource
     */
    public $resource;

    /**
     * @param mixed $request
     * @return mixed
     */
    public function toArray($request)
    {
        return [
            'current_page' => $this->resource['current_page'],
            'total_page' => $this->resource['total_page'],
            'per_page' => $this->resource['per_page'],
            'total' => $this->resource['total'],
            'items' => $this->resource['items']->map(function ($item) {
                return [
                    'id' => $item['id'],
                    'type_code' => $item['type_code'],
                    'type_name' => $item['type_name'],
                    'is_business_result' => $item['is_business_result'],
                    'is_active' => $item['is_active'],
                    'note' => $item['note'],
                    'created_at' => date_format($item['created_at'],"d/m/Y H:i:s"),
                    'updated_at' => date_format($item['updated_at'],"d/m/Y H:i:s")
                ];
            })
        ];
    }
}