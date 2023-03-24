<?php

namespace App\Modules\Product\Services\Impls;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Common\Exceptions\PalException;
use Common\Exceptions\PalValidationException;
use App\Modules\Product\Events\AttributeGroupInsertEvent;
use App\Modules\Product\Events\AttributeGroupUpdateEvent;
use App\Modules\Product\Constants\AttributeConstant;
use App\Modules\Product\Repositories\Contracts\AttributeGroupInterface;
use App\Modules\Product\Repositories\Contracts\ProductAttributeInterface;
use App\Modules\Product\Repositories\Contracts\ProductCatalogAttributeGroupInterface;
use App\Modules\Product\Repositories\Contracts\AttributeFloatInterface;
use App\Modules\Product\Repositories\Contracts\AttributeIntInterface;
use App\Modules\Product\Repositories\Contracts\AttributeVarcharInterface;
use App\Modules\Product\Repositories\Contracts\ProductCatalogInterface;
use App\Modules\Product\Services\IAttributeGroupService;
use App\Modules\Master\Repositories\Contracts\AttributeTypeInterface;

/**
 * @inheritDoc
 */
class AttributeGroupImplement implements IAttributeGroupService
{
    protected $attributeGroupRepository;
    protected $productAttributeRepository;
    protected $productCatalogAttributeGroupRepository;
    protected $attributeFloatRepository;
    protected $attributeIntRepository;
    protected $attributeVarcharRepository;
    protected $attributeTypeRepository;
    protected $productCatalogRepository;

    /**
     * AttributeGroupServices constructor.
     * @param AttributeGroupInterface $attributeGroupRepository
     * @param ProductAttributeInterface $productAttributeRepository
     * @param ProductCatalogAttributeGroupInterface $productCatalogAttributeGroupRepository
     * @param AttributeFloatInterface $attributeFloatRepository
     * @param AttributeIntInterface $attributeIntRepository
     * @param AttributeVarcharInterface $attributeVarcharRepository
     * @param AttributeTypeInterface $attributeTypeRepository
     * @param ProductCatalogInterface $productCatalogRepository
     */
    public function __construct(AttributeGroupInterface $attributeGroupRepository,
                                ProductAttributeInterface $productAttributeRepository,
                                ProductCatalogAttributeGroupInterface $productCatalogAttributeGroupRepository,
                                AttributeFloatInterface $attributeFloatRepository,
                                AttributeIntInterface $attributeIntRepository,
                                AttributeVarcharInterface $attributeVarcharRepository,
                                AttributeTypeInterface $attributeTypeRepository,
                                ProductCatalogInterface $productCatalogRepository
    )
    {
        $this->attributeGroupRepository = $attributeGroupRepository;
        $this->productAttributeRepository = $productAttributeRepository;
        $this->productCatalogAttributeGroupRepository = $productCatalogAttributeGroupRepository;
        $this->attributeFloatRepository = $attributeFloatRepository;
        $this->attributeIntRepository = $attributeIntRepository;
        $this->attributeVarcharRepository = $attributeVarcharRepository;
        $this->attributeTypeRepository = $attributeTypeRepository;
        $this->productCatalogRepository = $productCatalogRepository;
    }

    /**
     * @inheritDoc
     */
    public function getList() {
        return $this->attributeGroupRepository->getMore(
            array(),
            array(
                'with' => array(
                    'productAttributes',
                    'productAttributes.attributeFloats',
                    'productAttributes.attributeInts',
                    'productAttributes.attributeVarchars',
                )
            )
        );
    }

    /**
     * @inheritDoc
     */
    public function getCreateInfos() {
        $productCatalog = $this->productCatalogRepository->getAll();
        $attributeType = $this->attributeTypeRepository->getAll();

        return array(
            'product_catalog' => $productCatalog,
            'attribute_type' => $attributeType
        );
    }

    /**
     * @inheritDoc
     */
    public function store($payload) {
        $validators = Validator::make($payload, array(
            'attribute_group_cd' => 'required|string|max:255|unique:acc_t_attribute_groups,attribute_group_cd',
            'attribute_group_name' => 'required|string|max:255|unique:acc_t_attribute_groups,attribute_group_name',
            'product_catalog_id' => 'required',
            'product_catalog_id.*' => 'required|exists:acc_t_product_catalogs,id',
            'product_attribute_list' => 'required',
            'product_attribute_list.*.attribute_cd' => 'required|string|max:255|unique:acc_t_product_attributes,attribute_cd',
            'product_attribute_list.*.attribute_display_name' => 'required|string|max:255|unique:acc_t_product_attributes,attribute_display_name',
            'product_attribute_list.*.attribute_type_id' => 'required|exists:acc_m_attribute_type,id',
            'product_attribute_list.*.is_default' => 'required',
            'product_attribute_list.*.is_require' => 'required',
            'product_attribute_list.*.value' => 'required',
            'product_attribute_list.*.value.*' => 'required|string|max:255',
        ));
        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',422);
        }

        $storedAttributeGroup = null;

        DB::beginTransaction();
        $storedAttributeGroup = $this->attributeGroupRepository->create(array(
            'attribute_group_cd' => $payload['attribute_group_cd'],
            'attribute_group_name' => $payload['attribute_group_name'],
            'active_status' => 'active',
        ));

        $listProductCatalogId = $payload['product_catalog_id'];
        foreach ($listProductCatalogId as $productCatalogId) {
            $this->productCatalogAttributeGroupRepository->create(array(
                'product_catalog_id' => $productCatalogId,
                'attribute_group_id' => $storedAttributeGroup->id
            ));
        }

        $listAttributeType = $this->attributeTypeRepository->getAll();
        $listAttributeTypeKey = [];
        $listAttributeType->map(function ($attributeType) use (&$listAttributeTypeKey) {
            $listAttributeTypeKey[$attributeType['id']] = $attributeType['attribute_cd'];
        });

        $attributeTypeValue = AttributeConstant::attribute_type_value;
        $listProductAttribute = $payload['product_attribute_list'];
        foreach ($listProductAttribute as $productAttribute) {
            $storedProductAttribute = $this->productAttributeRepository->create(array(
                'attribute_type_id' => $productAttribute['attribute_type_id'],
                'attribute_group_id' => $storedAttributeGroup->id,
                'attribute_display_name' => $productAttribute['attribute_display_name'],
                'attribute_cd' => $productAttribute['attribute_cd'],
                'is_default' => $productAttribute['is_default'],
                'is_require' => $productAttribute['is_require'],
                'active_status' => 'active',
            ));

            if ($attributeTypeValue[$listAttributeTypeKey[$productAttribute['attribute_type_id']]] == 'float') {
                foreach ($productAttribute['value'] as $productAttributeValue) {
                    $this->attributeFloatRepository->create(array(
                        'attribute_id' => $storedProductAttribute['id'],
                        'value_display_name' => $productAttributeValue,
                        'value' => $productAttributeValue,
                    ));
                }
            } elseif ($attributeTypeValue[$listAttributeTypeKey[$productAttribute['attribute_type_id']]] == 'int') {
                foreach ($productAttribute['value'] as $productAttributeValue) {
                    $this->attributeIntRepository->create(array(
                        'attribute_id' => $storedProductAttribute['id'],
                        'value_display_name' => $productAttributeValue,
                        'value' => $productAttributeValue,
                    ));
                }
            } else {
                foreach ($productAttribute['value'] as $productAttributeValue) {
                    $this->attributeVarcharRepository->create(array(
                        'attribute_id' => $storedProductAttribute['id'],
                        'value_display_name' => $productAttributeValue,
                        'value' => $productAttributeValue,
                    ));
                }
            }
        }

        if (!is_null($storedAttributeGroup)) {
            DB::commit();
            Event::dispatch(new AttributeGroupInsertEvent($storedAttributeGroup));
        } else {
            DB::rollBack();
            throw new PalException('E000001');
        }

        return $storedAttributeGroup;
    }

    /**
     * @inheritDoc
     */
    public function show($attributeGroupId) {
        $validators = Validator::make(array(
            'attribute_id' => $attributeGroupId
        ), array(
            'attribute_id' => "required|exists:acc_t_attribute_groups,id",
        ));
        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',422);
        }

        return $this->attributeGroupRepository->getById($attributeGroupId,
            array(),
            array(
                'with' => array(
                    'productCatalogs',
                    'productAttributes',
                    'productAttributes.attributeFloats',
                    'productAttributes.attributeInts',
                    'productAttributes.attributeVarchars',
                )
            )
        );
    }

    /**
     * @inheritDoc
     */
    public function update($id, $payload) {
        $validators = Validator::make($payload, array(
            'attribute_group_cd' => "required|string|max:255|unique:acc_t_attribute_groups,attribute_group_cd,{$id}",
            'attribute_group_name' => "required|string|max:255|unique:acc_t_attribute_groups,attribute_group_name,{$id}",
            'product_catalog_id' => 'required',
            'product_catalog_id.*' => 'required|exists:acc_t_product_catalogs,id',
            'product_attribute_list' => 'required',
            'product_attribute_list.*.attribute_cd' => 'required|string|max:255',
            'product_attribute_list.*.attribute_display_name' => 'required|string|max:255',
            'product_attribute_list.*.attribute_type_id' => 'required|exists:acc_m_attribute_type,id',
            'product_attribute_list.*.is_default' => 'required',
            'product_attribute_list.*.is_require' => 'required',
            'product_attribute_list.*.value' => 'required',
            'product_attribute_list.*.value.*' => 'required|string|max:255',
        ));
        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',422);
        }

        $updatedAttributeGroup = null;

        DB::beginTransaction();
        $updatedAttributeGroup = $this->attributeGroupRepository->updateById($id, array(
            'attribute_group_cd' => $payload['attribute_group_cd'],
            'attribute_group_name' => $payload['attribute_group_name']
        ));

        $this->productCatalogAttributeGroupRepository->delByCond(array(
            'attribute_group_id' => $updatedAttributeGroup->id
        ));

        $listProductCatalogId = $payload['product_catalog_id'];
        foreach ($listProductCatalogId as $productCatalogId) {
            $this->productCatalogAttributeGroupRepository->create(array(
                'product_catalog_id' => $productCatalogId,
                'attribute_group_id' => $updatedAttributeGroup->id
            ));
        }

        $listAttributeType = $this->attributeTypeRepository->getAll();
        $listAttributeTypeKey = [];
        $listAttributeType->map(function ($attributeType) use (&$listAttributeTypeKey) {
            $listAttributeTypeKey[$attributeType['id']] = $attributeType['attribute_cd'];
        });

        $currentProductAttributes = $this->productAttributeRepository->getMore(
            array(
                'attribute_group_id' => $updatedAttributeGroup->id
            )
        );
        $currentProductAttributeIds = $currentProductAttributes->map(function ($productAttribute) { return $productAttribute->id; });

        $this->productAttributeRepository->delByCond(array(
            'attribute_group_id' => $updatedAttributeGroup->id
        ));

        $this->attributeFloatRepository->delByCond(array(
            'list_product_attribute_id' => $currentProductAttributeIds
        ));
        $this->attributeIntRepository->delByCond(array(
            'list_product_attribute_id' => $currentProductAttributeIds
        ));
        $this->attributeVarcharRepository->delByCond(array(
            'list_product_attribute_id' => $currentProductAttributeIds
        ));

        $attributeTypeValue = AttributeConstant::attribute_type_value;
        $listProductAttribute = $payload['product_attribute_list'];
        foreach ($listProductAttribute as $productAttribute) {
            $storedProductAttribute = $this->productAttributeRepository->create(array(
                'attribute_type_id' => $productAttribute['attribute_type_id'],
                'attribute_group_id' => $updatedAttributeGroup->id,
                'attribute_display_name' => $productAttribute['attribute_display_name'],
                'attribute_cd' => $productAttribute['attribute_cd'],
                'is_default' => $productAttribute['is_default'],
                'is_require' => $productAttribute['is_require'],
            ));

            if ($attributeTypeValue[$listAttributeTypeKey[$productAttribute['attribute_type_id']]] == 'float') {
                foreach ($productAttribute['value'] as $productAttributeValue) {
                    $this->attributeFloatRepository->create(array(
                        'attribute_id' => $storedProductAttribute['id'],
                        'value_display_name' => $productAttributeValue,
                        'value' => $productAttributeValue,
                    ));
                }
            } elseif ($attributeTypeValue[$listAttributeTypeKey[$productAttribute['attribute_type_id']]] == 'int') {
                foreach ($productAttribute['value'] as $productAttributeValue) {
                    $this->attributeIntRepository->create(array(
                        'attribute_id' => $storedProductAttribute['id'],
                        'value_display_name' => $productAttributeValue,
                        'value' => $productAttributeValue,
                    ));
                }
            } else {
                foreach ($productAttribute['value'] as $productAttributeValue) {
                    $this->attributeVarcharRepository->create(array(
                        'attribute_id' => $storedProductAttribute['id'],
                        'value_display_name' => $productAttributeValue,
                        'value' => $productAttributeValue,
                    ));
                }
            }
        }

        if (!is_null($updatedAttributeGroup)) {
            DB::commit();
            Event::dispatch(new AttributeGroupUpdateEvent($updatedAttributeGroup));
        } else {
            DB::rollBack();
            throw new PalException('E000001');
        }

        return $updatedAttributeGroup;
    }

    /**
     * @inheritDoc
     */
    public function updateStatus($attributeGroupId, $payload) {
        $validators = Validator::make(array(
            'id' => $attributeGroupId,
            'active_status' => $payload['active_status']
        ), array(
            'id' => 'required|exists:acc_t_attribute_groups,id',
            'active_status' => 'required|in:active,inactive',
        ));
        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',422);
        }

        if ($payload['active_status'] == 'inactive') {
            $this->productAttributeRepository->updateByCondition(
                array(
                    'attribute_group_id' => $attributeGroupId
                ),
                array(
                    'active_status' => 'inactive'
                ),
                array(),
                true
            );
        }

        return $this->attributeGroupRepository->updateById($attributeGroupId, array(
            'active_status' => $payload['active_status']
        ));
    }
}
