<?php

namespace App\Modules\Config\Controllers\Api;

use App\Http\PalServiceErrorCode;
use App\Modules\Campaign\Services\CampaignService;
use App\Modules\Channel\Services\ChannelServices;
use App\Modules\Lead\Services\LeadServices;
use App\Modules\MissionResult\Services\MissionResultService;
use App\Modules\MissionTask\Services\MissionTaskServices;
use App\Modules\Order\Services\StatusesServices;
use App\Modules\Payment\Services\PaymentService;
use App\Modules\SubChannel\Services\SubChannelServices;
use Common\Http\Controllers\Api\AbstractApiController;
use Exception;
use Illuminate\Support\Str;

class ConfigController extends AbstractApiController
{
    protected $channelService;
    protected $subChannelService;
    protected $paymentService;
    protected $campaignService;
    protected $leadService;
    protected $missionResultService;
    protected $missionTaskService;
    protected $orderStatusService;

    public function __construct(
        ChannelServices $channelService,
        SubChannelServices $subChannelService,
        PaymentService $paymentService,
        CampaignService $campaignService,
        LeadServices $leadService,
        MissionResultService $missionResultService,
        MissionTaskServices $missionTaskService,
        StatusesServices $orderStatusService
    )
    {
        parent::__construct();

        $this->channelService = $channelService;
        $this->subChannelService = $subChannelService;
        $this->paymentService = $paymentService;
        $this->campaignService = $campaignService;
        $this->leadService = $leadService;
        $this->missionResultService = $missionResultService;
        $this->missionTaskService = $missionTaskService;
        $this->orderStatusService = $orderStatusService;
    }

    /**
     * @param string $module
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(string $module)
    {
        try {
            $configs = [];

            if (method_exists($this, $method = Str::camel($module) . 'Config')) {
                $ret = (array)$this->$method();

                foreach ($ret as $key => $value) {
                    $configs[Str::camel(strtolower($key))] = $value;
                }
            }

            return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $configs);
        } catch (Exception $exception) {
            return $this->_responseError(PalServiceErrorCode::LOI_HE_THONG, [], 500);
        }

    }

    /**
     * @return array
     */
    protected function marketingConfig(): array
    {
        $config = [];
        $channels = $this->channelService->getAll();
        $subChannels = $this->subChannelService->getAll();
        $paymentAccounts = $this->paymentService->getAll();
        $listUser = $this->channelService->getListUserPermissionMarketing();
        $productCatalog = $this->campaignService->getListBundle();
        $leadStatuses = $this->leadService->getListStatus();

        $config['channels'] = $channels;
        $config['sub_channels'] = $subChannels;
        $config['payment_accounts'] = $paymentAccounts;
        $config['list_user'] = $listUser;
        $config['product_catalog'] = $productCatalog;
        $config['lead_statuses'] = $leadStatuses;

        return $config;
    }

    /**
     * @return array
     */
    protected function missionConfig(): array
    {
        $missionTasks = $this->missionTaskService->getAll();
        $missionResults = $this->missionResultService->getAllResult([]);
        $leadStatuses = $this->leadService->getListStatus();

        $config['lead_statuses'] = $leadStatuses;
        $config['mission_tasks'] = $missionTasks;
        $config['mission_results'] = $missionResults;

        return $config;
    }

    /**
     * @return array
     */
    protected function orderConfig(): array
    {
        $statuses = $this->orderStatusService->getAll();
        $listUser = $this->channelService->getListUserPermissionMarketing();

        $config['list_user'] = $listUser;
        $config['statuses'] = $statuses;

        return $config;
    }

}
