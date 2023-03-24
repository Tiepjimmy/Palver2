<?php

namespace App\Modules\Customer\Requests\CustomerAddress;

use Common\Http\Requests\AbstractRequest;

class CustomerAddressRequest extends AbstractRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'mobile'        => 'Điện thoại',
            'email'         => 'Địa chỉ mail',
            'country_id'    => 'Quốc gia',
            'province_id'   => 'Tỉnh/Thành',
            'district_id'   => 'Quận/Huyện',
            'ward_id'       => 'Xã/Phường/Thị Trấn',
            'address'       => 'Địa chỉ chi tiết',
            'is_default'    => 'Mặc định'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mobile'        => 'required',
            'email'         => 'email',
            'country_id'    => 'numeric',
            'province_id'   => 'numeric',
            'district_id'   => 'numeric',
            'ward_id'       => 'numeric',
            'address'       => '',
            'is_default'    => ''
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required'  => ':attribute là bắt buộc!',
            'numeric'   => ':attribute phải là kiểu số!',
            'email'     => ':attribute phải có dạng email!',
        ];
    }
}
