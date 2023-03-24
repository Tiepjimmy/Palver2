<?php

namespace App\Modules\Customer\Resources;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use Common\Http\Resources\AbstractResource;
use App\Modules\Customer\Exceptions\OrderException;
use OmSdk\Modules\Customer\Models\CustomerAddress;

class CustomerAddressResource extends AbstractResource
{
    public function toArray($request)
    {
        return $this->resource;
        try {
            if ($this->resource instanceof CustomerAddress) {
                return array(
                    'id'        => $this->resource->id,
                    'store_id'  => $this->resource->store_id,
                    'customer_id' => $this->resource->customer_id,
                    'mobile'    => $this->resource->mobile,
                    'email'     => $this->resource->email,
                    'country_id'    => $this->resource->country_id,
                    'province_id'   => $this->resource->province_id,
                    'district_id'   => $this->resource->district_id,
                    'ward_id'   => $this->resource->ward_id,
                    'address'   => $this->resource->address,
                    'is_default' => $this->resource->is_default
                );
            }

            if ($this->resource['data'] instanceof Collection) {
                $this->resource['data'] = $this->resource['data']->map(function ($item) {
                    return array(
                        'id'        => $item->id,
                        'store_id'  => $item->store_id,
                        'customer_id' => $item->customer_id,
                        'mobile'    => $item->mobile,
                        'email'     => $item->email,
                        'country_id'    => $item->country_id,
                        'province_id'   => $item->province_id,
                        'district_id'   => $item->district_id,
                        'ward_id'   => $item->ward_id,
                        'address'   => $item->address,
                        'is_default' => $item->is_default
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
