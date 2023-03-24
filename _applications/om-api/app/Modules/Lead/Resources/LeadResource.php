<?php

namespace App\Modules\Lead\Resources;

use Common\Http\Resources\AbstractResource;
use Illuminate\Http\Resources\MergeValue;
use OmSdk\Modules\Lead\Models\Lead;

class LeadResource extends AbstractResource
{
    /**
     * @var Lead $resource
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
            'code' => $this->resource->code,
            'customer_id' => $this->resource->customer_id,
            'name' => $this->resource->name,
            'mobile' => $this->resource->mobile,
            'email' => $this->resource->email,
            'gender' => $this->resource->gender,
            'lead_status_id' => $this->resource->lead_status_id,
            'note' => $this->resource->note,
            'channel_id' => $this->resource->channel_id,
            'sub_channel_id' => $this->resource->sub_channel_id,
            'product_catalog_id' => $this->resource->product_catalog_id,
            'url' => $this->resource->url,
            'type' => $this->resource->type,
            'mission_id' => $this->resource->mission_id,
            'mission_script_id' => $this->resource->mission_script_id,
            'marketer_id' => $this->resource->marketer_id,
            'seller_id' => $this->resource->seller_id,
            'assigned_user_id' => $this->resource->assigned_user_id,
            'assigned_group_id' => $this->resource->assigned_group_id,
            'is_duplicated' => $this->resource->is_duplicated,
            'created_by' => $this->resource->created_by,
            'updated_by' => $this->resource->updated_by,
            'assigned_at' => $this->resource->assigned_at,
            'last_supported_at' => $this->resource->last_supported_at,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'source_id' => $this->resource->source_id,
            'country_id' => $this->resource->country_id,
            'province_id' => $this->resource->province_id,
            'district_id' => $this->resource->district_id,
            'ward_id' => $this->resource->ward_id,
            'description' => $this->resource->description,
            # [/auto-gen-resource]
            new MergeValue([
                'channel' => $this->resource->channel,
                'lead_status' => $this->resource->leadStatus,
                'sub_channel' => $this->resource->subChannel,
                'user_assigned' => $this->resource->userAssigned,
                'user_created' => $this->resource->userCreated,
                'task' => $this->resource->task,
                'script' => $this->resource->script,
                'product_catalog' => $this->resource->productCatalog
            ])
        ];
    }
}