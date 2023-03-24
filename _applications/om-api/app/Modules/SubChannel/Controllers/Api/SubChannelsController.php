<?php

namespace App\Modules\SubChannel\Controllers\Api;

use App\Http\PalServiceErrorCode;
use App\Modules\SubChannel\Requests\SubChannelStoreRequest;
use App\Modules\SubChannel\Requests\SubChannelUpdateRequest;
use App\Modules\SubChannel\Resources\SubChannelResources;
use App\Modules\SubChannel\Services\SubChannelServices;
use Common\Http\Controllers\Api\AbstractApiController;
use Illuminate\Http\Request;
use OmSdk\Modules\SubChannel\Models\SubChannel;

class SubChannelsController extends AbstractApiController
{
    protected $subChannelService;

    /**
     * @param SubChannelServices $subChannelService
     */
    public function __construct(SubChannelServices $subChannelService)
    {
        parent::__construct();

        $this->subChannelService = $subChannelService;
    }

    /**
     * Lấy danh sách subChannel
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $limit = $request->filled('limit') &&
            is_numeric($request->input('limit')) ? (int)$request->input('limit') : 10;
        $offset = $request->filled('offset') &&
            is_numeric($request->input('offset')) ? (int)$request->input('offset') : 0;

        [$items, $total] = $this->subChannelService->list( $request, $limit, $offset);

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR,
            [
                'items' => SubChannelResources::collection($items),
                'total' => $total,
                'limit' => $limit,
                'offset' => $offset
            ]);
    }

    /**
     * @param SubChannelStoreRequest $request
     * @return void
     */
    public function store(SubChannelStoreRequest $request)
    {
        $storeSubChannel = $this->subChannelService->store($request->all());

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $storeSubChannel);

    }

    /**
     * Update SubChannel
     *
     * @param SubChannelUpdateRequest $request
     * @param $subChannelId
     * @return mixed
     */
    public function update( SubChannelUpdateRequest $request ,$subChannelId)
    {
        $updateSubChannel = $this->subChannelService->update($subChannelId, $request);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $updateSubChannel);

    }
    /**
     * @param array $listChannel
     * @return mixed
     * @throws \OmSdk\Exceptions\PalValidationException
     */
    public function destroyMutil(Request $request)
    {
        $listChannelId = $request->input('ids');

        $destroyChannel = $this->subChannelService->destroyMultil($listChannelId);

        return $this->_responseSuccess( PalServiceErrorCode::NO_ERROR, $destroyChannel);
    }

    /**
     * Xóa 1 phần tử sub Kênh
     *
     * @param $subChannelId
     * @return mixed
     * @throws \OmSdk\Exceptions\PalValidationException
     */
    public function destroy($subChannelId)
    {
        $destroyChannel = $this->subChannelService->destroy($subChannelId);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $destroyChannel);
    }

    /**
     * Lấy list all sub-channel
     *
     * @param Request $request
     * @return mixed
     */
    public function allSubChannels()
    {
        $listSubChannel = $this->subChannelService->getAll();

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR,
            [
                'items' => SubChannelResources::collection($listSubChannel)
            ]
        );
    }

    /**
     * Check unique code sub-Channel
     *
     * @param Request $request
     * @return mixed
     */
    public function checkUnique(Request $request)
    {
        $checkCode = $this->subChannelService->checkExist($request->toArray());

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $checkCode);
    }
}
