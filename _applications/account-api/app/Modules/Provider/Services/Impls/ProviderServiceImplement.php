<?php

namespace App\Modules\Provider\Services\Impls;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use App\Modules\Provider\Events\ProviderInsertEvent;
use App\Modules\Provider\Events\ProviderGroupInsertEvent;
use App\Modules\Provider\Events\ProviderUpdateEvent;
use App\Modules\Provider\Rules\ProviderCodeRule;
use Common\Exceptions\PalException;
use Common\Exceptions\PalValidationException;
use App\Modules\Provider\Services\IProviderService;
use AccountSdkDb\Modules\Store\Services\IAssignmentStoreService;
use App\Modules\Provider\Repositories\Contracts\ProviderProviderGroupInterface;
use App\Modules\Provider\Repositories\Contracts\ProviderInterface;
use App\Modules\Provider\Repositories\Contracts\StoreProviderInterface;
use App\Modules\Provider\Repositories\Contracts\ProviderGroupInterface;

/**
 * @inheritDoc
 */
class ProviderServiceImplement implements IProviderService
{
    protected $providerProviderGroupRepository;
    protected $providerRepository;
    protected $storeProviderRepository;
    protected $assignmentStoreService;
    protected $providerGroupRepository;

    public function __construct(
                                ProviderProviderGroupInterface $providerProviderGroupRepository,
                                ProviderInterface $providerRepository,
                                StoreProviderInterface $storeProviderRepository,
                                IAssignmentStoreService $assignmentStoreService,
                                ProviderGroupInterface $providerGroupRepository
    )
    {
        $this->providerProviderGroupRepository = $providerProviderGroupRepository;
        $this->providerRepository = $providerRepository;
        $this->storeProviderRepository = $storeProviderRepository;
        $this->assignmentStoreService = $assignmentStoreService;
        $this->providerGroupRepository = $providerGroupRepository;
    }

    /**
     * @inheritDoc
     */
    public function search($keyword, $limit, $offset) {
        $listStore = $this->assignmentStoreService->getAssignedStore();
        $listStoreId = $listStore->map(function ($store) {
            return $store['id'];
        });
        $listStoreProvider = $this->storeProviderRepository->getMore(
            array(
                'list_store_id' => $listStoreId
            ),
            array(),
            false
        );
        $listProviderId = $listStoreProvider->map(function ($storeProvider) {
            return $storeProvider['provider_id'];
        });
        $listProvider = $this->providerRepository->getMore(
            array(
                'list_provider_id' => $listProviderId,
                'keyword' => $keyword
            ),
            array(
                'with' => array(
                    'stores',
                    'providerGroups'
                )
            ),
            false
        );
        return array(
            'total' => count($listProvider),
            'items' => $listProvider->splice($offset, $limit),
            'limit' => $limit,
            'offset' => $offset,
        );
    }

    /**
     * @inheritDoc
     */
    public function show($providerId) {
        $validators = Validator::make(array(
            'provider_id' => $providerId
        ), array(
            'provider_id' => "required|exists:acc_t_providers,id",
        ));
        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',422);
        }

        $provider = null;
        $provider = $this->providerRepository->getById($providerId, array(), array(
            'with' => array(
                'stores',
                'providerGroups'
            )
        ));
        if (is_null($provider)) {
            throw new PalException('E000001');
        }

        return $provider;
    }

    /**
     * @inheritDoc
     */
    public function getCreateInfos() {
        $listStore = $this->assignmentStoreService->getAssignedStore();
        $listStoreId = $listStore->map(function ($store) {
            return $store['id'];
        });
        $listProviderGroup = $this->providerGroupRepository->getMore(
            array(
                'list_store_id' => $listStoreId
            ),
            array(),
            false
        );
        return array(
            'list_store' => $listStore,
            'list_provider_group' => $listProviderGroup
        );
    }

    /**
     * @inheritDoc
     */
    public function store($payload) {
        $validators = Validator::make($payload, array(
            'store_id' => 'required',
            'store_id.*' => 'required|exists:acc_t_stores,id',
            'provider_group_id' => 'required',
            'provider_group_id.*' => 'required|exists:acc_t_provider_groups,id',
            'province_id' => 'required|exists:acc_m_provinces,id',
            'district_id' => 'required|exists:acc_m_districts,id',
            'ward_id' => 'required|exists:acc_m_wards,id',
            'provider_cd' => [
                'nullable',
                'max:255',
                'unique:acc_t_providers,provider_cd',
                new ProviderCodeRule()
            ],
            'provider_name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns',
            'phone' => 'required|is_phone_number',
            'tax_cd' => 'nullable',
            'description' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'active_status' => 'required|in:active,inactive'
        ));
        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',422);
        }

        if (is_null($payload['provider_cd'])) {
            $payload['provider_cd'] = 'NCC' . sprintf("%'03d", rand(001, 999));
        }

        $storedProvider = null;
        DB::beginTransaction();
        $storedProvider = $this->providerRepository->create(array(
            'province_id' => $payload['province_id'],
            'district_id' => $payload['district_id'],
            'ward_id' => $payload['ward_id'],
            'provider_cd' => $payload['provider_cd'],
            'provider_name' => $payload['provider_name'],
            'email' => $payload['email'],
            'phone' => $payload['phone'],
            'tax_cd' => $payload['tax_cd'] ?? '',
            'description' => $payload['description'] ?? '',
            'address' => $payload['address'],
            'active_status' => $payload['active_status']
        ));

        $listStoreId = $payload['store_id'];
        $listProviderGroupId = $payload['provider_group_id'];

        foreach ($listStoreId as $storeId) {
            $this->storeProviderRepository->create(array(
                'store_id' => $storeId,
                'provider_id' => $storedProvider->id
            ));
        }

        foreach ($listProviderGroupId as $providerGroupId) {
            $this->providerProviderGroupRepository->create(array(
                'provider_group_id' => $providerGroupId,
                'provider_id' => $storedProvider->id
            ));
        }

        if (!is_null($storedProvider)) {
            DB::commit();
            Event::dispatch(new ProviderInsertEvent($storedProvider));
        } else {
            DB::rollBack();
            throw new PalException('E000001');
        }

        return $storedProvider;
    }

    /**
     * @inheritDoc
     */
    public function update($id, $payload) {
        $validators = Validator::make(
            array_merge($payload, ['id' => $id]),
            array(
                'id' => 'required|exists:acc_t_providers,id',
                'store_id' => 'required',
                'store_id.*' => 'required|exists:acc_t_stores,id',
                'provider_group_id' => 'required',
                'provider_group_id.*' => 'required|exists:acc_t_provider_groups,id',
                'province_id' => 'required|exists:acc_m_provinces,id',
                'district_id' => 'required|exists:acc_m_districts,id',
                'ward_id' => 'required|exists:acc_m_wards,id',
                'provider_cd' => [
                    'nullable',
                    'max:255',
                    "unique:acc_t_providers,provider_cd,{$id}",
                    new ProviderCodeRule()
                ],
                'provider_name' => 'required|string|max:255',
                'email' => 'required|email:rfc,dns',
                'phone' => 'required|is_phone_number',
                'tax_cd' => 'nullable',
                'description' => 'nullable|string|max:255',
                'address' => 'required|string|max:255',
                'active_status' => 'required|in:active,inactive'
            ));
        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',422);
        }

        if (is_null($payload['provider_cd'])) {
            $payload['provider_cd'] = 'NCC' . sprintf("%'03d", rand(001, 999));
        }

        $updatedProvider = null;
        DB::beginTransaction();
        $updatedProvider = $this->providerRepository->updateById($id, array(
            'province_id' => $payload['province_id'],
            'district_id' => $payload['district_id'],
            'ward_id' => $payload['ward_id'],
            'provider_cd' => $payload['provider_cd'],
            'provider_name' => $payload['provider_name'],
            'email' => $payload['email'],
            'phone' => $payload['phone'],
            'tax_cd' => $payload['tax_cd'] ?? '',
            'description' => $payload['description'] ?? '',
            'address' => $payload['address'],
            'active_status' => $payload['active_status']
        ));

        $this->storeProviderRepository->delByCond(array(
            'provider_id' => $updatedProvider->id
        ));
        $this->providerProviderGroupRepository->delByCond(array(
            'provider_id' => $updatedProvider->id
        ));

        $listStoreId = $payload['store_id'];
        $listProviderGroupId = $payload['provider_group_id'];

        foreach ($listStoreId as $storeId) {
            $this->storeProviderRepository->create(array(
                'store_id' => $storeId,
                'provider_id' => $updatedProvider->id
            ));
        }

        foreach ($listProviderGroupId as $providerGroupId) {
            $this->providerProviderGroupRepository->create(array(
                'provider_group_id' => $providerGroupId,
                'provider_id' => $updatedProvider->id
            ));
        }

        if (!is_null($updatedProvider)) {
            DB::commit();
            Event::dispatch(new ProviderUpdateEvent($updatedProvider));
        } else {
            DB::rollBack();
            throw new PalException('E000001');
        }

        return $updatedProvider;
    }

    /**
     * @inheritDoc
     */
    public function updateStatus($id, $payload) {
        $validators = Validator::make($payload, array(
            'active_status' => 'required|in:active,inactive'
        ));
        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',422);
        }
        $updatedProviderStatus = null;
        $updatedProviderStatus = $this->providerRepository->updateById($id, array(
            'active_status' => $payload['active_status']
        ));

        if (!is_null($updatedProviderStatus)) {
            Event::dispatch(new ProviderUpdateEvent($updatedProviderStatus));
        } else {
            throw new PalException('E000001');
        }

        return $updatedProviderStatus;
    }

    /**
     * @inheritDoc
     */
    public function storeProviderGroup($payload) {
        $validators = Validator::make($payload, array(
            'store_id' => 'required|exists:acc_t_stores,id',
            'group_name' => 'required|string|max:255',
            'group_cd' => 'required|string|max:20',
            'note' => 'nullable|string|max:255',
        ));
        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',422);
        }

        $storedProviderGroup = null;
        $storedProviderGroup = $this->providerGroupRepository->create(array(
            'store_id' => $payload['store_id'],
            'group_name' => $payload['group_name'],
            'group_cd' => $payload['group_cd'],
            'note' => $payload['note'] ?? '',
        ));

        if (!is_null($storedProviderGroup)) {
            DB::commit();
            Event::dispatch(new ProviderGroupInsertEvent($storedProviderGroup));
        } else {
            DB::rollBack();
            throw new PalException('E000001');
        }

        return $storedProviderGroup;
    }

}
