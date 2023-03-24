<?php

namespace App\Modules\PrintForm\Requests;

class PrintFormUpdateRequest extends PrintFormStoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            # [auto-gen-rules]
            'store_id' => 'integer',
            'title' => 'string|max:255',
            'type' => 'nullable|integer',
            'content' => 'string',
            'created_by' => 'integer',
            'updated_by' => 'nullable|integer',
            'created_at' => 'nullable|string',
            'updated_at' => 'nullable|string',
            'deleted_at' => 'nullable|string'
            # [/auto-gen-rules]
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return array_merge(parent::messages(), [
            # messages
        ]);
    }
}