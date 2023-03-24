<?php

namespace App\Modules\Order\Requests;

use App\Modules\Order\Requests\OrderRequest;

class OrderApproveBulkRequest extends OrderRequest
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