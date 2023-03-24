<?php

namespace App\Modules\PrintForm\Requests;

use Common\Http\Requests\AbstractRequest;

/**
 * [auto-gen-property]
 * @property int $id
 * @property int $store_id
 * @property string $title
 * @property int $type
 * @property string $content
 * @property int $is_default
 * @property int $is_active
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * [/auto-gen-property]
 */
class PrintFormRequest extends AbstractRequest
{
    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            'id' => '',
            'store_id' => '',
            'title' => '',
            'type' => '',
            'content' => '',
            'is_default' => '',
            'is_active' => '',
            'created_by' => '',
            'updated_by' => '',
            'created_at' => '',
            'updated_at' => '',
            'deleted_at' => ''
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [];
    }
}