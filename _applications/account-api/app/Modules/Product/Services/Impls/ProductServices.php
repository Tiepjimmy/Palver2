<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\Product\Services\Impls;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

use App\Modules\Product\Repositories\Contracts\ProductCatalogInterface;
use App\Modules\Product\Repositories\Contracts\VolumeUnitInterface;
use App\Modules\Product\Repositories\Contracts\ProductInterface;
use App\Modules\Product\Repositories\Contracts\ProductGalleryInterface;
use App\Modules\Product\Repositories\Contracts\ProductProviderInterface;
use App\Modules\Product\Repositories\Contracts\ComboInterface;
use App\Modules\Product\Repositories\Contracts\StoreProductCatalogInterface;
use App\Modules\Product\Repositories\Contracts\ProductEntityInterface;
use App\Modules\Product\Repositories\Contracts\RetailProductEntityInterface;

use App\Modules\Product\Services\IProductEntityServices;
use AccountSdkDb\Modules\Provider\Services\IProviderService;
use AccountSdkDb\Modules\Store\Services\IAssignmentStoreService;
use App\Modules\Product\Services\IProductServices;
use App\Modules\Product\Jobs\ProductJob;
use App\Modules\Product\Jobs\RetailProductJob;

class ProductServices implements IProductServices
{
    protected $proCataRepository;
    protected $volRepository;
    protected $productRepository;
    protected $productGalleryRepository;
    protected $productEntityServices;
    protected $iProviderService;
    protected $productProviderInterface;
    protected $comboRepository;
    protected $iAssignmentStoreService;
    protected $storeProductCatalogRepository;
    protected $productEntityRepository;
    protected $retailProductEntityRepository;

    public function __construct(ProductCatalogInterface $proCataRepository,
                                VolumeUnitInterface $volRepository,
                                ProductInterface $productRepository,
                                ProductGalleryInterface $productGalleryRepository,
                                IProductEntityServices $productEntityServices,
                                IProviderService $iProviderService,
                                ProductProviderInterface $productProviderInterface,
                                ComboInterface $comboRepository,
                                IAssignmentStoreService $iAssignmentStoreService,
                                StoreProductCatalogInterface $storeProductCatalogRepository,
                                ProductEntityInterface $productEntityRepository,
                                RetailProductEntityInterface $retailProductEntityRepository)
    {
        $this->proCataRepository = $proCataRepository;
        $this->volRepository = $volRepository;
        $this->productRepository = $productRepository;
        $this->productGalleryRepository = $productGalleryRepository;
        $this->productEntityServices = $productEntityServices;
        $this->iProviderService = $iProviderService;
        $this->productProviderInterface = $productProviderInterface;
        $this->comboRepository = $comboRepository;
        $this->iAssignmentStoreService = $iAssignmentStoreService;
        $this->storeProductCatalogRepository = $storeProductCatalogRepository;
        $this->productEntityRepository = $productEntityRepository;
        $this->retailProductEntityRepository = $retailProductEntityRepository;
    }
    
    /**
     * @inheritDoc
     */
    public function getById($id) {
        return $this->productRepository->getById($id, array(), array('with' => [
            'volumeUnit', 
            'productCatalog', 
            'productGalleries', 
            'productEntities.entityPrices', 
            'productEntities.entityAttributeFloat.productAttribute',
            'productEntities.entityAttributeInt.productAttribute',
            'productEntities.entityAttributeVarchar.productAttribute',
            'productProviders',
            'combos.productEntitie.product',
            'combos.productEntitie.entityAttributeFloat',
            'combos.productEntitie.entityAttributeInt',
            'combos.productEntitie.entityAttributeVarchar'
        ]));
    }

    /**
     * @inheritDoc
     */
    public function search($request = []) {
        $paging = isset($request['limit']) ? $request['limit'] : 10;
        $condition = [];
        if (isset($request['search'])) {
            $condition['search'] = $request['search'];
        }
        if (isset($request['product_type'])) {
            $condition['product_type'] = $request['product_type'];
        }

        if (!$this->iAssignmentStoreService->checkStoreIsOwnerOrBranch()) {
            $stores = $this->iAssignmentStoreService->getAssignedStore()->toArray();
            $idStore = array_column($stores, 'id');
            $storeProduct = $this->storeProductCatalogRepository->getMore(array('store_id' => $idStore ))->toArray();
            $idProductCatalog = array_column($storeProduct, 'product_catalog_id');
            $condition['product_catalog_id'] = $idProductCatalog;
        }

        $productEntity = $this->productRepository->getMore(
            $condition,
            array(
                'with' => [
                    'volumeUnit',
                    'productCatalog',
                    'productGalleries',
                    'productEntities.entityPrices', 
                    'productEntities.entityAttributeFloat.productAttribute',
                    'productEntities.entityAttributeInt.productAttribute',
                    'productEntities.entityAttributeVarchar.productAttribute'
                ],
                'orderBy' => 'id'
            ),
            $paging
        );

        return array(
            'items' => $productEntity->items(),
            'total' => $productEntity->total(),
            'paginate' => $paging
        ); 
    }
    
    /**
     * @inheritDoc
     */
    public function create()
    {
        $productCatalog = $this->proCataRepository->getMore(
            array('active_status' => 'active'),
            array('with' => [
                'attributesGroup.productAttributes.attributeFloats',
                'attributesGroup.productAttributes.attributeInts',
                'attributesGroup.productAttributes.attributeVarchars'
            ])
        );
        $volumeUnit = $this->volRepository->getAll();

        $providers =  $this->iProviderService->getProvider(array(), array(), 100);

        $stores = $this->iAssignmentStoreService->getAssignedStore();

        $data = [
            'product_catalog' => $productCatalog->toArray(),
            'volume_unit' => $volumeUnit->toArray(),
            'providers' => $providers['items'],
            'stores' => $stores->toArray()
        ];

        return $data;
    }
    
    /**
     * @inheritDoc
     */
    public function store($attributes = [])
    {
        $rules = array(
            'product_catalog_id' => 'required|integer',
            'volume_unit_id' => 'required|integer',
            'product_cd' => 'required|string',
            'product_name' => 'required|string',
            'product_display_name' => 'required|string',
            'quantity' => 'required|integer',
            'product_avatar' => 'required|string',
            'is_sales' => 'required|in:yes,no',
            'is_enable_tax' => 'required|in:yes,no',
            'product_type' => 'required|in:single,combo',
            'sku' => 'required|string',
            'unit' => 'required|string',
            'minimum_inventory' => 'required|integer',
            'providers' => 'required',
            'old_wholesale_prices' => 'required|integer',
            'old_cost_prices' => 'required|integer',
            'old_prices' => 'required|integer',
            'tax_percent' => 'required|integer'
        );
        if (isset($attributes['product_entity_cd'])) {
            $addRules = array(
                'product_entity_cd.*' => 'required|string',
                'cost_prices.*' => 'required|integer',
                'sku_entity.*' => 'required|string',
                'minimum_inventory_entity.*' => 'required|integer',
                'prices.*' => 'required|integer'
            );
            $rules = array_merge($rules, $addRules);
        }
        $validator = Validator::make($attributes, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        DB::beginTransaction();
        try {
            $product = $this->productRepository->create(array(
                'product_catalog_id' => $attributes['product_catalog_id'],
                'volume_unit_id' => $attributes['volume_unit_id'],
                'product_cd' => $attributes['product_cd'],
                'product_name' => $attributes['product_name'],
                'product_display_name' => $attributes['product_display_name'],
                'quantity' => $attributes['quantity'],
                'description' => $attributes['description'],
                'product_avatar' => $attributes['product_avatar'],
                'is_sales' => $attributes['is_sales'],
                'is_enable_tax' => $attributes['is_enable_tax'],
                'tax_percent' => $attributes['tax_percent'],
                'product_type' => $attributes['product_type'],
                'sku' => $attributes['sku'],
                'unit' => $attributes['unit'],
                'minimum_inventory' => $attributes['minimum_inventory']
            ));

            if (isset($attributes['product_image_url'])) {
                foreach($attributes['product_image_url'] as $anh) {
                    $this->productGalleryRepository->create(array(
                        'product_id' => $product->id,
                        'product_image_url' => $anh
                    ));
                }
            }

            if (isset($attributes['providers'])) {
                foreach($attributes['providers'] as $provider) {
                    $this->productProviderInterface->create(array(
                        'product_id' => $product->id,
                        'provider_id' => $provider
                    ));
                }
            }
            
            $this->productEntityServices->store($product->id, $attributes);
            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            
            throw new \Exception($e->getMessage());
        }
    }
      
    /**
     * @inheritDoc
     */
    public function update($id, $attributes = []) {
        $rules = array(
            'product_catalog_id' => 'required|integer',
            'volume_unit_id' => 'required|integer',
            'product_cd' => 'required|string',
            'product_name' => 'required|string',
            'product_display_name' => 'required|string',
            'quantity' => 'required|integer',
            'product_avatar' => 'required|string',
            'is_sales' => 'required|in:yes,no',
            'is_enable_tax' => 'required|in:yes,no',
            'product_type' => 'required|in:single,combo',
            'sku' => 'required|string',
            'unit' => 'required|string',
            'minimum_inventory' => 'required|integer',
            'providers' => 'required',
            'old_wholesale_prices' => 'required|integer',
            'old_cost_prices' => 'required|integer',
            'old_prices' => 'required|integer',
            'tax_percent' => 'required|integer'
        );
        if (isset($attributes['product_entity_cd'])) {
            $addRules = array(
                'product_entity_cd.*' => 'required|string',
                'cost_prices.*' => 'required|integer',
                'sku_entity.*' => 'required|string',
                'minimum_inventory_entity.*' => 'required|integer',
                'prices.*' => 'required|integer'
            );
            $rules = array_merge($rules, $addRules);
        }

        $validator = Validator::make($attributes, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        DB::beginTransaction();
        try {
            $product = $this->productRepository->updateById($id, array(
                'product_catalog_id' => $attributes['product_catalog_id'],
                'volume_unit_id' => $attributes['volume_unit_id'],
                'product_cd' => $attributes['product_cd'],
                'product_name' => $attributes['product_name'],
                'product_display_name' => $attributes['product_display_name'],
                'quantity' => $attributes['quantity'],
                'description' => $attributes['description'] ?? '',
                'product_avatar' => $attributes['product_avatar'],
                'is_sales' => $attributes['is_sales'],
                'is_enable_tax' => $attributes['is_enable_tax'],
                'tax_percent' => $attributes['tax_percent'],
                'product_type' => $attributes['product_type'],
                'sku' => $attributes['sku'],
                'unit' => $attributes['unit'],
                'minimum_inventory' => $attributes['minimum_inventory']
            ));

            //Xóa image
            if (isset($attributes['product_image_url'])) {
                $this->productGalleryRepository->deleteMore(
                    array('product_id' => $product->id)
                );

                foreach($attributes['product_image_url'] as $key => $anh) {
                    $this->productGalleryRepository->create(array(
                        'product_id' => $product->id,
                        'product_image_url' => $anh
                    ));
                }
            }

            if (isset($attributes['providers'])) {
                $this->productProviderInterface->deleteMore(
                    array('product_id' => $product->id)
                );

                foreach($attributes['providers'] as $provider) {
                    $this->productProviderInterface->create(array(
                        'product_id' => $product->id,
                        'provider_id' => $provider
                    ));
                }
            }
            
            $this->productEntityServices->update($id, $attributes);
            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @inheritDoc
     */
    public function storeCombo($attributes = [])
    {
        $rules = array(
            'product_catalog_id' => 'required|integer',
            'volume_unit_id' => 'required|integer',
            'product_cd' => 'required|string',
            'product_name' => 'required|string',
            'product_display_name' => 'required|string',
            'quantity' => 'required|integer',
            'product_avatar' => 'required|string',
            'is_sales' => 'required|in:yes,no',
            'is_enable_tax' => 'required|in:yes,no',
            'product_type' => 'required|in:single,combo',
            'sku' => 'required|string',
            'unit' => 'required|string',
            'minimum_inventory' => 'required|integer',
            'providers' => 'required',
            'old_wholesale_prices' => 'required|integer',
            'old_cost_prices' => 'required|integer',
            'old_prices' => 'required|integer',
            'tax_percent' => 'required|integer'
        );
        if (isset($attributes['related_product_id'])) {
            $addRules = array(
                'related_product_id.*' => 'required|integer',
                'related_product_quantity.*' => 'required|integer',
                'related_product_prices.*' => 'required|integer'
            );
            $rules = array_merge($rules, $addRules);
        }
        $validator = Validator::make($attributes, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        DB::beginTransaction();
        try {
            $product = $this->productRepository->create(array(
                'product_catalog_id' => $attributes['product_catalog_id'],
                'volume_unit_id' => $attributes['volume_unit_id'],
                'product_cd' => $attributes['product_cd'],
                'product_name' => $attributes['product_name'],
                'product_display_name' => $attributes['product_display_name'],
                'quantity' => $attributes['quantity'],
                'description' => $attributes['description'],
                'product_avatar' => $attributes['product_avatar'],
                'is_sales' => $attributes['is_sales'],
                'is_enable_tax' => $attributes['is_enable_tax'],
                'tax_percent' => $attributes['tax_percent'],
                'product_type' => $attributes['product_type'],
                'sku' => $attributes['sku'],
                'unit' => $attributes['unit'],
                'minimum_inventory' => $attributes['minimum_inventory']
            ));

            if (isset($attributes['product_image_url'])) {
                foreach($attributes['product_image_url'] as $anh) {
                    $this->productGalleryRepository->create(array(
                        'product_id' => $product->id,
                        'product_image_url' => $anh
                    ));
                }
            }

            if (isset($attributes['providers'])) {
                foreach($attributes['providers'] as $provider) {
                    $this->productProviderInterface->create(array(
                        'product_id' => $product->id,
                        'provider_id' => $provider
                    ));
                }
            }
            
            if (isset($attributes['related_product_id'])) {
                foreach($attributes['related_product_id'] as $key => $related_product_id) {
                    $this->comboRepository->create(array(
                        'product_id' => $product->id,
                        'related_product_id' => $related_product_id,
                        'quantity' => $attributes['related_product_quantity'][$key],
                        'prices' => $attributes['related_product_prices'][$key]
                    ));
                }
            }

            $this->productEntityServices->storeCombo($product->id, $attributes);

            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @inheritDoc
     */
    public function updateCombo($id, $attributes = []) {
        $rules = array(
            'product_catalog_id' => 'required|integer',
            'volume_unit_id' => 'required|integer',
            'product_cd' => 'required|string',
            'product_name' => 'required|string',
            'product_display_name' => 'required|string',
            'quantity' => 'required|integer',
            'product_avatar' => 'required|string',
            'is_sales' => 'required|in:yes,no',
            'is_enable_tax' => 'required|in:yes,no',
            'product_type' => 'required|in:single,combo',
            'sku' => 'required|string',
            'unit' => 'required|string',
            'minimum_inventory' => 'required|integer',
            'providers' => 'required',
            'old_wholesale_prices' => 'required|integer',
            'old_cost_prices' => 'required|integer',
            'old_prices' => 'required|integer',
            'tax_percent' => 'required|integer'
        );
        if (isset($attributes['related_product_id'])) {
            $addRules = array(
                'related_product_id.*' => 'required|integer',
                'related_product_quantity.*' => 'required|integer',
                'related_product_prices.*' => 'required|integer'
            );
            $rules = array_merge($rules, $addRules);
        }
        $validator = Validator::make($attributes, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        DB::beginTransaction();
        try {
            $product = $this->productRepository->updateById($id, array(
                'product_catalog_id' => $attributes['product_catalog_id'],
                'volume_unit_id' => $attributes['volume_unit_id'],
                'product_cd' => $attributes['product_cd'],
                'product_name' => $attributes['product_name'],
                'product_display_name' => $attributes['product_display_name'],
                'quantity' => $attributes['quantity'],
                'description' => $attributes['description'] ?? '',
                'product_avatar' => $attributes['product_avatar'],
                'is_sales' => $attributes['is_sales'],
                'is_enable_tax' => $attributes['is_enable_tax'],
                'tax_percent' => $attributes['tax_percent'],
                'product_type' => $attributes['product_type'],
                'sku' => $attributes['sku'],
                'unit' => $attributes['unit'],
                'minimum_inventory' => $attributes['minimum_inventory']
            ));

            //Xóa image
            if (isset($attributes['product_image_url'])) {
                $this->productGalleryRepository->deleteMore(
                    array('product_id' => $product->id)
                );

                foreach($attributes['product_image_url'] as $key => $anh) {
                    $this->productGalleryRepository->create(array(
                        'product_id' => $product->id,
                        'product_image_url' => $anh
                    ));
                }
            }

            if (isset($attributes['providers'])) {
                $this->productProviderInterface->deleteMore(
                    array('product_id' => $product->id)
                );

                foreach($attributes['providers'] as $provider) {
                    $this->productProviderInterface->create(array(
                        'product_id' => $product->id,
                        'provider_id' => $provider
                    ));
                }
            }

            if (isset($attributes['related_product_id'])) {
                $this->comboRepository->deleteMore(
                    array('product_id' => $product->id)
                );

                foreach($attributes['related_product_id'] as $key => $related_product_id) {
                    $this->comboRepository->create(array(
                        'product_id' => $product->id,
                        'related_product_id' => $related_product_id,
                        'quantity' => $attributes['related_product_quantity'][$key],
                        'prices' => $attributes['related_product_prices'][$key]
                    ));
                }
            }
            
            $this->productEntityServices->updateCombo($id, $attributes);
            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * importSingle
     *
     * @param  mixed $attributes
     * @return void
     */
    public function importSingle($attributes = []) {
        $danhMucId = array();
        foreach ($attributes as $key => $attribute) {
            $attributes[$key]['product_type'] = 'single';
            $validator = Validator::make($attribute, [
                'ten_san_pham' => 'required|string|max:255',
                'ma_san_pham' => 'nullable|string|max:50',
                'gia_ban_le' => 'nullable|numeric',
                'gia_ban_buon' => 'nullable|numeric',
                'gia_von' => 'nullable|numeric',
                'cho_phep_kinh_doanh' => 'required|in:Có,Không',
                'ap_dung_thue' => 'required|in:Có,Không',
            ]);

            $messToast = '';
            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $value) {
                    $messToast .=  'Dòng '. ( $key + 1 ) . ' ' . $value[0] . ' </br>';
                }
            }
            
            //Check danh mục sản phẩm
            $stores = $this->iAssignmentStoreService->getAssignedStore()->toArray();
            $idStore = array_column($stores, 'id');
    
            $danhMuc = $this->proCataRepository->getOne(array('product-catalog-store' => $idStore, 'product_catalog_name' => $attribute['loai_san_pham']));

            if (!$danhMuc) {
                $messToast .=  'Dòng '. ( $key + 1 ) .' Danh mục sản phẩm không tồn tại.';
            }

            if ($messToast != '') {
                throw \Illuminate\Validation\ValidationException::withMessages(['error' => $messToast]);
            }

            $danhMucId[$attribute['loai_san_pham']] = $danhMuc->id;
        }

        //Check đơn vị sản phẩm
        $donViKhoiLuong = $this->volRepository->getAll()->pluck('id', 'volume_unit_cd');

        ProductJob::dispatch($attributes, $danhMucId, $donViKhoiLuong)->onQueue('processing-san-pham');

        return true;
    }

    /**
     * importCombo
     *
     * @param  mixed $attributes
     * @return void
     */
    public function importCombo($attributes = []) {
        $danhMucId = array();
        $newArray = [];
        $parrent = null;
        foreach ($attributes as $key => $attribute) {
            $messToast = '';

            if (!empty($attribute['ma_san_pham']) || !empty($attribute['ten_san_pham'])) {
                $parrent = $key;
            }

            $validator = Validator::make($attribute, [
                'gia_ban_le' => 'required|numeric',
                'so_luong' => 'required|numeric',
                'ma_san_pham_con_trong_combo' => 'required|string'
            ]);

            $messToast = '';
            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $value) {
                    $messToast .=  'Dòng '. ( $key + 1 ) . ' ' . $value[0] . ' </br>';
                }
            }

            if ($parrent === null) {
                continue;
            }

            if (!empty($attribute['ma_san_pham']) || !empty($attribute['ten_san_pham'])) {
                $validator = Validator::make($attribute, [
                    'ten_san_pham' => 'required|string|max:255',
                    'ma_san_pham' => 'nullable|string|max:50',
                    'loai_san_pham' => 'required|string',
                    'khoi_luong' => 'nullable|numeric',
                    'don_vi' => 'nullable|string',
                    // 'don_vi_tinh' => 'required|string|max:20',
                    // 'mo_ta' => 'required|string|max:1024',
                    'gia_ban_le' => 'nullable|numeric',
                    'gia_ban_buon' => 'nullable|numeric',
                    'gia_von' => 'nullable|numeric',
                    'cho_phep_kinh_doanh' => 'required|in:Có,Không',
                    'ap_dung_thue' => 'required|in:Có,Không',
                ]);
    
                $messToast = '';
                if ($validator->fails()) {
                    foreach ($validator->errors()->messages() as $value) {
                        $messToast .=  'Dòng '. ( $key + 1 ) . ' ' . $value[0] . ' </br>';
                    }
                }

                $newArray[$parrent]['product_type'] = 'combo';
                $newArray[$parrent]['ten_san_pham'] = $attribute['ten_san_pham'];
                $newArray[$parrent]['ma_san_pham'] = $attribute['ma_san_pham'];
                $newArray[$parrent]['ma_sku'] = $attribute['ma_sku'];
                $newArray[$parrent]['loai_san_pham'] = $attribute['loai_san_pham'];
                $newArray[$parrent]['khoi_luong'] = $attribute['khoi_luong'];
                $newArray[$parrent]['don_vi'] = $attribute['don_vi'];
                $newArray[$parrent]['ma_san_pham_con_trong_combo'] = $attribute['ma_san_pham_con_trong_combo'];
                $newArray[$parrent]['so_luong'] = $attribute['so_luong'];
                $newArray[$parrent]['gia_ban_le'] = $attribute['gia_ban_le'];
                $newArray[$parrent]['gia_ban_buon'] = $attribute['gia_ban_buon'];
                $newArray[$parrent]['gia_von'] = $attribute['gia_von'];
                $newArray[$parrent]['cho_phep_kinh_doanh'] = $attribute['cho_phep_kinh_doanh'];
                $newArray[$parrent]['ap_dung_thue'] = $attribute['ap_dung_thue'];
                $newArray[$parrent]['anh_dai_dien'] = $attribute['anh_dai_dien'];
                $newArray[$parrent]['anh_san_pham'] = $attribute['anh_san_pham'];

                //Check danh mục sản phẩm
                $stores = $this->iAssignmentStoreService->getAssignedStore()->toArray();
                $idStore = array_column($stores, 'id');
        
                $danhMuc = $this->proCataRepository->getOne(array('product-catalog-store' => $idStore, 'product_catalog_name' => $attribute['loai_san_pham']));

                if (!$danhMuc) {
                    $messToast .=  'Dòng '. ( $key + 1 ) .' Danh mục sản phẩm không tồn tại.';
                } else {
                    $danhMucId[$attribute['loai_san_pham']] = $danhMuc->id;
                }

            }

            //Check mã sản phẩm trong combo
            $combo = $this->productEntityRepository->getOne(array('product_entity_cd' => $attribute['ma_san_pham_con_trong_combo']));
            if (!$combo) {
                $messToast .=  'Dòng '. ( $key + 1 ) .' Mã sản phẩm con trong combo không tồn tại.';
                throw \Illuminate\Validation\ValidationException::withMessages(['error' => $messToast]);
            }

            $newArray[$parrent]['related_product_id'][] = $combo->id;
            $newArray[$parrent]['related_product_quantity'][] = $attribute['so_luong'];
            $newArray[$parrent]['related_product_prices'][] = $attribute['gia_ban_le'];

            if ($messToast != '') {
                throw \Illuminate\Validation\ValidationException::withMessages(['error' => $messToast]);
            }
        }

        //Check đơn vị sản phẩm
        $donViKhoiLuong = $this->volRepository->getAll()->pluck('id', 'volume_unit_cd');

        ProductJob::dispatch($newArray, $danhMucId, $donViKhoiLuong)->onQueue('processing-san-pham');

        return true;
    }
    
    /**
     * handleImport
     *
     * @param  mixed $attributes
     * @param  mixed $danhMucId
     * @param  mixed $donViKhoiLuong
     * @return void
     */
    public function handleImport($attributes, $danhMucId, $donViKhoiLuong) {
        $store = null;

        foreach ($attributes as $key => $attribute) {
            $attribute['product_name'] = $attribute['ten_san_pham'];
            $attribute['product_display_name'] = $attribute['ten_san_pham'];
            $attribute['product_cd'] = $attribute['ma_san_pham'];
            $attribute['sku'] = $attribute['ma_sku'];
            $attribute['quantity'] = $attribute['khoi_luong'];
            $attribute['product_catalog_id'] = $danhMucId[$attribute['loai_san_pham']];
            $attribute['volume_unit_id'] = $donViKhoiLuong[$attribute['don_vi']];
            $attribute['unit'] = 'đơn vị';
            $attribute['description'] = '';
            $attribute['product_avatar'] = $attribute['anh_dai_dien'];
            $attribute['product_image_url'] = array($attribute['anh_san_pham']);
            $attribute['minimum_inventory'] = 0;
            $attribute['providers'] = [1];
            $attribute['old_wholesale_prices'] = $attribute['gia_ban_buon'];
            $attribute['old_cost_prices'] = $attribute['gia_von'];
            $attribute['old_prices'] = $attribute['gia_ban_le'];
            $attribute['tax_percent'] = 0;
            
            if ($attribute['cho_phep_kinh_doanh'] == "Có") {
                $attribute['is_sales'] = 'yes';
            } else {
                $attribute['is_sales'] = 'no';
            }
            if ($attribute['ap_dung_thue'] == "Có") {
                $attribute['is_enable_tax'] = 'yes';
            } else {
                $attribute['is_enable_tax'] = 'no';
            }
            
            if ($attribute['product_type'] == 'single') {
                $store = $this->store($attribute);
            } else {
                $store = $this->storeCombo($attribute);
            }
        }

        return $store;
    }

    /**
     * importSingleBranch
     *
     * @param  mixed $attributes
     * @return void
     */
    public function importSingleBranch($attributes = []) {
        foreach ($attributes as $key => $attribute) {
            $attributes[$key]['product_type'] = 'single';
            $validator = Validator::make($attribute, [
                'to_chuc' => 'required|string|max:255',
                'ma_to_chuc' => 'nullable|string|max:255',
                'ten_san_pham' => 'required|string|max:255',
                'ma_san_pham' => 'nullable|string|max:50',
                'gia_ban_le' => 'nullable|numeric',
                'gia_ban_buon' => 'nullable|numeric',
                'gia_von' => 'nullable|numeric',
                'cho_phep_kinh_doanh' => 'required|in:Có,Không',
                'ap_dung_thue' => 'required|in:Có,Không',
            ]);

            $messToast = '';
            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $value) {
                    $messToast .=  'Dòng '. ( $key + 1 ) . ' ' . $value[0] . ' </br>';
                }
            }
            
            //Check mã tổ chức, mã sản phẩm
            $stores = $this->iAssignmentStoreService->getAssignedStore()->firstWhere('store_cd', $attribute['ma_to_chuc']);
            if (!$stores) {
                $messToast .=  'Dòng '. ( $key + 1 ) .'Mã tổ chức không đúng.';
            }

            if ($messToast != '') {
                throw \Illuminate\Validation\ValidationException::withMessages(['error' => $messToast]);
            }
            
            $storeProduct = $this->storeProductCatalogRepository->getMore(array('store_id' => $stores['id'] ))->toArray();
            $idProductCatalog = array_column($storeProduct, 'product_catalog_id');
            $condition['product_catalog_id'] = $idProductCatalog;
            $condition['product_cd'] = $attribute['ma_san_pham'];
            $condition['product_type'] = 'single';

            $product = $this->productRepository->getOne(
                $condition,
                array(
                    'with' => [
                        'productCatalog',
                        'productGalleries',
                        'productEntities.entityPrices', 
                        'productEntities.entityAttributeFloat.productAttribute',
                        'productEntities.entityAttributeInt.productAttribute',
                        'productEntities.entityAttributeVarchar.productAttribute'
                    ],
                    'orderBy' => 'id'
                )
            );

            if (!$product) {
                $messToast .=  'Dòng '. ( $key + 1 ) .'Mã sản phẩm không đúng.';
            }

            if ($messToast != '') {
                throw \Illuminate\Validation\ValidationException::withMessages(['error' => $messToast]);
            }

            $attributes[$key]['product'] = $product;
            $attributes[$key]['storeId'] = $stores['id'];
        }

        RetailProductJob::dispatch($attributes)->onQueue('processing-san-pham');

        return true;
    }

    /**
     * importComboBranch
     *
     * @param  mixed $attributes
     * @return void
     */
    public function importComboBranch($attributes = []) {
        $newArray = [];
        $parrent = null;
        foreach ($attributes as $key => $attribute) {
            $messToast = '';

            if (!empty($attribute['ma_san_pham']) || !empty($attribute['ten_san_pham'])) {
                $parrent = $key;
            }

            $validator = Validator::make($attribute, [
                'gia_ban_le' => 'required|numeric',
                'so_luong' => 'required|numeric',
                'ma_san_pham_con_trong_combo' => 'required|string'
            ]);

            $messToast = '';
            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $value) {
                    $messToast .=  'Dòng '. ( $key + 1 ) . ' ' . $value[0] . ' </br>';
                }
            }

            if ($parrent === null) {
                continue;
            }

            if (!empty($attribute['ma_san_pham']) || !empty($attribute['ten_san_pham'])) {
                $validator = Validator::make($attribute, [
                    'to_chuc' => 'required|string|max:255',
                    'ma_to_chuc' => 'nullable|string|max:255',
                    'ten_san_pham' => 'required|string|max:255',
                    'ma_san_pham' => 'nullable|string|max:50',
                    'loai_san_pham' => 'required|string',
                    'khoi_luong' => 'nullable|numeric',
                    'don_vi' => 'nullable|string',
                    // 'don_vi_tinh' => 'required|string|max:20',
                    // 'mo_ta' => 'required|string|max:1024',
                    'gia_ban_le' => 'nullable|numeric',
                    'gia_ban_buon' => 'nullable|numeric',
                    'gia_von' => 'nullable|numeric',
                    'cho_phep_kinh_doanh' => 'required|in:Có,Không',
                    'ap_dung_thue' => 'required|in:Có,Không',
                ]);
    
                $messToast = '';
                if ($validator->fails()) {
                    foreach ($validator->errors()->messages() as $value) {
                        $messToast .=  'Dòng '. ( $key + 1 ) . ' ' . $value[0] . ' </br>';
                    }
                }

                //Check mã tổ chức
                $stores = $this->iAssignmentStoreService->getAssignedStore()->firstWhere('store_cd', $attribute['ma_to_chuc']);
                if (!$stores) {
                    $messToast .=  'Dòng '. ( $key + 1 ) .'Mã tổ chức không đúng.';
                }

                if ($messToast != '') {
                    throw \Illuminate\Validation\ValidationException::withMessages(['error' => $messToast]);
                }

                $newArray[$parrent]['storeId'] = $stores['id'];
                $newArray[$parrent]['product']['store_id'] = $stores['id'];
                $newArray[$parrent]['product']['product_type'] = 'combo';
                $newArray[$parrent]['product']['product_name'] = $attribute['ten_san_pham'];
                $newArray[$parrent]['product']['product_cd'] = $attribute['ma_san_pham'];
                $newArray[$parrent]['product']['product_display_name'] = $attribute['ma_san_pham'];
                $newArray[$parrent]['product']['sku'] = $attribute['ma_sku'];
                $newArray[$parrent]['product']['loai_san_pham'] = $attribute['loai_san_pham'];
                $newArray[$parrent]['product']['quantity'] = $attribute['khoi_luong'];
                $newArray[$parrent]['product']['unit'] = $attribute['don_vi'];
                $newArray[$parrent]['product']['ma_san_pham_con_trong_combo'] = $attribute['ma_san_pham_con_trong_combo'];
                $newArray[$parrent]['product']['description'] = '';
                $newArray[$parrent]['gia_ban_le'] = $attribute['gia_ban_le'];
                $newArray[$parrent]['gia_ban_buon'] = $attribute['gia_ban_buon'];
                $newArray[$parrent]['gia_von'] = $attribute['gia_von'];
                $newArray[$parrent]['cho_phep_kinh_doanh'] = $attribute['cho_phep_kinh_doanh'];
                $newArray[$parrent]['ap_dung_thue'] = $attribute['ap_dung_thue'];
                $newArray[$parrent]['anh_dai_dien'] = $attribute['anh_dai_dien'];
                $newArray[$parrent]['anh_san_pham'] = $attribute['anh_san_pham'];
                $newArray[$parrent]['product']['tax_percent'] = 0;
                $newArray[$parrent]['product']['product_type'] = 'combo';
                $newArray[$parrent]['product']['minimum_inventory'] = 0;

                //Check danh mục sản phẩm
                $stores = $this->iAssignmentStoreService->getAssignedStore()->toArray();
                $idStore = array_column($stores, 'id');
        
                $danhMuc = $this->proCataRepository->getOne(array('product-catalog-store' => $idStore, 'product_catalog_name' => $attribute['loai_san_pham']));

                if (!$danhMuc) {
                    $messToast .=  'Dòng '. ( $key + 1 ) .' Danh mục sản phẩm không tồn tại.';
                } else {
                    $newArray[$parrent]['product']['product_catalog_id'] = $danhMuc->id;
                }

                //Check đơn vị sản phẩm
                $donViKhoiLuong = $this->volRepository->getAll()->pluck('id', 'volume_unit_cd');
                $newArray[$parrent]['product']['volume_unit_id'] = $donViKhoiLuong[$attribute['don_vi']];
            }

            //Check mã sản phẩm trong combo
            $combo = $this->retailProductEntityRepository->getOne(array('product_entity_cd' => $attribute['ma_san_pham_con_trong_combo']));
            

            if (!$combo) {
                $messToast .=  'Dòng '. ( $key + 1 ) .' Mã sản phẩm con trong combo không tồn tại.';
                throw \Illuminate\Validation\ValidationException::withMessages(['error' => $messToast]);
            }

            $newArray[$parrent]['related_product_id'][] = $combo->product_id;
            $newArray[$parrent]['related_product_quantity'][] = $attribute['so_luong'];
            $newArray[$parrent]['related_product_prices'][] = $attribute['gia_ban_le'];

            if ($messToast != '') {
                throw \Illuminate\Validation\ValidationException::withMessages(['error' => $messToast]);
            }
        }

        RetailProductJob::dispatch($newArray)->onQueue('processing-san-pham');

        return true;
    }

    public function delete($id) {
        $this->productRepository->delByCond(array('id' => $id));

        return true;
    }
}
