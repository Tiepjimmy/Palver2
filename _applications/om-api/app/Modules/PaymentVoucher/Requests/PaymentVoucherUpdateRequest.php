<?php
namespace App\Modules\PaymentVoucher\Requests;

use Common\Http\Requests\AbstractRequest;

class PaymentVoucherUpdateRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'store_id' => 'Tổ chức',
            'type_payment_voucher_id' => 'loại chứng từ chi',
            'customer_group_id' => 'Đối tượng nhận',
            'amount' => 'Giá trị',
            'confirmed_at' => 'Ngày ghi nhận',
            'customer_id' => 'tên người nhận',
            'payment_id' => 'Thanh toán',
            'type_voucher' => 'Loại chứng từ',
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'store_id' => 'required|numeric',
            'type_payment_voucher_id' => 'required|numeric',
            'customer_group_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'confirmed_at' => 'required',
            'type_voucher' => 'required',
            'customer_id' => 'required|numeric',
        ];
    }

    /**
     * @return array
     *
     */
    public function messages()
    {
        return [
            'required' => ':attribute là bắt buộc!',

        ];
    }
}