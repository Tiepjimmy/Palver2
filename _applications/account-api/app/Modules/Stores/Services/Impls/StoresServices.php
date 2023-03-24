<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\Stores\Services\Impls;



use AccountSdkDb\Modules\Store\Services\IAssignmentStoreService;
use App\Events\StoreInsertEvent;
use App\Events\StoreUpdateEvent;
use App\Modules\Stores\Repositories\Contracts\StoresInterface;
use App\Modules\Stores\Services\IStoresService;
use Common\Exceptions\PalException;
use Common\Exceptions\PalValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;

class StoresServices implements IStoresService
{
    /** @var StoresInterface */
    protected $storeRepository;

    public function __construct(StoresInterface $storeRepoInterface,IAssignmentStoreService $storeInterface)
    {
        $this->storeRepository = $storeRepoInterface;
        $this->storeService = $storeInterface;
    }
    /**
     * @inheritDoc
     */
    public function search($attributes)
    {
         $stores = $this->storeRepository->getAll();
        return $this->findOwner($stores->toArray());
        $stores = $this->storeRepository->getMore();
        return $stores->toArray();
    }

    /**
     * @inheritDoc
     */
    public function getStoreIsOwner()
    {
       
    }

    /**
     * @inheritDoc
     */
    private function findOwner($stores)
    {
        $owner = array_filter($stores, function ($el) {
            return is_null($el['parent_id']);
        });
        if (empty($owner)) {
            return false;
        }
        return $owner[0];
    }
    /**
     * @inheritDoc
     */
    public function create()
    {
        $response = [];
        $stores = $this->storeRepository->getMore(['active_status' => self::ACTIVE_STATUS]);
        $generalCompany = $this->storeService->getStoreIsOwner();
        $response['stores'] = $stores;
        $response['generalCompany'] = $generalCompany;
        return $response;
    }
    /**
     * @inheritDoc
     */
    public function store($attributes)
    {
        $attributes['active_status'] = self::ACTIVE_STATUS;
        $rules = $this->storeRepository->rules();
        unset($rules['store_cd']);
        $rules['store_cd'] = "required|unique:acc_t_stores,store_cd|string|between:3,20";
        
        $validator = Validator::make($attributes, $rules,['parent_id.required'=> 'Trường đơn vị trực thuộc bắt buộc nhập.']);
        if ($validator->fails()) {
            throw new PalValidationException($validator,'E000003','Lỗi validate',422);
        }
        $attributes['tree_path'] = $this->treepath($attributes['parent_id'],$treepath);
        $store = null;
        $store = $this->storeRepository->create($attributes);
        if(!is_null($store)){
            Event::dispatch(new StoreInsertEvent($store));
        }else{
            throw new PalException('E000001');
        }
        return $store;
    }
    /**
     * @inheritDoc
     */
    public function get($id)
    {
        $getStore = $this->storeRepository->getById($id);
        if (!empty($getStore)) {
            return $getStore;
        }
        throw new PalException('E010705','Không tìm thấy bản ghi',422);
    }
    /**
     * @inheritDoc
     */
    public function update($id,$attributes)
    {
        $update  = null;
        $store = null;
        $rules = $this->storeRepository->rules();
        unset($rules['store_cd']);
        $rules['store_cd'] = "required|unique:acc_t_stores,store_cd,".$id."|string|between:3,20";
        $store = $this->storeRepository->getById($id);
        if (!$store->parent_id) {
            unset($rules['parent_id']);
        }
        $validator = Validator::make($attributes, $rules,['parent_id.required'=> 'Trường đơn vị trực thuộc bắt buộc nhập.']);
        if ($validator->fails()) {
            throw new PalValidationException($validator,'E000003','Lỗi validate',422);
        }
        if ( isset($attributes['parent_id']) && $attributes['parent_id'] == $id) {
            throw new PalException(
                'E010701',
                'Đơn vị trực thuộc cha không thể là dơn vị trực thuộc hiện tại',
                422
            );
        }
        if ( isset($attributes['parent_id']) && !is_null($attributes['parent_id']) ) {
            $getParent = $this->storeRepository->getById($attributes['parent_id']);
            if ($getParent->active_status == self::INACTIVE_STATUS) {
                throw new PalException(
                    'E010702',
                    'Không chọn được đơn vị trực thuộc hiện tại. Đơn vị trực thuộc đang ngừng hoạt động',
                    422
                );
            }
        }
        $stores = $this->getChildrent($store->id);
        if (!empty($stores)) {
            foreach ($stores as $val) {
                if ( isset($attributes['parent_id']) && $attributes['parent_id'] == $val['id']) {
                    throw new PalException(
                        'E010703',
                        'Trực thuộc cha không thể nằm trong trực thuộc con',
                        422
                    );
                }
            }
        }
        if (isset($attributes['parent_id'])) {
            $attributes['tree_path'] = $this->treepath($attributes['parent_id'], $treepath);
        }
        $update = $this->storeRepository->updateById( $id,$attributes);
        if (!empty($update) && !empty($stores)) {
            if ($attributes['active_status'] == self::INACTIVE_STATUS) {
                foreach ($stores as $val) {
                    $this->storeRepository->updateById($val['id'],['active_status' => $attributes['active_status']]);
                }
            }
        }
        if(!is_null($update)){
            Event::dispatch(new StoreUpdateEvent($store,$update));
        }else{
            throw new PalException('E000001');
        }
        return $update;
    }

    /**
     * xử lý map hiện cha con tree_path
     * @param mixed $parent_id
     * return string
     */
    private function treepath($parent_id, &$treepath)
    {
        $param = [
            'id'=> $parent_id
        ];
        $stores = $this->storeRepository->getMore($param);
        if (!empty($stores)) {
            foreach ($stores as $key => $item) {
                // Xử lý hiển thị trực thuôc
                $treepath =  $item->id .'/'. $treepath;
                // unset trực thuôc đã lặp
                unset($stores[$key]);
                // Tiếp tục đệ quy để tìm id trực thuôc cha
                if (!is_null($item->parent_id)) {
                    $this->treepath($item->parent_id, $treepath);
                }
            }
        }
        return $treepath;
    }
    /**
     * xử lý lấy các parent_id con
     * @param mixed $parent_id
     */
    private function getChildrent($parent_id) {
        $result = [];
        $param = [
            'parent_id' => $parent_id
        ];
        $checkChildrents = $this->storeRepository->getMore($param);
        if (!empty($checkChildrents)) {
            foreach ($checkChildrents as $checkChildrent) {
                $result[] = $checkChildrent;
                $childrent = $this->getChildrent($checkChildrent['id']);
                $result = array_merge($result, $childrent);
            }
        }
        return $result;
    }
}
