<?php

namespace App\Modules\Lead\Services;

use AccountSdkDb\Modules\System\Models\SystemSetting;
use AccountSdkDb\Modules\System\Repositories\Contracts\SystemSettingInterface;
use App\Modules\Lead\Requests\LeadStoreRequest;
use App\Modules\Lead\Jobs\LeadsAssignSaleGroupJob;
use App\Modules\Lead\Jobs\LeadsAssignUserJob;
use App\Modules\Lead\Requests\LeadUpdateRequest;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use OmSdk\Modules\Customer\Repositories\Contracts\ICustomerMissionRepository;
use OmSdk\Modules\Customer\Repositories\Contracts\ICustomerRepository;
use OmSdk\Modules\Lead\Models\Lead;
use OmSdk\Modules\Lead\Repositories\Contracts\ILeadRepository;
use OmSdk\Modules\Lead\Repositories\Contracts\ILeadStatusRepository;
use OmSdk\Modules\Lead\Repositories\Eloquent\LeadStatusRepository;
use OmSdk\Modules\MissionResult\Repositories\Contracts\IMissionScriptRepository;
use OmSdk\Modules\MissionResult\Repositories\Contracts\IMissionTaskRepository;

class LeadServices
{
    protected $leadRepository;
    protected $customerRepository;
    protected $customerMissionRepository;
    protected $leadStatusRepository;
    protected $systemSettingRepository;
    protected $missionTaskRepository;
    protected $missionScriptRepository;

    /**
     * @param ILeadRepository $leadRepository
     * @param ICustomerMissionRepository $customerMissionRepository
     * @param ICustomerRepository $customerRepository
     * @param ILeadStatusRepository $leadStatusRepository
     * @param SystemSettingInterface $systemSettingRepository
     * @param IMissionTaskRepository $missionTaskRepository
     * @param IMissionScriptRepository $missionScriptRepository
     */
    public function __construct(
        ILeadRepository $leadRepository,
        ICustomerMissionRepository $customerMissionRepository,
        ICustomerRepository $customerRepository,
        ILeadStatusRepository $leadStatusRepository,
        SystemSettingInterface $systemSettingRepository,
        IMissionTaskRepository $missionTaskRepository,
        IMissionScriptRepository $missionScriptRepository
    )
    {
       $this->leadRepository = $leadRepository;
       $this->customerMissionRepository = $customerMissionRepository;
       $this->customerRepository = $customerRepository;
       $this->leadStatusRepository = $leadStatusRepository;
       $this->systemSettingRepository = $systemSettingRepository;
       $this->missionTaskRepository = $missionTaskRepository;
       $this->missionScriptRepository = $missionScriptRepository;
    }


    /**
     * @param $request
     * @param $limit
     * @param $offset
     * @return array
     */
    public function list($request, $limit, $offset)
    {
        $createdFrom = $request->filled('time_start') ? $request->time_start : null;
        $createdTo = $request->filled('time_end') ? $request->time_end : null;
        $channelId = $request->filled('channel_id') ? $request->channel_id : null;
        $subChannelId = $request->filled('sub_channel_id') ? $request->sub_channel_id : null;
        $userCreated = $request->filled('user_id') ? $request->user_id : null;
        $productCatalogId = $request->filled('product_catalog_id') ? $request->product_catalog_id : null;
        $mobile = $request->filled('mobile') ? $request->mobile : null;
        $status = $request->filled('status') ? $request->status : null;
        $statusIds = $request->filled('status_ids') ? $request->status_ids : [];
        $type = $request->filled('type') ? $request->type : null;
        $is_duplicated = $request->filled('is_duplicated') ? $request->is_duplicated : null;
        $assignedUserId = $request->filled('assigned_user_id') ? $request->assigned_user_id : null;

        $conditions = [
            'from' => $createdFrom,
            'to' => $createdTo,
            'channel_id' => $channelId,
            'sub_channel_id' => $subChannelId,
            'productCatalogId' => $productCatalogId,
            'userCreated' => $userCreated,
            'status' => $status,
            'status_ids' => $statusIds,
            'mobile' => $mobile,
            'type' => $type,
            'is_duplicated' => $is_duplicated,
            'assigned_user_id' => $assignedUserId,
            'sale_assigned' => $request->sale_assigned
        ];

        $total = $this->leadRepository->checkExist($conditions);

        $listData = $this->leadRepository->getMore(
            $conditions,
            array(
                'limit' => $limit,
                'offset' => $offset,
                'orderBy' => 'id'
            ));

        return [
            $listData,
            $total
        ];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->leadRepository->getById($id);
    }

    /**
     * @param LeadStoreRequest $request
     * @return mixed
     */
    public function store($request)
    {
        $lead = new Lead();

        $request->merge([
            'code' => Str::uuid()
        ]);

        Log::info($request->code);
        $data = $lead->fill($request->all());

        $store = $this->leadRepository->create($data->toArray());

        if ($store) {
            $this->leadRepository->updateById($store->id, [
                'code' => sprintf('KH%03d', $store->id),
            ]);
        }

        return $store;
    }

    /**
     * @param $id
     * @param LeadUpdateRequest $request
     * @return mixed
     */
    public function update($id, $request)
    {
        return $this->leadRepository->updateById($id, $request->toArray());
    }

    /**
     * @param $id
     * @param LeadUpdateRequest $request
     * @return mixed
     */
    public function updateBySale($id, $request)
    {
        /** @var Lead $lead */
        $lead = $this->leadRepository->getById($id);

        if (isset($request->result_id)) {
            $condition = [
                'store_id' => $lead->store_id,
                'task_id' => $lead->mission_id,
                'result_id' => $request->result_id,
            ];

            $script = $this->missionScriptRepository->getOne($condition);

            if ($script) {
                $request->merge([
                    'mission_id' => $script->next_task_id,
                    'mission_script_id' => $script->id
                ]);
            }
        }

        return $this->leadRepository->updateById($id, $request->toArray());
    }

    /**
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function destroy($id)
    {
        /** @var Lead $lead */
        $lead = $this->leadRepository->getById($id);

        $statuses = [env('DATA_LEAD_REJECT_STATUS'), env('DATA_LEAD_WAIT_STATUS')];

        if (in_array($lead->lead_status_id, $statuses) && ! $lead->assigned_group_id) {
            return $this->leadRepository->destroy($id);
        } else {
            throw new Exception('Data số không được xóa');
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function reject($id)
    {
        return $this->leadRepository->updateById($id, [
            'lead_status_id' => env('DATA_LEAD_REJECT_STATUS')
        ]);
    }

    /**
     * @param $id
     */
    public function accept($id)
    {
        $condition['is_default'] = 1;

        $mission = $this->missionTaskRepository->getOne($condition);

        if (! $mission) {
            throw new Exception('Không tìm thấy nhiệm vụ');
        }

        return $this->leadRepository->updateById($id, [
            'mission_id' => $mission->id
        ]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function cancel($id)
    {
        return $this->leadRepository->updateById($id, [
            'mission_id' => null,
            'mission_script_id' => null,
            'lead_status_id' => env('DATA_LEAD_WAIT_STATUS')
        ]);
    }

    /**
     * @param $string
     * @return false
     */
    public function checkDuplicate($string)
    {

        return false;
    }

    /**
     * @return array
     */
    public function getListStatus()
    {
        $condition = [
            'store_id' => 1,
            'is_active' => 1
        ];

        $fetchOptions['select'] = ['id', 'name', 'color'];
        $data = $this->leadStatusRepository->getMore($condition, $fetchOptions);

        return $data;
    }

    /**
     * @param array $saleGroupIds
     * @param array $leadIds
     * @return boolean
     */
    public function assignSaleGroup(array $saleGroupIds, array $leadIds)
    {
        $saleGroupIds = array_filter($saleGroupIds);
        $leadIds = array_filter($leadIds);

        if (empty($saleGroupIds) || empty($leadIds)) {
            return true;
        }

        LeadsAssignSaleGroupJob::dispatchNow([
            'store_id' => 1,
            'saleGroupIds' => $saleGroupIds,
            'leadIds' => $leadIds
        ]);

        return true;
    }

    /**
     * @param array $saleGroupIds
     * @return boolean
     */
    public function assignSaleGroupAll(array $saleGroupIds)
    {
        $saleGroupIds = array_filter($saleGroupIds);

        if (empty($saleGroupIds)) {
            return true;
        }

        Log::info(__METHOD__, $saleGroupIds);

        LeadsAssignSaleGroupJob::dispatchNow([
            'store_id' => 1,
            'saleGroupIds' => $saleGroupIds,
            'assignAll' => true
        ]);

        return true;
    }

    /**
     * @param array $userIds
     * @param array $leadIds
     * @return boolean
     */
    public function assignUser(array $userIds, array $leadIds)
    {
        Log::info(__METHOD__, $userIds);

        $userIds = array_filter($userIds);
        $leadIds = array_filter($leadIds);

        if (empty($userIds) || empty($leadIds)) {
            return true;
        }

        LeadsAssignUserJob::dispatchNow([
            'store_id' => 1,
            'userIds' => $userIds,
            'leadIds' => $leadIds
        ]);

        return true;
    }

    /**
     * @param array $userIds
     * @return boolean
     */
    public function assignUserAll(array $userIds)
    {
        $userIds = array_filter($userIds);

        if (empty($userIds)) {
            return true;
        }

        LeadsAssignUserJob::dispatchNow([
            'store_id' => 1,
            'userIds' => $userIds,
            'assignAll' => true
        ]);

        return true;
    }

    /**
     * Lưu thông tin cấu hình chia data số cho sale group
     *
     * @param array $settings
     * @return bool
     */
    public function saveSettingAssignSaleGroup(array $settings)
    {
        $storeId = 1;
        $conditions['setting_group_cd'] = 'OM';
        $conditions['setting_cd'] = 'SALE_GROUP_ASSIGN_SETTING_SHOP_' . $storeId;
        $systemSetting = $this->systemSettingRepository->getOne($conditions);

        if (empty($systemSetting)) {
            $systemSetting = new SystemSetting([
                'setting_group_cd' => 'OM',
                'setting_cd' => 'SALE_GROUP_ASSIGN_SETTING_SHOP_' . $storeId
            ]);
        }

        $systemSetting->setting_val = json_encode($settings);

        return $systemSetting->save();
    }

    /**
     * Lưu thông tin cấu hình chia data số cho sale
     *
     * @param array $settings
     * @return bool
     */
    public function saveSettingAssignUser(array $settings)
    {
        $storeId = 1;
        $conditions['setting_group_cd'] = 'OM';
        $conditions['setting_cd'] = 'USER_ASSIGN_SETTING_SHOP_' . $storeId;
        $systemSetting = $this->systemSettingRepository->getOne($conditions);

        if (empty($systemSetting)) {
            $systemSetting = new SystemSetting([
                'setting_group_cd' => 'OM',
                'setting_cd' => 'USER_ASSIGN_SETTING_SHOP_' . $storeId
            ]);
        }

        $systemSetting->setting_val = json_encode($settings);

        return $systemSetting->save();
    }

    public function getTotalLeadByStatus()
    {
        $condition['store_id'] = 1;
        $fetchOptionsStatus['select'] = ['id', 'color', 'name'];
        $fetchOptions['select'] = ['lead_status_id'];

        $leadStatus = (new LeadStatusRepository())->getMore($condition);

        $data = $this->leadRepository->getMore($condition, $fetchOptions);

        $result = [];

        foreach ($leadStatus as $value) {
            $result[$value->id]['total'] = $data->filter(function ($status) use ($value) {
                return $status['lead_status_id'] == $value->id;
            })->count();

            $result[$value->id]['value'] = $value->id;
            $result[$value->id]['color'] = $value->color;
            $result[$value->id]['name'] = $value->name;
        }

        return array_values($result);
    }
}
