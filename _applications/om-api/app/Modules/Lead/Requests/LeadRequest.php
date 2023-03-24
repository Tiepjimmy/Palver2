<?php

namespace App\Modules\Lead\Requests;

use Common\Http\Requests\AbstractRequest;

/**
 * [auto-gen-property]
 * @property int $id
 * @property int $store_id
 * @property int $customer_id
 * @property string $name
 * @property string $mobile
 * @property string $email
 * @property int $gender
 * @property int $lead_status_id
 * @property string $note
 * @property int $channel_id
 * @property int $sub_channel_id
 * @property int $product_catalog_id
 * @property string $url
 * @property int $type
 * @property int $mission_id
 * @property int $mission_script_id
 * @property int $marketer_id
 * @property int $seller_id
 * @property int $assigned_user_id
 * @property int $assigned_group_id
 * @property int $is_duplicated
 * @property int $created_by
 * @property int $updated_by
 * @property string $assigned_at
 * @property string $last_supported_at
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property int $source_id
 * @property int $country_id
 * @property int $province_id
 * @property int $district_id
 * @property int $ward_id
 * [/auto-gen-property]
 */
class LeadRequest extends AbstractRequest
{
    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            'id' => '',
            'store_id' => '',
            'customer_id' => '',
            'name' => '',
            'mobile' => '',
            'email' => '',
            'gender' => '',
            'lead_status_id' => '',
            'note' => '',
            'channel_id' => '',
            'sub_channel_id' => '',
            'product_catalog_id' => '',
            'url' => '',
            'type' => '',
            'mission_id' => '',
            'mission_script_id' => '',
            'marketer_id' => '',
            'seller_id' => '',
            'assigned_user_id' => '',
            'assigned_group_id' => '',
            'is_duplicated' => '',
            'created_by' => '',
            'updated_by' => '',
            'assigned_at' => '',
            'last_supported_at' => '',
            'created_at' => '',
            'updated_at' => '',
            'deleted_at' => '',
            'source_id' => '',
            'country_id' => '',
            'province_id' => '',
            'district_id' => '',
            'ward_id' => ''
        ];
    }
}