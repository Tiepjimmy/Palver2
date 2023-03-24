<?php

namespace App\Modules\Order\Requests;

class OrderStoreRequest extends OrderRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            # [auto-gen-rules]
            'store_id' => 'required|integer',
            'created_store_id' => 'nullable|integer',
            'customer_id' => 'required|integer',
            'lead_id' => 'nullable|integer',
            'customer_name' => 'required|string|max:255',
            'customer_mobile' => 'string|max:20',
            'customer_email' => 'nullable|string|max:255',
            'customer_group_id' => 'nullable|integer',
            'code' => 'nullable|string|max:64',
            'order_status_id' => 'nullable|integer',
            'sub_status_id' => 'nullable|integer',
            'shipping_status_id' => 'nullable|integer',
            'shipping_address_id' => 'nullable|integer',
            'billing_address_id' => 'nullable|integer',
            'product_catalog_id' => 'nullable|integer',
            'sub_total' => 'numeric',
            'grand_total' => 'numeric',
            'discount_amount' => 'numeric',
            'shipping_amount' => 'numeric',
            'tax_amount' => 'numeric',
            'type' => 'nullable|integer',
            'source_id' => 'nullable|integer',
            'source_name' => 'nullable|string|max:255',
            'payment_id' => 'nullable|integer',
            'confirmed_user_id' => 'nullable|integer',
            'assigned_user_id' => 'nullable|integer',
            'delivered_user_id' => 'nullable|integer',
            'approved_user_id' => 'nullable|integer',
            'created_by' => 'required|integer',
            'updated_by' => 'nullable|integer',
            'confirmed_at' => 'nullable|string',
            'delivered_at' => 'nullable|string',
            'approved_at' => 'nullable|string',
            'printed_at' => 'nullable|string',
            'created_at' => 'nullable|string',
            'updated_at' => 'nullable|string',
            'deleted_at' => 'nullable|string',
            'update_success_at' => 'nullable|string',
            'paid_at' => 'nullable|string',
            'transaction_status' => 'nullable|integer',
            'upsale_user_id' => 'nullable|integer',
            'discount_type' => 'nullable|string',
            'surcharge' => 'nullable|numeric',
            'insurance' => 'nullable|numeric',
            'warehouse_id' => 'required|integer',
            'customer_address_id' => 'required|integer'
            # [/auto-gen-rules]
        ];
    }
    
    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            # messages
        ];
    }
}