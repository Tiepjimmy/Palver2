<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\ProductCatalogs\Services\Impls;



use App\Events\ProductCatalogInsertEvent;
use App\Events\ProductCatalogUpdateEvent;
use App\Modules\ProductCatalogs\Repositories\Contracts\ProductCatalogsInterface;
use App\Modules\ProductCatalogs\Repositories\Contracts\StoreProductCatalogInterface;
use App\Modules\ProductCatalogs\Services\IProductCatalogsService;
use Common\Exceptions\PalException;
use Common\Exceptions\PalValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;

class ProductCatalogsServices implements IProductCatalogsService
{
    /** @var ProductCatalogsInterface */
    protected $productCatalogRepository;
    protected $storeProductCatalogRepository;

    public function __construct(
        ProductCatalogsInterface $productCatalogRepoInterface,
        StoreProductCatalogInterface $storeProductCatalogRepoInterface)
    {
        $this->productCatalogRepository = $productCatalogRepoInterface;
        $this->storeProductCatalogRepository = $storeProductCatalogRepoInterface;
    }
    /**
     * @inheritDoc
     */
    public function search($attributes)
    {
        $keyword = [];
        $productCatalogs = $this->productCatalogRepository->getMore($keyword,['with' => ['Stores']]);
        return $productCatalogs->toArray();
    }

    /**
     * @inheritDoc
     */
    public function create()
    {
        $response = [];
        $keyword = [];
        $keyword['active_status'] = self::ACTIVE_STATUS;
        $productCatalogs = $this->productCatalogRepository->getMore($keyword,['with' => ['Stores']]);
        $response['productCatalogs'] = $productCatalogs;
        $response['productCatalogsItems'] = $productCatalogs[0];
        return $response;
    }

    /**
     * @inheritDoc
     */
    public function store($attributes)
    {
        $attributes['active_status'] = self::ACTIVE_STATUS;
        $rules = $this->productCatalogRepository->rules();
        unset($rules['product_cd_prefix']);
        $rules['product_cd_prefix'] = "required|unique:acc_t_product_catalogs,product_cd_prefix|string|between:3,20";
        $validator = Validator::make($attributes,$rules);
        if ($validator->fails()) {
            throw new PalValidationException($validator,'E000003','Lỗi validate',422);
        }
        if (empty($attributes['parent_id'])) {
            $attributes['parent_id'] = null;
        }
        $productCatalog = null;
        $productCatalog = $this->productCatalogRepository->create($attributes);
        $data = [];
        if (!empty($productCatalog)) {
            foreach ($attributes['store_id'] as $val) {
                $data['product_catalog_id'] = (int)$productCatalog->id;
                $data['store_id'] = (int)$val;
                $this->storeProductCatalogRepository->create($data);
            }
        }
        if(!is_null($productCatalog)){
            Event::dispatch(new ProductCatalogInsertEvent($productCatalog));
        }else{
            throw new PalException('E000001');
        }
        return $productCatalog;
    }

    /**
     * @inheritDoc
     */
    public function get($id)
    {
        $param = [
            'id'=>$id
        ];
        $productCatalogs = $this->productCatalogRepository->getMore($param,['with' => ['Stores']]);
        if (!empty($productCatalogs)) {
            return $productCatalogs->toArray()[0];
        }
        throw new PalException('E010904','Không tìm thấy bản ghi',422);
    }

    /**
     * @inheritDoc
     */
    public function update($id,$attributes)
    {

        $update  = null;
        $productCatalog = null;
        $rules = $this->productCatalogRepository->rules();
        unset($rules['product_cd_prefix']);
        $rules['product_cd_prefix'] = "required|unique:acc_t_product_catalogs,product_cd_prefix,".$id."|string|between:3,20";
        $productCatalog = $this->productCatalogRepository->getById($id);
        $validator = Validator::make($attributes, $rules);
        if ($validator->fails()) {
            throw new PalValidationException($validator,'E000003','Lỗi validate',422);
        }
        if (empty($attributes['parent_id'])) {
            $attributes['parent_id'] = null;
        }
        if ( isset($attributes['parent_id']) && $attributes['parent_id'] == $id) {
            throw new PalException(
                'E010901',
                'Loại sản phẩm cha không thể là loại sản phẩm hiện tại',
                422
            );
        }
        if (!is_null($attributes['parent_id'])) {
            $getParent = $this->productCatalogRepository->getById($attributes['parent_id']);
            if ($getParent->active_status == self::INACTIVE_STATUS) {
                throw new PalException(
                    'E010902',
                    'Không chọn được loại sản phẩm cha hiện tại. Loại sản phẩm cha đang ngừng hoạt động',
                    422
                );
            }
        }
        $productCatalogs = $this->getChildrent($productCatalog->id);
        array_push($productCatalogs, $productCatalog->toArray());
        $checkOrder = null;
        foreach ($productCatalogs as $value) {
            $checkOrder = $this->checkOrder($value['id']);
            if (isset($attributes['parent_id']) && $attributes['parent_id']  == $value['id']) {
                throw new PalException(
                    'E010903',
                    'Loại sản phẩm cha không thể nằm trong loại sản phẩm con',
                    422
                );
            }
        }
        if (!is_null($checkOrder)) {
            throw new PalException(
                'E010900',
                'Loại sản phẩm đang chứa sản phẩm nằm trong đơn hàng chưa hoàn thành',
                422
            );
        }
        $update = $this->productCatalogRepository->updateById( $id,$attributes);
        if (!empty($update)) {
            $data = [];
            $param = [
                'product_catalog_id' => (int)$update->id
            ];
            $this->storeProductCatalogRepository->delByCond($param);
            foreach ($attributes['store_id'] as $val) {
                $data['product_catalog_id'] = (int)$update->id;
                $data['store_id'] = (int)$val;
                $this->storeProductCatalogRepository->create($data);
            }
            if ($attributes['active_status'] == self::INACTIVE_STATUS) {
                foreach ($productCatalogs as $val) {
                    $this->productCatalogRepository->updateById($val['id'],['active_status' => $attributes['active_status']]);
                }
            }

        }
        if(!is_null($update) && !is_null($productCatalog)){
            Event::dispatch(new ProductCatalogUpdateEvent($productCatalog,$update));
        }else{
            throw new PalException('E000001');
        }
        return $update;
    }

    /**
     * get product catalog parent_id
     * @param mixed $id
     */
    private function getChildrent($id) {
        $result = [];
        $param = [
            'parent_id' => $id
        ];
        $checkChildrents = $this->productCatalogRepository->getMore($param);
        if (!empty($checkChildrents)) {
            foreach ($checkChildrents as $checkChildrent) {
                $result[] = $checkChildrent;
                $childrent = $this->getChildrent($checkChildrent['id']);
                $result = array_merge($result, $childrent);
            }
        }
        return $result;
    }

    /**
     * check checkOrder product catalog
     * @param mixed $idproductcatalog
     */
    private function checkOrder($idproductcatalog) {
        return null;
    }
}
