<?php

namespace App\Modules\PaymentVoucher\Resources;

use Common\Http\Resources\AbstractResource;

class OrderResource extends AbstractResource
{
    /**
     * @var OrderResource $resource
     */
    public $resource;

    /**
     * @param $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (is_null($this->resource)){
            return null;
        }
        return [
            'orders' => $this->resource->map(function ($item) {
                return [
                    'id' => $item['id'],
                    'store_id' => $item['store_id'],
                    'customer_id' => $item['customer_id'],
                    'customer_name' => $item['customer_name'],
                    'payment_id' => $item['payment_id'],
                    'code' => $item['code'],
                    'order_payments' => $item['order_payments'],
                ];
            })
        ];
    }

}