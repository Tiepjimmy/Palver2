<?php

namespace App\Modules\PrintForm\Requests;

class PrintFormStoreRequest extends PrintFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'store_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'type' => 'nullable|integer',
            'content' => 'required|string',
            'is_default' => 'integer',
        ];
    }
    
    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            # messages
        ];
    }
}
