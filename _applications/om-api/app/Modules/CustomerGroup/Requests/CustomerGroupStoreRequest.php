<?php
namespace App\Modules\CustomerGroup\Requests;


use Common\Http\Requests\AbstractRequest;

class CustomerGroupStoreRequest extends AbstractRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Tên nhóm khách hàng'
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
            'name'    => 'required|max:255'
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
            'required' => ':attribute là bắt buộc!',
            'max' => ':attribute không được vượt quá :max ký tự!'
        ];
    }
}