<?php

namespace App\Modules\Order\Requests;

use Common\Http\Requests\AbstractRequest;

/**
 * [auto-gen-property]
 * @property int $id
 * @property int $store_id
 * @property int $order_id
 * @property int $invoice_id
 * @property int $payment_method_id
 * @property float $payment_amount
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * [/auto-gen-property]
 */
class OrderCheckoutStoreRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'store_id' => 'Tổ chức',
//            'invoice_id' => 'Hóa đơn',
            'payment_method_id' => 'Phương thức thanh toán',
            'payment_amount' => 'Giá trị thanh toán',
            'created_by' => 'Người tạo',
            'updated_by' => 'Người sửa',
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'store_id' => 'required|exists:acc_t_stores,id',
            'invoice_id' => 'nullable|exists:om_order_invoice,id',
            'payment_method_id' => 'required|exists:om_payment_methods,id',
            'payment_amount' => 'required|min:0',
            'created_by' => 'required|exists:acc_t_users,id',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'required' => ':attribute là bắt buộc.',
            'exists' => ':attribute không tồn tại.',
            'min' => ':attribute có giá trị lớn hơn :min.',
        ];
    }
}