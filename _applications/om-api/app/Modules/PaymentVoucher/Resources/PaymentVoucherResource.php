<?php

namespace App\Modules\PaymentVoucher\Resources;

use Common\Http\Resources\AbstractResource;

class PaymentVoucherResource extends AbstractResource
{
    /**
     * @var PaymentVoucherResource $resource
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
            'id' => $this->resource['id'],
            'voucher_code' => $this->resource['voucher_code'],
            'store_id' => $this->resource['store_id'],
            'amount' => $this->resource['amount'],
            'type_voucher' => $this->resource['type_voucher'],
            'type_payment_voucher_id' => $this->resource['type_payment_voucher_id'],
            'customer_group_id' => $this->resource['customer_group_id'],
            'confirmed_at' => $this->resource['confirmed_at'],
            'is_business_result' => $this->resource['is_business_result'],
            'is_active' => $this->resource['is_active'],
            'customer_id' => $this->resource['customer_id'],
            'note' => $this->resource['note'],
            'description' => $this->resource['description'],
            'created_by' => $this->resource['created_by'],
            'updated_by' => $this->resource['updated_by'],
            'created_at' => $this->resource['created_at'],
            'updated_at' => $this->resource['updated_at'],
            'orderPaymentVoucher' => $this->resource['orderPaymentVoucher'],
            'typePaymentVoucher' => $this->resource['typePaymentVoucher'],
            'customer' => $this->resource['customer'],
            'customerGroup' => $this->resource['customerGroup'],
        ];
    }

}