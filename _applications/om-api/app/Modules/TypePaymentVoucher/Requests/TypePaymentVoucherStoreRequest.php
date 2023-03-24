<?php
namespace App\Modules\TypePaymentVoucher\Requests;

use Common\Http\Requests\AbstractRequest;

class TypePaymentVoucherStoreRequest extends AbstractRequest
{
    public function attributes()
    {
        return [
            'type_code' => 'mã loại chứng từ',
            'type_name' => 'tên loại chứng từ',

        ];
    }
    public function rules()
    {
        return [
            'type_code' => 'required|string|max:20',
            'type_name' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'required' => ':attribute là bắt buộc!',
            'unique' => ':attribute đã tồn tại',
            'max' => ':attribute không quá :max ký tự',
        ];
    }
}