<?php

namespace App\Modules\Lead\Jobs;

use AccountSdkDb\Modules\Store\Models\Store;
use AccountSdkDb\Modules\Store\Repositories\Contracts\StoreInterface;
use AccountSdkDb\Modules\System\Repositories\Contracts\SystemSettingInterface;
use App\Jobs\BaseJob;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use OmSdk\Modules\Lead\Repositories\Contracts\ILeadRepository;

class LeadsAssignBySettingJob extends BaseJob
{
    /**
     * @var StoreInterface $storeRepository
     */
    protected $storeRepository;

    /**
     * @var ILeadRepository $leadRepository
     */
    protected $leadRepository;

    /**
     * @var SystemSettingInterface $systemSettingRepository
     */
    protected $systemSettingRepository;

    /**
     * @var Carbon $timeNow
     */
    protected $timeNow;

    /**
     * LeadsAssignBySettingJob constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);

        $this->leadRepository = App::make(ILeadRepository::class);

        if (! empty($data['timeNow'])) {
            $this->timeNow = Carbon::parse((string) $data['timeNow']);
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    protected function _handle()
    {
        /** @var Collection $stores */
        $stores = $this->getStoreRepository()->getAll();

        if ($stores->isEmpty()) {
            return;
        }

        /** @var Store $store */
        foreach ($stores as $store) {
            # Assign for sale groups
            $this->assignForSaleGroup($store->id);

            # Assign for users;
            $this->assignForUser($store->id);
        }
    }

    /**
     * @param int $storeId
     * @return void
     */
    protected function assignForSaleGroup(int $storeId)
    {
        $conditions['setting_group_cd'] = 'OM';
        $conditions['setting_cd'] = 'SALE_GROUP_ASSIGN_SETTING_SHOP_' . $storeId;
        $systemSetting = $this->getSystemSettingRepository()->getOne($conditions);

        if (empty($systemSetting) || empty($systemSetting->setting_val)) {
            return;
        }

        $settingVal = array_filter((array) @json_decode($systemSetting->setting_val, true));

        if (empty($settingVal['assign_by_robin_round'])) {
            return;
        }

        $roundRobin = (array) $settingVal['assign_by_robin_round'];

        foreach($roundRobin as $settingRobin) {
            $timeConfig = (array) ($settingRobin['time'] ?? null);
            $saleGroupIds = (array) ($settingRobin['sale_group'] ?? null);

            if (empty($time) || empty($saleGroups)) {
                return;
            }

            foreach ($timeConfig as $time) {
                $time = explode(',', $time);

                if (count($time < 2)) {
                    continue;
                }

                [$hour, $minute] = $time;

                if ($hour == $this->timeNow->hour && $this->timeNow->minute == $minute) {
                    LeadsAssignSaleGroupJob::dispatchNow([
                        'store_id' => $storeId,
                        'saleGroupIds' => $saleGroupIds,
                        'assignAll' => true
                    ]);
                }
            }
        }
    }

    /**
     * @param int $storeId
     * @return void
     */
    protected function assignForUser(int $storeId)
    {
        $conditions['setting_group_cd'] = 'OM';
        $conditions['setting_cd'] = 'USER_ASSIGN_SETTING_SHOP_' . $storeId;
        $systemSetting = $this->getSystemSettingRepository()->getOne($conditions);

        if (empty($systemSetting) || empty($systemSetting->setting_val)) {
            return;
        }

        $settingVal = array_filter((array) @json_decode($systemSetting->setting_val, true));

        if (empty($settingVal['assign_by_robin_round'])) {
            return;
        }

        $roundRobin = (array) $settingVal['assign_by_robin_round'];

        foreach($roundRobin as $settingRobin) {
            $timeConfig = (array) ($settingRobin['time'] ?? null);
            $userIds = (array) ($settingRobin['users'] ?? null);

            if (empty($time) || empty($saleGroups)) {
                return;
            }

            foreach ($timeConfig as $time) {
                $time = explode(',', $time);

                if (count($time < 2)) {
                    continue;
                }

                [$hour, $minute] = $time;

                if ($hour == $this->timeNow->hour && $this->timeNow->minute == $minute) {
                    LeadsAssignUserJob::dispatchNow([
                        'store_id' => $storeId,
                        'userIds' => $userIds,
                        'assignAll' => true
                    ]);
                }
            }
        }
    }

    /**
     * @return mixed|ILeadRepository
     */
    protected function getLeadRepository()
    {
        if (! $this->leadRepository) {
            $this->leadRepository = App::make(ILeadRepository::class);
        }

        return $this->leadRepository;
    }

    /**
     * @return StoreInterface|mixed
     */
    protected function getStoreRepository()
    {
        if (! $this->storeRepository) {
            $this->storeRepository = App::make(StoreInterface::class);
        }

        return $this->storeRepository;
    }

    /**
     * @return SystemSettingInterface|mixed
     */
    protected function getSystemSettingRepository()
    {
        if (! $this->systemSettingRepository) {
            $this->systemSettingRepository = App::make(SystemSettingInterface::class);
        }

        return $this->systemSettingRepository;
    }
}
