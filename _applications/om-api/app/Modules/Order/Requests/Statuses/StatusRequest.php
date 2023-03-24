<?php

namespace App\Modules\Order\Requests\Statuses;

use Common\Http\Requests\AbstractRequest;

class StatusRequest extends AbstractRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'store_id'  => 'Cửa hàng',
            'name'      => 'Tên trạng thái'
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
            'store_id'  => 'required|numeric',
            'name'      => 'required'
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
            'numeric'   => ':attribute phải là kiểu số!'
        ];
    }
}