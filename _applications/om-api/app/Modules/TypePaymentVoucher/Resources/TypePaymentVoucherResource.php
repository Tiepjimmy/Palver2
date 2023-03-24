<?php

namespace App\Modules\TypePaymentVoucher\Resources;

use Common\Http\Resources\AbstractResource;

class TypePaymentVoucherResource extends AbstractResource
{
    /**
     * @var TypePaymentVoucherResource $resource
     */
    public $resource;

    /**
     * @param mixed $request
     * @return mixed
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource['id'],
            'type_code' => $this->resource['type_code'],
            'type_name' => $this->resource['type_name'],
            'is_business_result' => $this->resource['is_business_result'],
            'is_active' => $this->resource['is_active'],
            'note' => $this->resource['note'],
        ];
    }
}