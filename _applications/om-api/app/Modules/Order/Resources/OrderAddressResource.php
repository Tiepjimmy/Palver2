<?php

namespace App\Modules\Order\Resources;

use Common\Http\Resources\AbstractResource;
use Common\Models\AbstractModel;
use Symfony\Component\Translation\Exception\InvalidResourceException;

class OrderAddressResource extends AbstractResource
{
    public function toArray($request)
    {
        if (!$this->resource instanceof AbstractModel) {
            throw new InvalidResourceException();
        } // TODO: Change the autogenerated stub

        return [
            'id' => $this->id,
            'store_id' => $this->store_id,
            'order_id' => $this->order_id,
            'country_id' => $this->country_id,
            'province_id' => $this->province_id,
            'district_id' => $this->district_id,
            'ward_id' => $this->ward_id,
            'address' => $this->address,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'is_default' => $this->is_default,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'province' => $this->province,
            'district' => $this->district,
            'ward' => $this->ward
        ];
    }
}