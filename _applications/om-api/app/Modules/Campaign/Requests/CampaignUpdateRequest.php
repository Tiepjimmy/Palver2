<?php
namespace App\Modules\Campaign\Requests;

use Common\Http\Requests\AbstractRequest;

class CampaignUpdateRequest extends AbstractRequest
{
    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'title'             => 'Tên chiến dịch',
            'advertisement_id'  =>  'ID quảng cáo',
            'channel_id'        =>  'Kênh',
            'sub_channel_id'    =>  'Sub Kênh',
            'start_at'          =>  'Thời gian bắt đầu',
            'end_at'            =>  'Thời gian kết thúc',
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'title'             =>  'required',
            'advertisement_id'  =>  'required',
            'channel_id'        =>  'required',
            'sub_channel_id'    =>  'required',
            'start_at'          =>  'required',
            'end_at'            =>  'required',

        ];
    }

    /**
     * @return array
     *
     */
    public function messages()
    {
        return [
            'required' => ':attribute là bắt buộc!',
        ];
    }
}