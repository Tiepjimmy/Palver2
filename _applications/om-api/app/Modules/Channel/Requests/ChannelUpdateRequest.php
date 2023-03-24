<?php

namespace App\Modules\Channel\Requests;

use Common\Http\Requests\AbstractRequest;

class ChannelUpdateRequest extends AbstractRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Tên kênh',
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
            'name'  => 'required|max:255',
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
