<?php
namespace App\Modules\Payment\Requests;

use Common\Http\Requests\AbstractRequest;

class PaymentStoreRequest extends AbstractRequest
{
    public function attributes()
    {
        return [
            'bank_name'     => 'Tên ngân hàng',
            'card_type'     => 'Loại thẻ',
            'card_number'   =>  'Số thẻ',
            'account_number'=>  'Số tài khoản',
            'card_owner'    =>  'Chủ Thẻ'

        ];
    }
    public function rules()
    {
        return [
            'bank_name'     =>  'required',
            'card_type'     =>  'required',
            'card_number'   =>  'required|unique:om_marketing_payment_accounts,card_number',
            'account_number'=>  'required|unique:om_marketing_payment_accounts,account_number',
            'card_owner'    =>  'required'

        ];
    }
    public function messages()
    {
        return [
            'required' => ':attribute là bắt buộc!',
            'max' => ':attribute không được vượt quá :max ký tự!',
            'unique' => ':attribute Không được phép trùng'
        ];
    }
}