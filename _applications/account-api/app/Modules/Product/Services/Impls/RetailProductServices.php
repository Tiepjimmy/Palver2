<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\Product\Services\Impls;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

use App\Modules\Product\Repositories\Contracts\RetailProductInterface;
use App\Modules\Product\Services\IRetailProductEntityServices;
use App\Modules\Product\Repositories\Contracts\RetailProductGalleryInterface;
use App\Modules\Product\Repositories\Contracts\RetailComboInterface;

use AccountSdkDb\Modules\Store\Services\IAssignmentStoreService;
use App\Modules\Product\Services\IRetailProductServices;

class RetailProductServices implements IRetailProductServices
{
    protected $retailProductRepository;
    protected $retailProductEntityServices;
    protected $retailProductGalleryRepository;
    protected $retailComboRepository;
    protected $iAssignmentStoreService;

    public function __construct(RetailProductInterface $retailProductRepository,
                                IRetailProductEntityServices $retailProductEntityServices,
                                RetailProductGalleryInterface $retailProductGalleryRepository,
                                RetailComboInterface $retailComboRepository,
                                IAssignmentStoreService $iAssignmentStoreService)
    {
        $this->retailProductRepository = $retailProductRepository;
        $this->retailProductEntityServices = $retailProductEntityServices;
        $this->retailProductGalleryRepository = $retailProductGalleryRepository;
        $this->retailComboRepository = $retailComboRepository;
        $this->iAssignmentStoreService = $iAssignmentStoreService;
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

        $stores = $this->iAssignmentStoreService->getAssignedStore()->toArray();
        $idStore = array_column($stores, 'id');
        $condition['store_id'] = $idStore;

        $productEntity = $this->retailProductRepository->getMore(
            $condition,
            array(
                'with' => [
                    'volumeUnit',
                    'productCatalog',
                    'retailProductEntities.retailEntityPrice',
                    'retailProductEntities.productEntity.entityAttributeFloat.productAttribute',
                    'retailProductEntities.productEntity.entityAttributeInt.productAttribute',
                    'retailProductEntities.productEntity.entityAttributeVarchar.productAttribute',
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
    public function getById($id) {
        return $this->retailProductRepository->getById($id, array(), array('with' => [
            'volumeUnit',
            'productCatalog',
            'productGalleries',
            'retailProductEntities.retailEntityPrice',
            'retailProductEntities.productEntity.entityAttributeFloat.productAttribute',
            'retailProductEntities.productEntity.entityAttributeInt.productAttribute',
            'retailProductEntities.productEntity.entityAttributeVarchar.productAttribute',
            'combos.productEntitie.product',
            'combos.productEntitie.entityAttributeFloat',
            'combos.productEntitie.entityAttributeInt',
            'combos.productEntitie.entityAttributeVarchar'
        ]));
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
            'tax_percent' => 'required|integer',
            'product_type' => 'required|in:single,combo',
            'sku' => 'required|string',
            'unit' => 'required|string',
            'minimum_inventory' => 'required|integer',
            'old_wholesale_prices' => 'required|integer',
            'old_cost_prices' => 'required|integer',
            'old_prices' => 'required|integer',
            'store_id' => 'required|integer'
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
            $product = $this->retailProductRepository->create(array(
                'store_id' => $attributes['store_id'],
                'product_id' => $attributes['product_id'],
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
                    $this->retailProductGalleryRepository->create(array(
                        'product_id' => $product->id,
                        'product_image_url' => $anh
                    ));
                }
            }
            
            $this->retailProductEntityServices->store($product->id, $attributes);
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
            'tax_percent' => 'required|integer',
            'product_type' => 'required|in:single,combo',
            'sku' => 'required|string',
            'unit' => 'required|string',
            'minimum_inventory' => 'required|integer',
            'old_wholesale_prices' => 'required|integer',
            'old_cost_prices' => 'required|integer',
            'old_prices' => 'required|integer',
            'store_id' => 'required|integer'
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
            $product = $this->retailProductRepository->create(array(
                'store_id' => $attributes['store_id'],
                'product_id' => null,
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
                    $this->retailProductGalleryRepository->create(array(
                        'product_id' => $product->id,
                        'product_image_url' => $anh
                    ));
                }
            }
            
            if (isset($attributes['related_product_id'])) {
                foreach($attributes['related_product_id'] as $key => $related_product_id) {
                    $this->retailComboRepository->create(array(
                        'product_id' => $product->id,
                        'related_product_id' => $related_product_id,
                        'quantity' => $attributes['related_product_quantity'][$key],
                        'prices' => $attributes['related_product_prices'][$key]
                    ));
                }
            }

            $this->retailProductEntityServices->storeCombo($product->id, $attributes);

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
            'tax_percent' => 'required|integer',
            'product_type' => 'required|in:single,combo',
            'sku' => 'required|string',
            'unit' => 'required|string',
            'minimum_inventory' => 'required|integer',
            'old_wholesale_prices' => 'required|integer',
            'old_cost_prices' => 'required|integer',
            'old_prices' => 'required|integer',
            'store_id' => 'required|integer'
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
            $product = $this->retailProductRepository->updateById($id, array(
                'store_id' => $attributes['store_id'],
                'product_id' => $attributes['product_id'],
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
                $this->retailProductGalleryRepository->deleteMore(
                    array('product_id' => $product->id)
                );

                foreach($attributes['product_image_url'] as $key => $anh) {
                    $this->retailProductGalleryRepository->create(array(
                        'product_id' => $product->id,
                        'product_image_url' => $anh
                    ));
                }
            }

            $this->retailProductEntityServices->update($id, $attributes);
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
    public function updateCombo($id, $attributes = [])
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
            'tax_percent' => 'required|integer',
            'product_type' => 'required|in:single,combo',
            'sku' => 'required|string',
            'unit' => 'required|string',
            'minimum_inventory' => 'required|integer',
            'old_wholesale_prices' => 'required|integer',
            'old_cost_prices' => 'required|integer',
            'old_prices' => 'required|integer',
            'store_id' => 'required|integer'
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
            $product = $this->retailProductRepository->updateById($id, array(
                'store_id' => $attributes['store_id'],
                'product_id' => null,
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

            //Xóa image
            if (isset($attributes['product_image_url'])) {
                $this->retailProductGalleryRepository->deleteMore(
                    array('product_id' => $product->id)
                );

                foreach($attributes['product_image_url'] as $key => $anh) {
                    $this->retailProductGalleryRepository->create(array(
                        'product_id' => $product->id,
                        'product_image_url' => $anh
                    ));
                }
            }

            if (isset($attributes['related_product_id'])) {
                $this->retailComboRepository->deleteMore(
                    array('product_id' => $product->id)
                );

                foreach($attributes['related_product_id'] as $key => $related_product_id) {
                    $this->retailComboRepository->create(array(
                        'product_id' => $product->id,
                        'related_product_id' => $related_product_id,
                        'quantity' => $attributes['related_product_quantity'][$key],
                        'prices' => $attributes['related_product_prices'][$key]
                    ));
                }
            }

            $this->retailProductEntityServices->updateCombo($product->id, $attributes);

            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();

            throw new \Exception($e->getMessage());
        }
    }

    /**
     * handleImportBranch
     *
     * @param  mixed $attributes
     * @return void
     */
    public function handleImportBranch($attributes) {
        $store = null;

        foreach ($attributes as $key => $attribute) {
            $attribute['store_id'] = $attribute['storeId'];
            $attribute['product_catalog_id'] = $attribute['product']['product_catalog_id'];
            $attribute['volume_unit_id'] = $attribute['product']['volume_unit_id'];
            $attribute['product_cd'] = $attribute['product']['product_cd'];
            $attribute['product_name'] = $attribute['product']['product_name'];
            $attribute['product_display_name'] = $attribute['product']['product_display_name'];
            $attribute['quantity'] = $attribute['product']['quantity'];
            $attribute['description'] = $attribute['product']['description'];
            $attribute['product_avatar'] = $attribute['anh_dai_dien'];
            $attribute['product_image_url'] = array($attribute['anh_san_pham']);
            $attribute['tax_percent'] = $attribute['product']['tax_percent'];
            $attribute['product_type'] = $attribute['product']['product_type'];
            $attribute['sku'] = $attribute['product']['sku'];
            $attribute['unit'] = $attribute['product']['unit'];
            $attribute['minimum_inventory'] = $attribute['product']['minimum_inventory'];
            $attribute['old_wholesale_prices'] = $attribute['gia_ban_buon'];
            $attribute['old_cost_prices'] = $attribute['gia_von'];
            $attribute['old_prices'] = $attribute['gia_ban_le'];
            
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
                $attribute['product_id'] = $attribute['product']['id'];
                foreach ($attribute['product']['productEntities'] as $entity) {
                    $attribute['product_entity_id'][] = $entity['id'];
                    $attribute['product_entity_cd'][] = $entity['product_entity_cd'];
                    $attribute['is_overwrite_prices'][] = $entity['is_overwrite_prices'];
                    $attribute['sku_entity'][] = $entity['sku'];
                    $attribute['minimum_inventory_entity'][] = $entity['minimum_inventory'];
                    $attribute['prices'][] = $entity['entityPrices']['prices'];
                    $attribute['wholesale_prices'][] = $entity['entityPrices']['wholesale_prices'];
                    $attribute['cost_prices'][] = $entity['entityPrices']['cost_prices'];
                }
                $store = $this->store($attribute);
            } else {
                $store = $this->storeCombo($attribute);
            }
        }

        return $store;
    }

    public function delete($id) {
        $this->retailProductRepository->delByCond(array('id' => $id));

        return true;
    }
}
