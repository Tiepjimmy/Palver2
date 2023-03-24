<?php

namespace App\Modules\Customer\Resources;

use Common\Http\Resources\AbstractResource;
use OmSdk\Modules\Customer\Models\Customer;

class CustomerResources extends AbstractResource
{
    /**
     * @var Customer $resource
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) {
        return [
            # [auto-gen-resource]
            'id' => $this->resource->id,
            'store_id' => $this->resource->store_id,
            'created_store_id' => $this->resource->created_store_id,
            'name' => $this->resource->name,
            'mobile' => $this->resource->mobile,
            'email' => $this->resource->email,
            'customer_group_id' => $this->resource->customer_group_id,
            'code' => $this->resource->code,
            'gender' => $this->resource->gender,
            'facebook' => $this->resource->facebook,
            'zone_id' => $this->resource->zone_id,
            'address' => $this->resource->address,
            'type' => $this->resource->type,
            'source_id' => $this->resource->source_id,
            'organization_name' => $this->resource->organization_name,
            'organization_information' => $this->resource->organization_information,
            'bank_name' => $this->resource->bank_name,
            'bank_account_name' => $this->resource->bank_account_name,
            'bank_account_number' => $this->resource->bank_account_number,
            'imported_account_id' => $this->resource->imported_account_id,
            'imported_code' => $this->resource->imported_code,
            'total_revenue' => $this->resource->total_revenue,
            'image_url' => $this->resource->image_url,
            'assigned_user_id' => $this->resource->assigned_user_id,
            'inviter_id' => $this->resource->inviter_id,
            'contact_id' => $this->resource->contact_id,
            'created_by' => $this->resource->created_by,
            'updated_by' => $this->resource->updated_by,
            'birth_date' => $this->resource->birth_date,
            'imported_at' => $this->resource->imported_at,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'extra_mobile' => $this->resource->extra_mobile,
            'country_id' => $this->resource->country_id,
            'province_id' => $this->resource->province_id,
            'district_id' => $this->resource->district_id,
            'ward_id' => $this->resource->ward_id,
            # [/auto-gen-resource]
        ];
    }
}