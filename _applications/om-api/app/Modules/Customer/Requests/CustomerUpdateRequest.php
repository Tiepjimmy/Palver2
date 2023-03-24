<?php
namespace App\Modules\Customer\Requests;


use Common\Http\Requests\AbstractRequest;

class CustomerUpdateRequest extends AbstractRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'mobile' => 'Số điện thoại',
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
            'mobile' => 'required',
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
            'unique' => ':attribute đã tồn tại'
        ];
    }
}