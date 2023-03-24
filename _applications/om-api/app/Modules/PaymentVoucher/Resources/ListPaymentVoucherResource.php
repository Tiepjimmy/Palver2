<?php

namespace App\Modules\PaymentVoucher\Resources;

use Common\Http\Resources\AbstractResource;

class ListPaymentVoucherResource extends AbstractResource
{
    /**
     * @var ListPaymentVoucherResource $resource
     */
    public $resource;

    /**
     * @param mixed $request
     * @return mixed
     */
    public function toArray($request)
    {
        return [
            'current_page' => $this->resource['current_page'],
            'total_page' => $this->resource['total_page'],
            'per_page' => $this->resource['per_page'],
            'total' => $this->resource['total'],
            'items' => $this->resource['items']->map(function ($item) {
                return [
                    'id' => $item['id'],
                    'voucher_code' => $item['voucher_code'],
                    'store_id' => $item['store_id'],
                    'amount' => $item['amount'],
                    'type_voucher' => $item['type_voucher'],
                    'type_payment_voucher_id' => $item['type_payment_voucher_id'],
                    'customer_group_id' => $item['customer_group_id'],
                    'confirmed_at' => $item['confirmed_at'],
                    'is_business_result' => $item['is_business_result'],
                    'is_active' => $item['is_active'],
                    'customer_id' => $item['customer_id'],
                    'note' => $item['note'],
                    'description' => $item['description'],
                    'updated_by' => $item['updated_by'],
                    'created_at' => $item['created_at'],
                    'updated_at' => $item['updated_at'],
                    'created_by' => $item['user'],
                    'orderPaymentVoucher' => $item['orderPaymentVoucher'],
                    'typePaymentVoucher' => $item['typePaymentVoucher'],
                    'customer' => $item['customer'],
                    'customerGroup' => $item['customerGroup'],
                    'order' => $item['order'],
                ];
            })
        ];
    }
}