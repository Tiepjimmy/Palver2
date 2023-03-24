<?php

namespace App\Modules\MissionResult\Requests;

use Common\Http\Requests\AbstractRequest;

class MissionResultStoreRequest extends AbstractRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return array(
            'name' => 'Tên kết quả',
            'lead_status_id' => 'Trạng thái',

        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array(
            'name' => 'required',
            'lead_status_id' => 'required',
        );
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return array(
            'required'  => ':attribute là bắt buộc!',
        );
    }
}
