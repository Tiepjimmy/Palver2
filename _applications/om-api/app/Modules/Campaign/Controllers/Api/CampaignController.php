<?php

namespace App\Modules\Campaign\Controllers\Api;

use App\Http\PalServiceErrorCode;
use App\Modules\Campaign\Requests\CampaignStoreRequest;
use App\Modules\Campaign\Requests\CampaignUpdateRequest;
use App\Modules\Campaign\Resources\CampaignResource;
use App\Modules\Campaign\Services\CampaignService;
use Common\Http\Controllers\Api\AbstractApiController;
use Illuminate\Http\Request;

class CampaignController extends AbstractApiController
{
    protected $campaignService;

    /**
     * @param CampaignService $campaignService
     */
    public function __construct(CampaignService $campaignService)
    {
        parent::__construct();

        $this->campaignService = $campaignService;
    }

    /**Lấy danh sách tài khoản tiền marketing
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $offset = $request->filled('offset')
                && is_numeric($request->input('offset')) ? (int)$request->input('offset') : 0;

        $limit = (int)$request->limit;

        $limit = $limit > 100 ? 100 : $limit;

        [$items, $total] = $this->campaignService->list($request, $limit, $offset);

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR ,
            [
                'items' => CampaignResource::collection($items),
                'total' => $total,
                'limit' => $limit,
                'offset' => $offset
            ]) ;
    }

    /**
     * Api tạo tài khoản tiền marketing
     *
     * @param CampaignStoreRequest $request
     * @return void
     */
    public function store(CampaignStoreRequest $request)
    {
        $campaignStore = $this->campaignService->store($request);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $campaignStore) ;
    }

    /**Api update payment account
     *
     * @param CampaignUpdateRequest $request
     * @param $campaignId
     * @return void
     */
    public function update(CampaignUpdateRequest $request, $campaignId)
    {
        $campaignUpdate = $this->campaignService->update($request, $campaignId);

        return $this->_responseSuccess( PalServiceErrorCode::NO_ERROR, $campaignUpdate);
    }

    /***
     * Api xóa tk tiền marketing
     *
     * @param $paymentId
     * @return void
     */
    public function destroy($paymentId)
    {
        $destroyCampaign = $this->campaignService->destroy($paymentId);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $destroyCampaign);
    }

    /**
     * Lấy danh sách loại sản phẩm
     * @return mixed
     */
    public function listBundle()
    {
        $listData = $this->campaignService->getListBundle();

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $listData);
    }


}