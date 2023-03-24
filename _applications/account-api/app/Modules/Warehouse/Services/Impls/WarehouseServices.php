<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\Warehouse\Services\Impls;



use AccountSdkDb\Modules\Store\Services\IAssignmentStoreService;
use App\Events\WareHousesInsertEvent;
use App\Events\WareHousesUpdateEvent;
use App\Modules\Warehouse\Repositories\Contracts\WarehouseInterface;
use App\Modules\Warehouse\Repositories\Contracts\WarehouseStoreInterface;
use App\Modules\Warehouse\Repositories\Contracts\WarehouseTypeInterface;
use App\Modules\Warehouse\Services\IWarehouseService;
use Common\Exceptions\PalException;
use Common\Exceptions\PalValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;

class WarehouseServices implements IWarehouseService
{
    /** @var WarehouseInterface */
    protected $warehouseRepository;
    protected $warehousesTypeRepository;
    protected $warehousesStoreRepository;
    protected $storeService;

    public function __construct(
        WarehouseInterface $wareHousesRepoInterface,
        WarehouseTypeInterface $wareHousesTypeRepoInterface,
        WarehouseStoreInterface $wareHousesStoreRepoInterface,
        IAssignmentStoreService $storeInterface)
    {
        $this->warehouseRepository = $wareHousesRepoInterface;
        $this->warehousesTypeRepository = $wareHousesTypeRepoInterface;
        $this->warehousesStoreRepository = $wareHousesStoreRepoInterface;
        $this->storeService = $storeInterface;
    }

    /**
     * @inheritDoc
     */
    public function search($attributes = [])
    {
        $keyword = key_exists('keyword', $attributes) ? $attributes : [];
        $limit = key_exists('limit', $attributes) && is_numeric($attributes['limit']) ? $attributes['limit'] : 10;
        $offset = key_exists('offset', $attributes) && is_numeric($attributes['offset']) ? $attributes['offset'] : 0;
        $warehouse = $this->warehouseRepository->getMore($keyword,[
                'limit' => $limit,
                'offset' => $offset,
                'with' => [
                    'warehouseStores',
                    'warehouseType'
                ]
        ]);
        $totals = $this->warehouseRepository->checkExist($keyword);
        return [
            'items' => $warehouse,
            'total' => $totals,
            'limit' => $limit,
            'offset' => $offset,
        ];
    }

    /**
     * @inheritDoc
     */
    public function create()
    {
        $response = [];
        $warehousesType = $this->warehousesTypeRepository->getMore();
        $response['warehousesType'] = $warehousesType;
        return $response;
    }

    /**
     * @inheritDoc
     */
    public function store($attributes)
    {

        $attributes['active_status'] = self::ACTIVE_STATUS;
        $rules = $this->warehouseRepository->rules();
        unset($rules['warehouse_cd']);
        $rules['warehouse_cd'] = "required|unique:acc_t_warehouses,warehouse_cd|string|between:3,20";
        $validator = Validator::make($attributes, $rules);
        if ($validator->fails()) {
            throw new PalValidationException($validator,'E000003','Lỗi validate',422);
        }
        $warehouses = null;
        $warehouses = $this->warehouseRepository->create($attributes);
        $data = [];
     
        if (!empty($warehouses)) {
            if (!isset($attributes['store_id'])) {
                $owner = null;
                $owner = $this->storeService->getStoreIsOwner();
                if(is_null($owner)){
                    throw new PalException(
                        'E010704',
                        'Không thể xác định tổ chức của tài khoản hiện tại',
                        422
                    );
                }
                $data['warehouse_id'] = (int)$warehouses->id;
                $data['store_id'] = (int)$owner['id'];
                $this->warehousesStoreRepository->create($data);
            } else {
                foreach ($attributes['store_id'] as $val) {
                    $data['warehouse_id'] = (int)$warehouses->id;
                    $data['store_id'] = (int)$val;
                    $this->warehousesStoreRepository->create($data);
                }
            }
        }
        if(!is_null($warehouses)){
            Event::dispatch(new WareHousesInsertEvent($warehouses));
        }else{
            throw new PalException('E000001');
        }
        return $warehouses;
    }

    /**
     * @inheritDoc
     */
    public function get($id)
    {
        $param = [
            'id'=>$id
        ];
        $warehouse = $this->warehouseRepository->getMore($param,[
                'with' => [
                    'warehouseStores',
                    'warehouseType'
                ]
            ]);
        if (!empty($warehouse)) {
            return $warehouse->toArray()[0];
        }
        throw new PalException('E010501','Không tìm thấy bản ghi',422);
    }

    /**
     * @inheritDoc
     */
    public function update($id,$attributes)
    {
        $update  = null;
        $warehouses = null;
        $rules = $this->warehouseRepository->rules();
        $warehouses = $this->warehouseRepository->getById($id);
        unset($rules['warehouse_cd']);
        $rules['warehouse_cd'] =  "required|unique:acc_t_warehouses,warehouse_cd,".$id."|string|between:3,20";
        $validator = Validator::make($attributes, $rules);
        if ($validator->fails()) {
            throw new PalValidationException($validator,'E000003','Lỗi validate',422);
        }
        $update = $this->warehouseRepository->updateById( $id,$attributes);
        if (!empty($update)) {
            $data = [];
            $param = [
                'warehouse_id' => (int)$update->id
            ];
            $this->warehousesStoreRepository->delByCond($param);
            if (!isset($attributes['store_id'])) {
                $owner = null;
                $owner = $this->storeService->getStoreIsOwner();
                if(is_null($owner)){
                    throw new PalException(
                        'E010704',
                        'Không thể xác định tổ chức của tài khoản hiện tại',
                        422
                    );
                }
                $data['warehouse_id'] = (int)$update->id;
                $data['store_id'] = (int)$owner['id'];
                $this->warehousesStoreRepository->create($data);
            } else {
                foreach ($attributes['store_id'] as $val) {
                    $data['warehouse_id'] = (int)$update->id;
                    $data['store_id'] = (int)$val;
                    $this->warehousesStoreRepository->create($data);
                }
            }
        }
        if(!is_null($update) && !is_null($warehouses)){
            Event::dispatch(new WareHousesUpdateEvent($warehouses,$update));
        }else{
            throw new PalException('E000001');
        }
        return $update;
    }
}
