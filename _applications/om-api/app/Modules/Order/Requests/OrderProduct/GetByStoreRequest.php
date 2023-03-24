<?php

namespace App\Modules\Order\Requests\OrderProduct;

use Common\Http\Requests\AbstractRequest;

class GetByStoreRequest extends AbstractRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'store_id'  => 'Cửa hàng'
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
            'store_id'  => 'required|numeric'
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
