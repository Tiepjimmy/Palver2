<?php
namespace App\Modules\Campaign\Requests;

use Common\Http\Requests\AbstractRequest;

class CampaignStoreRequest extends AbstractRequest
{
    public function attributes()
    {
        return [
            'title'             => 'Tên chiến dịch',
            'advertisement_id'  =>  'ID quảng cáo',
            'channel_id'        =>  'Kênh',
            'sub_channel_id'    =>  'Sub Kênh',
            'estimated_amount'  =>  'Kinh Phí dự trù',
            'estimated_data'    =>  'Data số dự trù',
            'estimated_revenue' =>  'Doanh thu dự trù',
            'actual_amount'     =>  'Kinh phí thực tế',
            'actual_data'       =>  'Data số thực tế',
            'actual_revenue'    =>  'Doanh thu thực tế',
            'start_at'          =>  'Thời gian bắt đầu',
            'end_at'            =>  'Thời gian kết thúc',
        ];
    }
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
    public function messages()
    {
        return [
            'required' => ':attribute là bắt buộc!',
        ];
    }
}