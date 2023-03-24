<?php

namespace App\Modules\Channel\Services;

use AccountSdkDb\Modules\Master\Repositories\Contracts\PermissionInterface;
use AccountSdkDb\Modules\Master\Services\IPermissionService;
use AccountSdkDb\Modules\User\Repositories\Eloquent\UserRepository;
use App\Exceptions\ErrorMessage;
use App\Http\PalServiceErrorCode;
use App\Modules\Channel\Requests\ChannelUpdateRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use OmSdk\Exceptions\PalException;
use OmSdk\Exceptions\PalValidationException;
use OmSdk\Modules\Campaign\Repositories\Contracts\ICampaignRepository;
use OmSdk\Modules\Channel\Models\Channel;
use OmSdk\Modules\Channel\Repositories\Contracts\IChannelRepository;
use OmSdk\Modules\Lead\Repositories\Contracts\ILeadRepository;
use OmSdk\Modules\SubChannel\Models\SubChannel;
use OmSdk\Modules\SubChannel\Repositories\Contracts\ISubChannelRepository;

class ChannelServices
{
    protected $channelRepository;
    protected $subChannelRepository;
    protected $campaignRepository;
    protected $permissionUser;
    protected $userRepository;
    protected $leadRepository;

    public function __construct(
        IChannelRepository $channelRepository,
        ISubChannelRepository $subChannelRepository,
        ICampaignRepository $campaignRepository,
        IPermissionService $permissionUser,
        UserRepository $userRepository,
        ILeadRepository $leadRepository
    )
    {
        $this->channelRepository = $channelRepository;
        $this->subChannelRepository = $subChannelRepository;
        $this->campaignRepository =$campaignRepository;
        $this->permissionUser = $permissionUser;
        $this->userRepository = $userRepository;
        $this->leadRepository = $leadRepository;
    }

    /**
     * get List channel
     * @param Request $request
     * @param $limit
     * @param $offset
     * @return array
     */
    public function list($request ,$limit ,$offset)
    {
        $condition = [
            'filter' => $request->toArray()
        ];

        $totals = $this->channelRepository->checkExist($condition);

        $listChannel = $this->channelRepository->getMore(
            $condition,
            [
                'limit' => $limit,
                'offset' => $offset,
            ]
        );

        return [
            $listChannel,
            $totals
        ];
    }

    /**
     * store Channel
     * @param $request
     * @return mixed
     */
    public function store(array $request)
    {

        $storeChannel = $this->channelRepository->create([
            'store_id' => 1,
            'created_by' => 1,
            'name' => $request['name'],
            'is_active' =>  1,
            'code' => Str::uuid()->toString()
        ]);

        return $storeChannel;
    }

    /**
     * Update channel
     * @param $id
     * @param ChannelUpdateRequest $request
     * @return boolean
     * @throws Exception
     */
    public function update($id, $request)
    {
        if ($request->is_active == Channel::NOT_ACTIVE) {
            $condition = [
                'store_id' => 1,
                'channel_id' => $id
            ];

            $this->channelNotUsed($condition);
        }

        $updateChannel = $this->channelRepository->updateById($id, [
            'name' => $request->name,
            'is_active' => $request->is_active

        ]);

        if ($updateChannel->is_active == Channel::NOT_ACTIVE) {
            $listSubChannel = $this->channelRepository->getOne(
                [
                    'id' => $id
                ],
                [
                    'with' => 'subChannel'
                ]);

            foreach ($listSubChannel->subChannel as $subChannel) {
                $this->subChannelRepository->updateById($subChannel->id, [
                    'is_active' => SubChannel::NOT_ACTIVE
                ]);
            }
        }

        return $updateChannel;
    }

    /**
     * @param array $ids
     * @return boolean
     * @throws PalValidationException
     * @throws Exception
     */
    public function destroyMultil(array $ids)
    {
        $notDelIds = [];
        $message = [];

        foreach ($ids as $id) {
            $condition['store_id'] = 1;
            $condition['channel_id'] = $id;
            $fetchOption['with'] = ['channel'];
            $campaign = $this->campaignRepository->getOne($condition, $fetchOption);

            if ($campaign) {
                $notDelIds[$id] = $id;
                $message[$id] = $campaign->channel->name . 'đã/đang tham gia chiến dịch';
                continue;
            }

            $lead = $this->leadRepository->getOne($condition, $fetchOption);

            if ($lead) {
                $notDelIds[$id] = $id;
                $message[$id] = $lead->channel->name . 'đã/đang được sử dụng';
                continue;
            }
        }

        $delete = array_diff($ids, $notDelIds);
        $conditionSubChannel['store_id'] = 1;
        $conditionSubChannel['channel_ids'] = $delete;
        $subChannel = $this->subChannelRepository->getMore($conditionSubChannel);

        $delete = $this->channelRepository->destroy($delete);
        $this->subChannelRepository->destroy($subChannel->pluck('id'));

        if (! empty($notDelIds)) {
            $message = implode(', ', array_values($message));

            throw new Exception($message, 422);
        }

        return $delete;
    }

    /**
     * @param $channelId
     * @return mixed
     * @throws Exception
     */
    public function destroy($channelId)
    {
        $condition = [
            'store_id' => 1,
            'channel_id' => $channelId
        ];

        $this->channelNotUsed();

        $subChannel = $this->subChannelRepository->getMore($condition);

        if (! empty($subChannel)) {
            $this->subChannelRepository->destroy($subChannel->pluck('id'));
        }

        return $this->channelRepository->destroy($channelId);
    }

    /**
     * @param $condition
     * @return bool
     * @throws Exception
     */
    public function channelNotUsed($condition)
    {
        $campaign = $this->campaignRepository->getOne($condition);

        if ($campaign) {
            throw new Exception('Kênh đang tham gia chạy chiến dịch ', 400);
        }

        $lead = $this->leadRepository->getOne($condition);

        if ($lead) {
            throw new Exception('Kênh đã được sử dụng cho data số' , 400);
        }

        return true;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $condition = [
            'filter' => [
                'store_id' => 1,
                'is_active' => Channel::IS_ACTIVE,
            ]
        ];

        $fetchOptions['select'] = ['id', 'name', 'is_active'];

        $listChannel = $this->channelRepository->getMore($condition, $fetchOptions);

        return $listChannel;
    }

    /**
     * @return array
     */
    public function getListUserPermissionMarketing()
    {
        $condition['store_id'] = 1;

        return $this->userRepository->getMore($condition);
    }

}
