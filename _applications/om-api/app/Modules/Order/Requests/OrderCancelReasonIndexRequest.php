<?php

namespace App\Modules\Order\Requests;

use Common\Http\Requests\AbstractRequest;

/**
 * Class OrderCancelReasonIndexRequest
 * @package App\Modules\Order\Requests
 */
class OrderCancelReasonIndexRequest extends AbstractRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'keyword'   => 'nullable|string',
            'limit'  => 'nullable|numeric',
            'offset'  => 'nullable|numeric'
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return  [];
    }
}