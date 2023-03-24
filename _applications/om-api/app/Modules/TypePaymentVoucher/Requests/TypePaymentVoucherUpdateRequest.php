<?php
namespace App\Modules\TypePaymentVoucher\Requests;

use Common\Http\Requests\AbstractRequest;

class TypePaymentVoucherUpdateRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'type_code' => 'mã loại chứng từ',
            'type_name' => 'tên loại chứng từ',
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'type_code' => 'required',
            'type_name' => 'required',

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