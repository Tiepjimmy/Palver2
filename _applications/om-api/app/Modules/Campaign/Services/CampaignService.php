<?php

namespace App\Modules\Campaign\Services;

use AccountSdkDb\Modules\Product\Services\IProductCatalogService;
use App\Http\PalServiceErrorCode;
use App\Modules\Campaign\Requests\CampaignStoreRequest;
use App\Modules\Campaign\Requests\CampaignUpdateRequest;
use Carbon\Carbon;
use Common\Exceptions\PalException;
use Illuminate\Support\Facades\Validator;
use OmSdk\Exceptions\PalValidationException;
use OmSdk\Modules\Campaign\Models\Campaign;
use OmSdk\Modules\Campaign\Repositories\Contracts\ICampaignPaymentRepository;
use OmSdk\Modules\Campaign\Repositories\Contracts\ICampaignRepository;

class CampaignService
{
    protected $campaignRepository;
    protected $catalogInterface;
    protected $permissionRepository;
    protected $campaignPaymentRepository;

    public function __construct(
        ICampaignRepository $campaignRepository,
        IProductCatalogService $catalogInterface,
        ICampaignPaymentRepository $campaignPaymentRepository
    )
    {
        $this->campaignRepository = $campaignRepository ;
        $this->catalogInterface = $catalogInterface;
        $this->campaignPaymentRepository = $campaignPaymentRepository;
    }

    /**
     * Lấy danh sách tài khoản tiền marketing
     *
     * @param $request
     * @param $limit
     * @param $offset
     * @return array
     */
    public function list($request, $limit, $offset)
    {
        $channel_id = $request->filled('channel_id') ? $request->input('channel_id') : null;
        $sub_channel_id = $request->filled('sub_channel_id') ? $request->input('sub_channel_id') : null;
        $product_catalog_id = $request->filled('product_catalog_id') ? $request->input('product_catalog_id') : null;
        $title = $request->filled('title') ? $request->input('title') : null;

        $conditions = [
            'channel_id' => $channel_id,
            'sub_channel_id' => $sub_channel_id,
            'product_catalog_id' => $product_catalog_id,
            'title' => $title
        ];

        $totals = $this->campaignRepository->checkExist($conditions);

        $listPayment = $this->campaignRepository->getMore(
            $conditions,
            [
                'limit' => $limit,
                'offset' => $offset,
            ]
        );

        return [
            $listPayment,
            $totals
        ];
    }

    /**
     * Service create paymentAccount
     * @param CampaignStoreRequest $request
     * @return Campaign
     * @throws PalException
     */
    public function store($request)
    {
        /** @var Campaign $campaign */
        $campaign = new Campaign();

        $campaign->fill($request->all());
        $campaign->start_at = Carbon::parse($campaign->start_at)->format('Y-m-d H:i');
        $campaign->end_at = Carbon::parse($campaign->end_at)->format('Y-m-d H:i');

        $campaign = $this->campaignRepository->create($campaign->toArray());

        $campaign->code = sprintf('CD%03d', $campaign->id);
        $campaign->save();

        $campaign->paymentAccounts()->sync($request->payment_account_ids);

        if (is_null($campaign)) {
            throw new PalException(PalServiceErrorCode::LOI_HE_THONG);
        }

        return $campaign;
    }

    /**
     * @param CampaignUpdateRequest $request
     * @param $paymentId
     * @return mixed
     */
    public function update($request, $campaignId)
    {
        /** @var Campaign $campaign */
        $campaign = new Campaign();

        $campaign->fill($request->all());

        $campaign->start_at = Carbon::parse($campaign->start_at)->format('Y-m-d H:i');
        $campaign->end_at = Carbon::parse($campaign->end_at)->format('Y-m-d H:i');

        $campaign = $this->campaignRepository->updateById($campaignId, $campaign->toArray());

        $campaign->paymentAccounts()->sync($request->payment_account_ids);

        $campaign->save();

        if (is_null($campaign)) {
            throw new PalException(PalServiceErrorCode::LOI_HE_THONG);
        }

        return $campaign;
    }

    /**
     * @param $campaignId
     * @return mixed
     * @throws PalValidationException
     */
    public function destroy($campaignId)
    {
        $validators = Validator::make(array(
            'id' => $campaignId
        ), array(
            'id' => 'required|exists:om_marketing_campaigns,id',
        ));

        if ($validators->fails()) {
            throw new PalValidationException($validators);
        }

        return $this->campaignRepository->delByCond([
            'id' => $campaignId
        ]);
    }

    /**Lấy danh sách sản loại theo kho
     * ản phẩm theo
     * @param $request
     * @return array
     */
    public function getListBundle()
    {
        $storeId = 1;

        $listBundle = $this->catalogInterface->getBranchedProductCatalog($storeId);

        return $listBundle['items'];
    }
}