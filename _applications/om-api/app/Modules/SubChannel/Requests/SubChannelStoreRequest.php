<?php
namespace App\Modules\SubChannel\Requests;

use Common\Http\Requests\AbstractRequest;

class SubChannelStoreRequest extends AbstractRequest
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
            'name'  =>  'Tên Sub kênh',
            'code'  =>  'Mã Sub Kênh'
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
            'name'             => 'required|max:255',
            'channel_id'        => 'required',
            'code'              => 'unique:om_marketing_sub_channels,code'
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