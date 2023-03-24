<?php
namespace App\Modules\Payment\Requests;

use Common\Http\Requests\AbstractRequest;

class TypeCollectVoucherStoreRequest extends AbstractRequest
{
    public function attributes()
    {
        return [
            'type_code'     => 'Mã loại chứng từ thu',
            'type_name'     => 'Tên loại chứng từ thu',
            'note'   =>  'Mô tả',
            'is_active'   =>  'Hiệu lực',
            'is_business_result'   =>  'Hạch toán kết quả kinh doanh',
        ];
    }
    public function rules()
    {
        return [
            'type_code'     =>  'required|max:25',
            'type_name'     =>  'required|max:255',
            'note'   =>  'nullable|max:255',
            'is_active'   =>  'nullable',
            'is_business_result'   =>  'nullable',

        ];
    }
    public function messages()
    {
        return [
            'required' => ':attribute là bắt buộc',
            'max' => ':attribute không được vượt quá :max ký tự'
        ];
    }
}