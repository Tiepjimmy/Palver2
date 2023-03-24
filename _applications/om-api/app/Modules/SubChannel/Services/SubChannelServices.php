<?php

namespace App\Modules\SubChannel\Services;

use App\Exceptions\ErrorMessage;
use App\Http\PalServiceErrorCode;
use Common\Exceptions\PalException;
use Common\Exceptions\PalValidationException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use OmSdk\Modules\Campaign\Repositories\Contracts\ICampaignRepository;
use OmSdk\Modules\Lead\Repositories\Contracts\ILeadRepository;
use OmSdk\Modules\Order\Services\IOrderService;
use OmSdk\Modules\SubChannel\Models\SubChannel;
use OmSdk\Modules\SubChannel\Repositories\Contracts\ISubChannelRepository;

class SubChannelServices
{
    protected $subChannelRepository;
    protected $campaignRepository;
    protected $orderInterFace;
    protected $leadRepository;

    public function __construct(
        ISubChannelRepository $subChannelRepository,
        ICampaignRepository $campaignRepository,
        IOrderService $orderInterFace,
        ILeadRepository $leadRepository
    )
    {
        $this->subChannelRepository = $subChannelRepository;
        $this->campaignRepository = $campaignRepository;
        $this->orderInterFace = $orderInterFace;
        $this->leadRepository = $leadRepository;
    }

    /**
     * get List channel
     * @param $request
     * @param $limit
     * @param $offset
     * @return array
     */
    public function list($request, $limit, $offset)
    {
        $keyword = $request->filled('s') ? $request->input('s') : null;

        $channel_id = $request->filled('channel_id') ? $request->input('channel_id') : null;

        $total = $this->subChannelRepository->checkExist([
            's' => $keyword,
            'channel_id' => $channel_id
        ]);

        $listSubChannel = $this->subChannelRepository->getMore(
            array(
                's' => $keyword,
                'channel_id' => $channel_id,
            ),
            array(
                'limit' => $limit,
                'offset' => $offset,
            )
        );

        return [
            $listSubChannel,
            $total
        ];
    }

    /**
     * store Channel
     * @param $request
     * @return mixed
     */
    public function store($request)
    {
        $conn = $this->subChannelRepository->getConnection();

        $subChannelData = $this->subChannelRepository->create([
            'store_id' => 1,
            'created_by' => 1,
            'name' => $request['name'],
            'code' => !empty($request['code']) ? $request['code'] : Str::uuid()->toString(),
            'channel_id' => $request['channel_id'],
            'content' => !empty($request['content']) ? $request['content'] : '',
            'is_active' => 1
        ]);
        $subChannelId = $subChannelData->id;

        if (Str::isUuid($subChannelData->code)) {
            return $this->subChannelRepository->updateById($subChannelId, [
                'code' => sprintf('SK%03d', $subChannelId)
            ]);
        }

        if (is_null($subChannelData)) {
            throw new PalException(PalServiceErrorCode::LOI_HE_THONG);
        }

        return $subChannelData;
    }

    /**
     * Update channel
     * @param $id
     * @param $request
     * @return void
     */
    public function update($id, $request)
    {
        if ($request->is_active == SubChannel::NOT_ACTIVE) {
            $condition = [
                'store_id' => 1,
                'sub_channel_id' => $id
            ];

            $this->subChannelNotUsed($condition);
        }

        $conn = $this->subChannelRepository->getConnection();

        $validators = Validator::make($request->all(), [
            'code' => 'unique:' . $conn . '.om_marketing_sub_channels,code,' . $id
        ]);

        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',400);
        }

        $updateSubChannel = $this->subChannelRepository->updateById($id, $request->toArray());

        if (is_null($updateSubChannel)) {
            throw new PalException(PalServiceErrorCode::LOI_HE_THONG);
        }

        return $updateSubChannel;
    }

    /**
     * @param array $ids
     * @return void
     */
    public function destroyMultil(array $ids)
    {
        $notDelIds = [];
        $message = [];

        foreach ($ids as $id) {
            $condition['sub_channel_id'] = $id;
            $fetchOption['with'] = ['subChannel'];
            $campaign = $this->campaignRepository->getOne($condition, $fetchOption);

            if ($campaign) {
                $notDelIds[$id] = $id;
                $message[$id] = $campaign->subChannel->name . 'đã/đang tham gia chiến dịch';
                continue;
            }

            $lead = $this->leadRepository->getOne($condition, $fetchOption);

            if ($lead) {
                $notDelIds[$id] = $id;
                $message[$id] = $lead->subChannel->name . 'đã/đang được sử dụng';
            }
        }

        if (! empty($notDelIds)) {
            $delete = array_diff($ids, $notDelIds);
            $message = implode(', ', array_values($message));
            $this->subChannelRepository->destroy($delete);

            throw new Exception($message, 422);
        }

        return $this->subChannelRepository->destroy($ids);
    }

    /**
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function destroy($id)
    {
        $condition = [
            'store_id' => 1,
            'sub_channel_id' => $id
        ];

        $this->subChannelNotUsed($condition);

        return $this->subChannelRepository->delByCond([
            'id' => $id
        ]);
    }

    /**
     * @param $condition
     * @return bool
     * @throws Exception
     */
    public function subChannelNotUsed($condition)
    {
        $campaign = $this->campaignRepository->getOne($condition);

        if ($campaign) {
            throw new Exception('Sub kênh đang tham gia chạy chiến dịch ' . $campaign->title);
        }

        $lead = $this->leadRepository->getOne($condition);

        if ($lead) {
            throw new Exception('Sub kênh đã sử dụng cho data số ' . $lead->name );
        }

        return true;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $conditions = [
            'store_id' => 1,
            'is_active' => 1
        ];

        return $this->subChannelRepository->getMore($conditions);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function checkExist($request)
    {
        $subChannelCode = $request->filled('code') ? $request->input('code') : null;

        $totalSubChannel = $this->subChannelRepository->checkExist([
            'code' => $subChannelCode
        ]);

        return $totalSubChannel > 0;
    }

}
