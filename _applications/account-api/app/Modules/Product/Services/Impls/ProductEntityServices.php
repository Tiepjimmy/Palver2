<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\Product\Services\Impls;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

use App\Modules\Product\Repositories\Contracts\ProductEntityInterface;
use App\Modules\Product\Repositories\Contracts\ProductEntityPriceInterface;
use App\Modules\Product\Repositories\Contracts\ProductEntityAttributeFloatInterface;
use App\Modules\Product\Repositories\Contracts\ProductEntityAttributeIntInterface;
use App\Modules\Product\Repositories\Contracts\ProductEntityAttributeVarcharInterface;
use App\Modules\Product\Services\IProductEntityServices;

class ProductEntityServices implements IProductEntityServices
{
    protected $productEntityInterface;
    protected $productEntityPriceInterface;
    protected $productEntityAttributeFloatInterface;
    protected $productEntityAttributeIntInterface;
    protected $productEntityAttributeVarcharInterface;

    public function __construct(ProductEntityInterface $productEntityInterface,
                                ProductEntityPriceInterface $productEntityPriceInterface,
                                ProductEntityAttributeFloatInterface $productEntityAttributeFloatInterface,
                                ProductEntityAttributeIntInterface $productEntityAttributeIntInterface,
                                ProductEntityAttributeVarcharInterface $productEntityAttributeVarcharInterface)
    {
        $this->productEntityInterface = $productEntityInterface;
        $this->productEntityPriceInterface = $productEntityPriceInterface;
        $this->productEntityAttributeFloatInterface = $productEntityAttributeFloatInterface;
        $this->productEntityAttributeIntInterface = $productEntityAttributeIntInterface;
        $this->productEntityAttributeVarcharInterface = $productEntityAttributeVarcharInterface;
    }

    /**
     * @inheritDoc
     */
    public function search($request = []) {
        $paging = isset($request['limit']) ? $request['limit'] : 5;
        $condition = [];
        if (isset($request['search'])) {
            $condition['search'] = $request['search'];
        }
        $productEntity = $this->productEntityInterface->getMore(
            $condition,
            array(
                'with' => [
                    'product',
                    'entityPrices',
                    // 'retailProduct',
                    // 'retailEntityPrices',
                    'entityAttributeFloat.productAttribute',
                    'entityAttributeInt.productAttribute',
                    'entityAttributeVarchar.productAttribute'
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
    public function store($id, $attributes = [])
    {
        DB::beginTransaction();
        try {
            //Sản phẩm Entity đơn
            if (isset($attributes['product_entity_cd'])) {
                foreach ($attributes['product_entity_cd'] as $key => $entity) {
                    $productEntity = $this->productEntityInterface->create(array(
                        'product_id' => $id,
                        'product_entity_cd' => $entity,
                        'is_overwrite_prices' => $attributes['is_overwrite_prices'][$key],
                        'sku' => $attributes['sku_entity'][$key],
                        'has_options' => 1,
                        'product_entity_avatar' => '',
                        'is_show' => 1,
                        'minimum_inventory' => $attributes['minimum_inventory_entity'][$key]
                    ));
        
                    $this->productEntityPriceInterface->create(array(
                        'product_entity_id' => $productEntity->id,
                        'user_id' => Auth::id(),
                        'old_prices' => $attributes['old_prices'],
                        'old_wholesale_prices' => $attributes['old_wholesale_prices'],
                        'old_cost_prices' => $attributes['old_cost_prices'],
                        'prices' => $attributes['prices'][$key],
                        'wholesale_prices' => $attributes['wholesale_prices'][$key],
                        'cost_prices' => $attributes['cost_prices'][$key],
                        'apply_started_at' => date('Y-m-d H:i:s'),
                        'apply_ended_at' => date('Y-m-d H:i:s')
                    ));

                    if (isset($attributes['product_entity_attribute_id'])) {
                        $attribute_id = explode(',', $attributes['product_entity_attribute_id'][$key]);
                        $attribute_value = explode(',', $attributes['product_entity_attribute_value'][$key]);
                        $attribute_type = explode(',', $attributes['product_entity_attribute_type'][$key]);
                        foreach ($attribute_id as $index => $item) {
                            if ($attribute_type[$index] == 'varchar') {
                                $this->productEntityAttributeVarcharInterface->create(array(
                                    'product_entity_id' => $productEntity->id,
                                    'attribute_id' => $item,
                                    'varchar_value' => $attribute_value[$index]
                                ));
                            } else if ($attribute_type[$index] == 'int') {
                                $this->productEntityAttributeIntInterface->create(array(
                                    'product_entity_id' => $productEntity->id,
                                    'attribute_id' => $item,
                                    'int_value' => $attribute_value[$index]
                                ));
                            } else {
                                $this->productEntityAttributeFloatInterface->create(array(
                                    'product_entity_id' => $productEntity->id,
                                    'attribute_id' => $item,
                                    'float_value' => $attribute_value[$index]
                                ));
                            }
                        }
                    }
                }
            } else {
                $productEntity = $this->productEntityInterface->create(array(
                    'product_id' => $id,
                    'product_entity_cd' => $attributes['product_cd'],
                    'is_overwrite_prices' => 0,
                    'sku' => $attributes['sku'],
                    'has_options' => 0,
                    'product_entity_avatar' => '',
                    'is_show' => 1,
                    'minimum_inventory' => $attributes['minimum_inventory']
                ));

                $this->productEntityPriceInterface->create(array(
                    'product_entity_id' => $productEntity->id,
                    'user_id' => Auth::id(),
                    'old_prices' => $attributes['old_prices'],
                    'old_wholesale_prices' => $attributes['old_wholesale_prices'],
                    'old_cost_prices' => $attributes['old_cost_prices'],
                    'prices' => $attributes['old_prices'],
                    'wholesale_prices' => $attributes['old_wholesale_prices'],
                    'cost_prices' => $attributes['old_cost_prices'],
                    'apply_started_at' => date('Y-m-d H:i:s'),
                    'apply_ended_at' => date('Y-m-d H:i:s')
                ));
            }
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            
            throw new \Exception($e->getMessage());
        }
    }
    
    /**
     * @inheritDoc
     */
    public function update($id, $attributes = []) {
        DB::beginTransaction();
        try {
            //Sản phẩm Entity đơn
            if (isset($attributes['product_entity_cd'])) {
                //Xóa productEntity
                $deleteProductEntity = $this->productEntityInterface->deleteMore(
                    array(
                        'idNotIn' => $attributes['product_entity_id'],
                        'product_id' => $id
                    )
                );

                foreach ($attributes['product_entity_cd'] as $key => $entity) {
                    //Check thêm/update productEntity
                    if (isset($attributes['product_entity_id'][$key]) && $attributes['product_entity_id'][$key] != 0 ) {
                        $productEntity = $this->productEntityInterface->updateById($attributes['product_entity_id'][$key], array(
                            'product_id' => $id,
                            'product_entity_cd' => $entity,
                            'is_overwrite_prices' => $attributes['is_overwrite_prices'][$key],
                            'sku' => $attributes['sku_entity'][$key],
                            'has_options' => 1,
                            'product_entity_avatar' => '',
                            'is_show' => 1,
                            'minimum_inventory' => $attributes['minimum_inventory_entity'][$key]
                        ));
            
                        $this->productEntityPriceInterface->updateByCondition(
                            array('product_entity_id' => $productEntity->id),
                            array(
                                'user_id' => Auth::id(),
                                'old_prices' => $attributes['old_prices'],
                                'old_wholesale_prices' => $attributes['old_wholesale_prices'],
                                'old_cost_prices' => $attributes['old_cost_prices'],
                                'prices' => $attributes['prices'][$key],
                                'wholesale_prices' => $attributes['wholesale_prices'][$key],
                                'cost_prices' => $attributes['cost_prices'][$key],
                                'apply_started_at' => date('Y-m-d H:i:s'),
                                'apply_ended_at' => date('Y-m-d H:i:s')
                            )
                        );

                        if (isset($attributes['product_entity_attribute_id']) && $attributes['product_entity_attribute_id'][$key] != '' ) {
                            $attribute_id = explode(',', $attributes['product_entity_attribute_id'][$key]);
                            $attribute_value = explode(',', $attributes['product_entity_attribute_value'][$key]);
                            $attribute_type = explode(',', $attributes['product_entity_attribute_type'][$key]);
                            $this->productEntityAttributeVarcharInterface->deleteMore(array('product_entity_id' => $productEntity->id));
                            $this->productEntityAttributeIntInterface->deleteMore(array('product_entity_id' => $productEntity->id));
                            $this->productEntityAttributeFloatInterface->deleteMore(array('product_entity_id' => $productEntity->id));

                            foreach ($attribute_id as $index => $item) {
                                if ($attribute_type[$index] == 'varchar') {
                                    $this->productEntityAttributeVarcharInterface->create(array(
                                        'product_entity_id' => $productEntity->id,
                                        'attribute_id' => $item,
                                        'varchar_value' => $attribute_value[$index]
                                    ));
                                } else if ($attribute_type[$index] == 'int') {
                                    $this->productEntityAttributeIntInterface->create(array(
                                        'product_entity_id' => $productEntity->id,
                                        'attribute_id' => $item,
                                        'int_value' => $attribute_value[$index]
                                    ));
                                } else {
                                    $this->productEntityAttributeFloatInterface->create(array(
                                        'product_entity_id' => $productEntity->id,
                                        'attribute_id' => $item,
                                        'float_value' => $attribute_value[$index]
                                    ));
                                }
                            }
                        }
                    } else {
                        $productEntity = $this->productEntityInterface->create(array(
                            'product_id' => $id,
                            'product_entity_cd' => $entity,
                            'is_overwrite_prices' => $attributes['is_overwrite_prices'][$key],
                            'sku' => $attributes['sku_entity'][$key],
                            'has_options' => 1,
                            'product_entity_avatar' =>'',
                            'is_show' => 1,
                            'minimum_inventory' => $attributes['minimum_inventory_entity'][$key]
                        ));
            
                        $this->productEntityPriceInterface->create(array(
                            'product_entity_id' => $productEntity->id,
                            'user_id' => Auth::id(),
                            'old_prices' => $attributes['old_prices'],
                            'old_wholesale_prices' => $attributes['old_wholesale_prices'],
                            'old_cost_prices' => $attributes['old_cost_prices'],
                            'prices' => $attributes['prices'][$key],
                            'wholesale_prices' => $attributes['wholesale_prices'][$key],
                            'cost_prices' => $attributes['cost_prices'][$key],
                            'apply_started_at' => date('Y-m-d H:i:s'),
                            'apply_ended_at' => date('Y-m-d H:i:s')
                        ));
            
                        if (isset($attributes['product_entity_attribute_id'])) {
                            $attribute_id = explode(',', $attributes['product_entity_attribute_id'][$key]);
                            $attribute_value = explode(',', $attributes['product_entity_attribute_value'][$key]);
                            $attribute_type = explode(',', $attributes['product_entity_attribute_type'][$key]);
                            foreach ($attribute_id as $index => $item) {
                                if ($attribute_type[$index] == 'varchar') {
                                    $this->productEntityAttributeVarcharInterface->create(array(
                                        'product_entity_id' => $productEntity->id,
                                        'attribute_id' => $item,
                                        'varchar_value' => $attribute_value[$index]
                                    ));
                                } else if ($attribute_type[$index] == 'int') {
                                    $this->productEntityAttributeIntInterface->create(array(
                                        'product_entity_id' => $productEntity->id,
                                        'attribute_id' => $item,
                                        'int_value' => $attribute_value[$index]
                                    ));
                                } else {
                                    $this->productEntityAttributeFloatInterface->create(array(
                                        'product_entity_id' => $productEntity->id,
                                        'attribute_id' => $item,
                                        'float_value' => $attribute_value[$index]
                                    ));
                                }
                            }
                        }
                    }
                }
            } else {
                $productEntity = $this->productEntityInterface->updateByCondition(
                    array('product_id' => $id),
                    array(
                        'product_id' => $id,
                        'product_entity_cd' => $attributes['product_cd'],
                        'is_overwrite_prices' => 0,
                        'sku' => $attributes['sku'],
                        'has_options' => 0,
                        'product_entity_avatar' => '',
                        'is_show' => 1,
                        'minimum_inventory' => $attributes['minimum_inventory']
                    )
                );

                $this->productEntityPriceInterface->updateByCondition(
                    array('product_entity_id' => $productEntity->id),
                    array(
                        'product_entity_id' => $productEntity->id,
                        'user_id' => Auth::id(),
                        'old_prices' => $attributes['old_prices'],
                        'old_wholesale_prices' => $attributes['old_wholesale_prices'],
                        'old_cost_prices' => $attributes['old_cost_prices'],
                        'prices' => $attributes['old_prices'],
                        'wholesale_prices' => $attributes['old_wholesale_prices'],
                        'cost_prices' => $attributes['old_cost_prices'],
                        'apply_started_at' => date('Y-m-d H:i:s'),
                        'apply_ended_at' => date('Y-m-d H:i:s')
                    )
                );
            }
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @inheritDoc
     */
    public function storeCombo($id, $attributes = [])
    {
        DB::beginTransaction();
        try {
            //Sản phẩm Entity đơn
            $productEntity = $this->productEntityInterface->create(array(
                'product_id' => $id,
                'product_entity_cd' => $attributes['product_cd'],
                'is_overwrite_prices' => 0,
                'sku' => $attributes['sku'],
                'has_options' => 0,
                'product_entity_avatar' => '',
                'is_show' => 1,
                'minimum_inventory' => $attributes['minimum_inventory']
            ));

            $this->productEntityPriceInterface->create(array(
                'product_entity_id' => $productEntity->id,
                'user_id' => Auth::id(),
                'old_prices' => $attributes['old_prices'],
                'old_wholesale_prices' => $attributes['old_wholesale_prices'],
                'old_cost_prices' => $attributes['old_cost_prices'],
                'prices' => $attributes['old_prices'],
                'wholesale_prices' => $attributes['old_wholesale_prices'],
                'cost_prices' => $attributes['old_cost_prices'],
                'apply_started_at' => date('Y-m-d H:i:s'),
                'apply_ended_at' => date('Y-m-d H:i:s')
            ));
            
            DB::commit();
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
        DB::beginTransaction();
        try {
            //Sản phẩm Entity đơn
            $productEntity = $this->productEntityInterface->updateByCondition(
                array('product_id' => $id),
                array(
                    'product_id' => $id,
                    'product_entity_cd' => $attributes['product_cd'],
                    'is_overwrite_prices' => 0,
                    'sku' => $attributes['sku'],
                    'has_options' => 0,
                    'product_entity_avatar' => '',
                    'is_show' => 1,
                    'minimum_inventory' => $attributes['minimum_inventory']
                )
            );

            $this->productEntityPriceInterface->updateByCondition(
                array('product_entity_id' => $productEntity->id),
                array(
                    'product_entity_id' => $productEntity->id,
                    'user_id' => Auth::id(),
                    'old_prices' => $attributes['old_prices'],
                    'old_wholesale_prices' => $attributes['old_wholesale_prices'],
                    'old_cost_prices' => $attributes['old_cost_prices'],
                    'prices' => $attributes['old_prices'],
                    'wholesale_prices' => $attributes['old_wholesale_prices'],
                    'cost_prices' => $attributes['old_cost_prices'],
                    'apply_started_at' => date('Y-m-d H:i:s'),
                    'apply_ended_at' => date('Y-m-d H:i:s')
                )
            );
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            
            throw new \Exception($e->getMessage());
        }
    }
}
