<?php
namespace App\Modules\Payment\Requests;

use Common\Http\Requests\AbstractRequest;

class PaymentUpdateRequest extends AbstractRequest
{
    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            'bank_name'     => 'Tên ngân hàng',
            'card_type'     => 'Loại thẻ',
            'card_number'   =>  'Số thẻ',
            'is_active'     =>  'Trạng thái',
            'account_number'=>  'Số tài khoản',
            'card_owner'    =>  'Chủ Thẻ'

        ];
    }

    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'bank_name'=>'required',
            'card_type'=>'required',
            'card_number'   =>  'required',
            'is_active'     =>  'required',
            'account_number'=>  'required',
            'card_owner'    =>  'required'

        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'required' => ':attribute là bắt buộc!',
            'max' => ':attribute không được vượt quá :max ký tự!'
        ];
    }
}