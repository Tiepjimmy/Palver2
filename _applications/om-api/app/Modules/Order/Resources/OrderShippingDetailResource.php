<?php

namespace App\Modules\Order\Resources;

use Common\Http\Resources\AbstractResource;
use Common\Models\AbstractModel;
use OmSdk\Modules\Order\Models\OrderShippingDetail;

class OrderShippingDetailResource extends AbstractResource
{
    /**
     * @var OrderShippingDetail $resource
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) {
        return [
            # [auto-gen-resource]
            'id' => $this->resource->id,
            'store_id' => $this->resource->store_id,
            'order_id' => $this->resource->order_id,
            'shipping_status_id' => $this->resource->shipping_status_id,
            'warehouse_id' => $this->resource->warehouse_id,
            'bill_of_lading_code' => $this->resource->bill_of_lading_code,
            'shipping_type' => $this->resource->shipping_type,
            'shipping_provider_account_id' => $this->resource->shipping_provider_account_id,
            'shipping_partner_id' => $this->resource->shipping_partner_id,
            'shipping_provider_id' => $this->resource->shipping_provider_id,
            'created_by' => $this->resource->created_by,
            'updated_by' => $this->resource->updated_by,
            'delivering_at' => $this->resource->delivering_at,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            # [/auto-gen-resource]
        ];
    }
}