<?php

namespace App\Modules\Order\Requests;

use Common\Http\Requests\AbstractRequest;

/**
 * [auto-gen-property]
 * @property int $id
 * @property int $store_id
 * @property int $created_store_id
 * @property int $customer_id
 * @property int $lead_id
 * @property string $customer_name
 * @property string $customer_mobile
 * @property string $customer_email
 * @property int $customer_group_id
 * @property string $code
 * @property int $order_status_id
 * @property int $sub_status_id
 * @property int $shipping_status_id
 * @property int $shipping_address_id
 * @property int $billing_address_id
 * @property int $product_catalog_id
 * @property float $sub_total
 * @property float $grand_total
 * @property float $discount_amount
 * @property float $shipping_amount
 * @property float $tax_amount
 * @property int $type
 * @property  $source_id
 * @property string $source_name
 * @property int $payment_id
 * @property int $confirmed_user_id
 * @property int $assigned_user_id
 * @property int $delivered_user_id
 * @property int $approved_user_id
 * @property int $created_by
 * @property int $updated_by
 * @property string $confirmed_at
 * @property string $delivered_at
 * @property string $approved_at
 * @property string $printed_at
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $update_success_at
 * @property string $paid_at
 * @property int $transaction_status
 * @property int $upsale_user_id
 * @property string $discount_type
 * @property float $surcharge
 * @property float $insurance
 * @property int $customer_address_id
 * @property int $warehouse_id
 * [/auto-gen-property]
 */
class OrderRequest extends AbstractRequest
{
    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            'id' => '',
            'store_id' => '',
            'created_store_id' => '',
            'customer_id' => '',
            'lead_id' => '',
            'customer_name' => '',
            'customer_mobile' => '',
            'customer_email' => '',
            'customer_group_id' => '',
            'code' => '',
            'order_status_id' => '',
            'sub_status_id' => '',
            'shipping_status_id' => '',
            'shipping_address_id' => '',
            'billing_address_id' => '',
            'product_catalog_id' => '',
            'sub_total' => '',
            'grand_total' => '',
            'discount_amount' => '',
            'shipping_amount' => '',
            'tax_amount' => '',
            'type' => '',
            'source_id' => '',
            'source_name' => '',
            'payment_id' => '',
            'confirmed_user_id' => '',
            'assigned_user_id' => '',
            'delivered_user_id' => '',
            'approved_user_id' => '',
            'created_by' => '',
            'updated_by' => '',
            'confirmed_at' => '',
            'delivered_at' => '',
            'approved_at' => '',
            'printed_at' => '',
            'created_at' => '',
            'updated_at' => '',
            'deleted_at' => '',
            'update_success_at' => '',
            'paid_at' => '',
            'transaction_status' => '',
            'upsale_user_id' => '',
            'discount_type' => '',
            'surcharge' => '',
            'insurance' => ''
        ];
    }

    public function rules()
    {
        return [
            //
        ];
    }
}