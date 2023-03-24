<?php

namespace App\Modules\Order\Resources;

use Common\Http\Resources\AbstractResource;
use Common\Models\AbstractModel;
use Illuminate\Http\Resources\MergeValue;
use OmSdk\Modules\Order\Models\OrderPayment;

class OrderPaymentResource extends AbstractResource
{
    /** @var OrderPayment $resource */
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
            'invoice_id' => $this->resource->invoice_id,
            'payment_method_id' => $this->resource->payment_method_id,
            'payment_amount' => $this->resource->payment_amount,
            'created_by' => $this->resource->created_by,
            'updated_by' => $this->resource->updated_by,
            'confirmed_by' => $this->resource->confirmed_by,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'note' => $this->resource->note,
            # [/auto-gen-resource]
            new MergeValue([
                'user_created' => $this->resource->userCreated,
                'user_confirmed' => $this->resource->userConfirmed,
                'payment_method' => $this->resource->paymentMethod,
                'receipt_detail' => $this->resource->receipDetail
            ])
        ];
    }
}