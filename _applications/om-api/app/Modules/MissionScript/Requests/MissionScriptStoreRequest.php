<?php

namespace App\Modules\MissionScript\Requests;

use Common\Http\Requests\AbstractRequest;

class MissionScriptStoreRequest extends MissionScriptRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return array(
            'task_id'   => 'Nhiệm vụ',
            'result_id' => 'Kết quả',
            'next_task_id'=>'Nhiệm vụ kế tiếp',
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
            'task_id'   => 'required',
            'result_id' => 'required',
            'next_task_id'=>'required',
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
