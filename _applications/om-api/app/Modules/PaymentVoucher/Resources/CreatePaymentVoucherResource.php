<?php

namespace App\Modules\PaymentVoucher\Resources;

use Common\Http\Resources\AbstractResource;

class CreatePaymentVoucherResource extends AbstractResource
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
            'type_payment_voucher' => $this->resource['type_payment_voucher'],
            'customer_group' => $this->resource['customer_group'],
        ];
    }

}