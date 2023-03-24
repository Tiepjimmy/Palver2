<?php

namespace App\Modules\Order\Resources;

use Common\Http\Resources\AbstractResource;
use Illuminate\Http\Resources\MergeValue;
use OmSdk\Modules\Order\Models\Order;

class OrderResource extends AbstractResource
{
    /**
     * @var Order $resource
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
            'created_store_id' => $this->resource->created_store_id,
            'customer_id' => $this->resource->customer_id,
            'lead_id' => $this->resource->lead_id,
            'customer_name' => $this->resource->customer_name,
            'customer_mobile' => $this->resource->customer_mobile,
            'customer_email' => $this->resource->customer_email,
            'customer_group_id' => $this->resource->customer_group_id,
            'code' => $this->resource->code,
            'order_status_id' => $this->resource->order_status_id,
            'sub_status_id' => $this->resource->sub_status_id,
            'shipping_status_id' => $this->resource->shipping_status_id,
            'shipping_address_id' => $this->resource->shipping_address_id,
            'billing_address_id' => $this->resource->billing_address_id,
            'product_catalog_id' => $this->resource->product_catalog_id,
            'sub_total' => $this->resource->sub_total,
            'grand_total' => $this->resource->grand_total,
            'discount_amount' => $this->resource->discount_amount,
            'shipping_amount' => $this->resource->shipping_amount,
            'tax_amount' => $this->resource->tax_amount,
            'type' => $this->resource->type,
            'source_id' => $this->resource->source_id,
            'source_name' => $this->resource->source_name,
            'payment_id' => $this->resource->payment_id,
            'confirmed_user_id' => $this->resource->confirmed_user_id,
            'assigned_user_id' => $this->resource->assigned_user_id,
            'delivered_user_id' => $this->resource->delivered_user_id,
            'approved_user_id' => $this->resource->approved_user_id,
            'created_by' => $this->resource->created_by,
            'updated_by' => $this->resource->updated_by,
            'confirmed_at' => $this->resource->confirmed_at,
            'delivered_at' => $this->resource->delivered_at,
            'approved_at' => $this->resource->approved_at,
            'printed_at' => $this->resource->printed_at,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'update_success_at' => $this->resource->update_success_at,
            'paid_at' => $this->resource->paid_at,
            'transaction_status' => $this->resource->transaction_status,
            'upsale_user_id' => $this->resource->upsale_user_id,
            'discount_type' => $this->resource->discount_type,
            'surcharge' => $this->resource->surcharge,
            'insurance' => $this->resource->insurance,
            'cancel_reason_id' => $this->resource->cancel_reason_id,
            # [/auto-gen-resource]
            new MergeValue([
                'user_created' => $this->resource->userCreated,
                'user_upsale' => $this->resource->userUpsale,
                'lead' => $this->resource->lead,
                'products' => $this->resource->orderProduct,
                'payments' => $this->resource->orderPayment,
                'notes' => $this->resource->orderNotes,
                'order_address' => $this->resource->orderAddress,
                'shipping_detail' => $this->resource->shippingDetail,
                'order_status' => $this->resource->orderStatus,
                'user_approved' => $this->resource->userApproved
            ])
        ];
    }
}