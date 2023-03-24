<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\Product\Services\Impls;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

use App\Modules\Product\Repositories\Contracts\RetailProductEntityInterface;
use App\Modules\Product\Repositories\Contracts\RetailProductEntityPriceInterface;
use App\Modules\Product\Services\IRetailProductEntityServices;

class RetailProductEntityServices implements IRetailProductEntityServices
{
    protected $retailProductEntityRepository;
    protected $retailProductEntityPriceRepository;

    public function __construct(RetailProductEntityInterface $retailProductEntityRepository,
                                RetailProductEntityPriceInterface $retailProductEntityPriceRepository)
    {
        $this->retailProductEntityRepository = $retailProductEntityRepository;
        $this->retailProductEntityPriceRepository = $retailProductEntityPriceRepository;
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
        if (isset($request['product_type'])) {
            $condition['product_type'] = $request['product_type'];
        }
        $productEntity = $this->retailProductEntityRepository->getMore(
            $condition,
            array(
                'with' => [
                    'product',
                    'retailEntityPrice',
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
    public function getById($id) {
        return $this->retailProductEntityRepository->getById($id, array(), array('with' => [
            'volumeUnit',
            'productCatalog'
        ]));
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
                    $retailProduct = $this->retailProductEntityRepository->create(array(
                        'product_id' => $id,
                        'store_id' => $attributes['store_id'],
                        'product_entity_id' => $attributes['product_entity_id'][$key],
                        'product_entity_cd' => $entity,
                        'is_overwrite_prices' => $attributes['is_overwrite_prices'][$key],
                        'sku' => $attributes['sku_entity'][$key],
                        'has_options' => 1,
                        'product_entity_avatar' => '',
                        'is_show' => 1,
                        'minimum_inventory' => $attributes['minimum_inventory_entity'][$key]
                    ));
        
                    $this->retailProductEntityPriceRepository->create(array(
                        'product_entity_id' => $retailProduct->id,
                        'user_id' => 1,
                        'old_prices' => $attributes['old_prices'],
                        'old_wholesale_prices' => $attributes['old_wholesale_prices'],
                        'old_cost_prices' => $attributes['old_cost_prices'],
                        'prices' => $attributes['prices'][$key],
                        'wholesale_prices' => $attributes['wholesale_prices'][$key],
                        'cost_prices' => $attributes['cost_prices'][$key],
                        'apply_started_at' => date('Y-m-d H:i:s'),
                        'apply_ended_at' => date('Y-m-d H:i:s')
                    ));
                }
            } else {
                $retailProduct = $this->retailProductEntityRepository->create(array(
                    'product_id' => $id,
                    'store_id' =>$attributes['store_id'],
                    'product_entity_id' => $attributes['product_entity_id'],
                    'product_entity_cd' => $attributes['product_cd'],
                    'is_overwrite_prices' => 0,
                    'sku' => $attributes['sku'],
                    'has_options' => 0,
                    'product_entity_avatar' => '',
                    'is_show' => 1,
                    'minimum_inventory' => $attributes['minimum_inventory']
                ));

                $this->retailProductEntityPriceRepository->create(array(
                    'product_entity_id' => $retailProduct->id,
                    'user_id' => 1,
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
    public function storeCombo($id, $attributes = [])
    {
        DB::beginTransaction();
        try {
            //Sản phẩm Entity đơn
            $productEntity = $this->retailProductEntityRepository->create(array(
                'product_entity_id' => null,
                'store_id' => $attributes['store_id'],
                'product_id' => $id,
                'product_entity_cd' => $attributes['product_cd'],
                'is_overwrite_prices' => 0,
                'sku' => $attributes['sku'],
                'has_options' => 0,
                'product_entity_avatar' => '',
                'is_show' => 1,
                'minimum_inventory' => $attributes['minimum_inventory']
            ));

            $this->retailProductEntityPriceRepository->create(array(
                'product_entity_id' => $productEntity->id,
                'user_id' => 1,
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
    public function update($id, $attributes = []) {
        DB::beginTransaction();
        try {
            //Sản phẩm Entity đơn
            if (isset($attributes['product_entity_cd'])) {
                //Xóa productEntity
                $deleteProductEntity = $this->retailProductEntityRepository->deleteMore(
                    array(
                        'idNotIn' => $attributes['entity_id'],
                        'product_id' => $id
                    )
                );

                foreach ($attributes['product_entity_cd'] as $key => $entity) {
                    //Check thêm/update productEntity
                    if (isset($attributes['entity_id'][$key]) && $attributes['entity_id'][$key] != 0 ) {
                        $retailProduct = $this->retailProductEntityRepository->updateById($attributes['entity_id'][$key], array(
                            'product_id' => $id,
                            'store_id' => $attributes['store_id'],
                            'product_entity_id' => $attributes['product_entity_id'][$key],
                            'product_entity_cd' => $entity,
                            'is_overwrite_prices' => $attributes['is_overwrite_prices'][$key],
                            'sku' => $attributes['sku_entity'][$key],
                            'has_options' => 1,
                            'product_entity_avatar' => '',
                            'is_show' => 1,
                            'minimum_inventory' => $attributes['minimum_inventory_entity'][$key]
                        ));

                        $this->retailProductEntityPriceRepository->updateByCondition(
                            array('product_entity_id' => $retailProduct->id),
                            array(
                                'product_entity_id' => $retailProduct->id,
                                'user_id' => 1,
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
                    } else {
                        $retailProduct = $this->retailProductEntityRepository->create(array(
                            'product_id' => $id,
                            'store_id' => $attributes['store_id'],
                            'product_entity_id' => $attributes['product_entity_id'][$key],
                            'product_entity_cd' => $entity,
                            'is_overwrite_prices' => $attributes['is_overwrite_prices'][$key],
                            'sku' => $attributes['sku_entity'][$key],
                            'has_options' => 1,
                            'product_entity_avatar' => '',
                            'is_show' => 1,
                            'minimum_inventory' => $attributes['minimum_inventory_entity'][$key]
                        ));

                        $this->retailProductEntityPriceRepository->create(array(
                            'product_entity_id' => $retailProduct->id,
                            'user_id' => 1,
                            'old_prices' => $attributes['old_prices'],
                            'old_wholesale_prices' => $attributes['old_wholesale_prices'],
                            'old_cost_prices' => $attributes['old_cost_prices'],
                            'prices' => $attributes['prices'][$key],
                            'wholesale_prices' => $attributes['wholesale_prices'][$key],
                            'cost_prices' => $attributes['cost_prices'][$key],
                            'apply_started_at' => date('Y-m-d H:i:s'),
                            'apply_ended_at' => date('Y-m-d H:i:s')
                        ));
                    }
                }
            } else {
                $retailProduct = $this->retailProductEntityRepository->updateByCondition(
                    array('product_id' => $id),
                    array(
                        'product_id' => $id,
                        'store_id' =>$attributes['store_id'],
                        'product_entity_id' => $attributes['product_entity_id'],
                        'product_entity_cd' => $attributes['product_cd'],
                        'is_overwrite_prices' => 0,
                        'sku' => $attributes['sku'],
                        'has_options' => 0,
                        'product_entity_avatar' => '',
                        'is_show' => 1,
                        'minimum_inventory' => $attributes['minimum_inventory']
                    )
                );

                $this->retailProductEntityPriceRepository->updateByCondition(
                    array('product_entity_id' => $retailProduct->id),
                    array(
                        'product_entity_id' => $retailProduct->id,
                        'user_id' => 1,
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
    public function updateCombo($id, $attributes = [])
    {
        DB::beginTransaction();
        try {
            //Sản phẩm Entity đơn
            $productEntity = $this->retailProductEntityRepository->updateByCondition(
                array('product_id' => $id),
                array(
                    'product_entity_id' => null,
                    'store_id' => $attributes['store_id'],
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

            $this->retailProductEntityPriceRepository->updateByCondition(
                array('product_entity_id' => $productEntity->id),
                array(
                    'product_entity_id' => $productEntity->id,
                    'user_id' => 1,
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
