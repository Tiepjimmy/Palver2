<?php

namespace App\Modules\SubChannel\Requests;

use Common\Http\Requests\AbstractRequest;

class SubChannelUpdateRequest extends AbstractRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'channel_id' => 'Kênh',
            'name' => 'Tên Sub kênh',
            'is_active' => 'Hoạt động'
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
            'name' => 'required|max:255',
            'channel_id' => 'required',
            'is_active' => 'required',
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
            'max' => ':attribute không được vượt quá :max ký tự!',
            'unique' => ':attribute Không được phép trùng'
        ];
    }
}