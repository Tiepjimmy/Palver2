<?php

namespace App\Modules\Lead\Requests;

class LeadUpdateRequest extends LeadStoreRequest
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
            'id' => 'required|integer',
            'store_id' => 'integer',
            'customer_id' => 'nullable|integer',
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'nullable|string|max:255',
            'gender' => 'nullable|integer',
            'lead_status_id' => 'required|nullable|integer',
            'note' => 'nullable|string|max:500',
            'channel_id' => 'required|integer',
            'sub_channel_id' => 'required|integer',
            'product_catalog_id' => 'nullable|integer',
            'url' => 'nullable|string|max:255',
            'type' => 'required|integer',
            'mission_id' => 'nullable|integer',
            'mission_script_id' => 'nullable|integer',
            'marketer_id' => 'nullable|integer',
            'seller_id' => 'nullable|integer',
            'assigned_user_id' => 'nullable|integer',
            'assigned_group_id' => 'nullable|integer',
            'is_duplicated' => 'nullable|integer',
            'created_by' => 'integer',
            'updated_by' => 'nullable|integer',
            'assigned_at' => 'nullable|string',
            'last_supported_at' => 'nullable|string',
            'created_at' => 'nullable|string',
            'updated_at' => 'nullable|string',
            'deleted_at' => 'nullable|string',
            'source_id' => 'nullable|integer',
            'country_id' => 'nullable|integer',
            'province_id' => 'nullable|integer',
            'district_id' => 'nullable|integer',
            'ward_id' => 'nullable|integer'
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