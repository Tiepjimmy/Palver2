<?php

namespace App\Modules\Order\Requests;

use Common\Http\Requests\AbstractRequest;

/**
 * Class OrderCancelReasonStoreRequest
 * @package App\Modules\Order\Requests
 */
class OrderCancelReasonStoreRequest extends AbstractRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'store_id' => 'Tổ chức',
            'code' => 'Mã lý do hủy đơn hàng',
            'content' => 'Lý do hủy đơn hàng',
            'is_active' => 'Trạng thái',
            'created_by' => 'Người tạo',
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
            'store_id' => 'required|exists:acc_t_stores,id',
            'code' => 'nullable|string|max:20|unique:om_order_cancel_reasons,code',
            'content' => 'required|string|max:200|unique:om_order_cancel_reasons,content',
            'is_active' => 'nullable|boolean',
            'created_by' => 'required|exists:acc_t_users,id'
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
            'required' => ':attribute là bắt buộc.',
            'exists' => ':attribute không tồn tại.',
            'max' => ':attribute không quá :max ký tự.',
            'in' => ':attribute nhập sai.',
            'boolean' => ':attribute phải là hoạt động hoặc không hoạt động.',
            'unique' => ':attribute đã tồn tại.',
        ];
    }
}