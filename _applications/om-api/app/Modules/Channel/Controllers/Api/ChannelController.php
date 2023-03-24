<?php

namespace App\Modules\Channel\Controllers\Api;

use App\Http\PalServiceErrorCode;
use App\Modules\Channel\Requests\ChannelUpdateRequest;
use App\Modules\Channel\Services\ChannelServices;
use App\Modules\Channel\Requests\ChannelCreateRequest;
use App\Modules\Channel\Resources\ChannelResource;
use Common\Http\Controllers\Api\AbstractApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChannelController extends AbstractApiController
{
    /**
     * @var ChannelServices $channelService
     */
    private $channelService;

    public function __construct(ChannelServices $channelService)
    {
        parent::__construct();

        $this->channelService = $channelService;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $limit = $request->filled('limit')
            && is_numeric($request->input('limit')) ? (int)$request->input('limit') : 10;
        $offset = $request->filled('offset')
            && is_numeric($request->input('offset')) ? (int)$request->input('offset') : 0;

        [$items, $total] = $this->channelService->list($request, $limit, $offset);
        $items = ChannelResource::collection($items);

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR,
            [
                'items' => $items,
                'total' => $total,
                'limit' => $limit,
                'offset' => $offset
            ]
        );
    }

    /**
     * Lưu thông tin tạo mới kenh thong tin
     * @param ChannelCreateRequest $request
     * @return mixed
     */
    public function store(ChannelCreateRequest $request)
    {
        $storeChannel =  $this->channelService->store($request->all());

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $storeChannel);
    }

    /**
     * @param $id
     */
    public function edit($id)
    {

    }

    /**
     * @param $id
     * @param ChannelUpdateRequest $request
     * @return mixed
     */
    public function update($id, ChannelUpdateRequest $request)
    {
        $updateChannel = $this->channelService->update($id, $request);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $updateChannel);
    }

    /**
     * @param array $listChannel
     * @return mixed
     * @throws \OmSdk\Exceptions\PalValidationException
     */
    public function destroyMutil(Request $request)
    {
        $listChannelId = $request->input('ids');

        $destroyChannel = $this->channelService->destroyMultil($listChannelId);

        return $this->_responseSuccess( PalServiceErrorCode::NO_ERROR, $destroyChannel);
    }

    /**
     * Xóa 1 channel
     *
     *
     * @param $channelId
     * @return mixed
     * @throws \OmSdk\Exceptions\PalValidationException
     */
    public function destroy($channelId)
    {
        $destroyChannel = $this->channelService->destroy($channelId);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $destroyChannel);
    }

    /**
     * @return void
     */
    public function getAll()
    {
        $listChannel = $this->channelService->getAll();

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR,
            [
                'items' => ChannelResource::collection($listChannel)
            ]
        );
    }

    /**
     * Lấy danh sách tài khoản marketing
     * @return void
     */
    public function userPermissionMarketing()
    {
        $listUser = $this->channelService->getListUserPermissionMarketing();

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR,
            [
                'items' => $listUser
            ]
        );
    }
}
