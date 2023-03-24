<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\PermissionGroups\Requests;

use App\Http\Requests\AbstractRequest;

class PermissionGroupsCreateRequest extends AbstractRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'store_id' => 'Tổ chức',
            'group_name' => 'Tên nhóm quyền',
            'permission_id' => 'Quyền',
            'subsystem_id' => 'Phân hệ',
            'active_status' => 'Trạng thái',
            'group_type' => 'Loại nhóm quyền'
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
            "store_id" => "required|array",
            "store_id.*" => "integer",
            "group_name" => "required|string|unique:acc_t_permission_groups,group_name",
            "permission_id" => "required|array",
            "permission_id.*" => 'integer',
            "active_status" => "required|in:active,inactive",
            "group_type" => "required|in:single,full",
            "subsystem_id" => 'required|integer'
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
            'in' => ':attribute không hợp lệ.',
            'unique' => ':attribute đã tồn tại.'
        ];
    }
}