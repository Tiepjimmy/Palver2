<?php

namespace App\Modules\Order\Requests;

class OrderPaymentConfirmBulkRequest extends OrderRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*'   => 'integer|numeric',
        ];
    }
}
