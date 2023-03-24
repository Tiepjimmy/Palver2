<?php

namespace App\Modules\Order\Resources;

use Common\Http\Resources\AbstractResource;
use Illuminate\Support\Collection;

class OrderProductResource extends AbstractResource
{
    /**
     * @param Collection $resource
     */
    public function __construct(Collection $resource)
    {
        parent::__construct($resource);
    }

    /**
     * @param $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'store_id' => $this->store_id,
            'order_id' => $this->order_id,
            'product_id' => $this->product_id ,
            'product_name' => $this->product_name,
            'product_code' => $this->product_code,
            'product_sku' => $this->product_sku,
            'product_price' => $this->product_price,
            'product_base_price' => $this->product_base_price,
            'product_unit_id' => $this->product_unit_id,
            'quantity' => $this->quantity,
            'sub_total' => $this->sub_total,
            'total' => $this->total,
            'discount_amount' => $this->discount_amount,
            'discount_item' => $this->discount_item,
            'discount_type' => $this->discount_type,
            'product_unit' => $this->product_unit,
            'lot_id' => $this->lot_id,
        ];
    }
}