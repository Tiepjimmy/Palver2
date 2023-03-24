<?php

namespace App\Modules\Product\Services\Impls;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Common\Exceptions\PalException;
use Common\Exceptions\PalValidationException;
use App\Modules\Master\Repositories\Contracts\AttributeTypeInterface;
use App\Modules\Product\Events\AttributeInsertEvent;
use App\Modules\Product\Events\AttributeUpdateEvent;
use App\Modules\Product\Constants\AttributeConstant;
use App\Modules\Product\Repositories\Contracts\AttributeGroupInterface;
use App\Modules\Product\Repositories\Contracts\AttributeFloatInterface;
use App\Modules\Product\Repositories\Contracts\AttributeIntInterface;
use App\Modules\Product\Repositories\Contracts\AttributeVarcharInterface;
use App\Modules\Product\Repositories\Contracts\ProductAttributeInterface;
use App\Modules\Product\Repositories\Contracts\ProductCatalogInterface;
use App\Modules\Product\Services\IAttributeService;

/**
 * @inheritDoc
 */
class AttributeImplement implements IAttributeService
{
    protected $attributeGroupRepository;
    protected $productAttributeRepository;
    protected $attributeFloatRepository;
    protected $attributeIntRepository;
    protected $attributeVarcharRepository;
    protected $attributeTypeRepository;
    protected $productCatalogRepository;

    /**
     * AttributeServices constructor.
     * @param AttributeGroupInterface $attributeGroupRepository
     * @param ProductAttributeInterface $productAttributeRepository
     * @param AttributeFloatInterface $attributeFloatRepository
     * @param AttributeIntInterface $attributeIntRepository
     * @param AttributeVarcharInterface $attributeVarcharRepository
     * @param AttributeTypeInterface $attributeTypeRepository
     * @param ProductCatalogInterface $productCatalogRepository
     */
    public function __construct(AttributeGroupInterface $attributeGroupRepository,
                                ProductAttributeInterface $productAttributeRepository,
                                AttributeFloatInterface $attributeFloatRepository,
                                AttributeIntInterface $attributeIntRepository,
                                AttributeVarcharInterface $attributeVarcharRepository,
                                AttributeTypeInterface $attributeTypeRepository,
                                ProductCatalogInterface $productCatalogRepository
    )
    {
        $this->attributeGroupRepository = $attributeGroupRepository;
        $this->productAttributeRepository = $productAttributeRepository;
        $this->attributeFloatRepository = $attributeFloatRepository;
        $this->attributeIntRepository = $attributeIntRepository;
        $this->attributeVarcharRepository = $attributeVarcharRepository;
        $this->attributeTypeRepository = $attributeTypeRepository;
        $this->productCatalogRepository = $productCatalogRepository;
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
            'attribute_group_id' => 'required|exists:acc_t_attribute_groups,id',
            'attribute_cd' => 'required|string|max:255|unique:acc_t_product_attributes,attribute_cd',
            'attribute_display_name' => 'required|string|max:255|unique:acc_t_product_attributes,attribute_display_name',
            'attribute_type_id' => 'required|exists:acc_m_attribute_type,id',
            'is_default' => 'required|boolean',
            'is_require' => 'required|boolean',
            'value' => 'required',
            'value.*' => 'required|string|max:255',
        ));
        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',422);
        }

        $storedProductAttribute = null;

        DB::beginTransaction();

        $listAttributeType = $this->attributeTypeRepository->getAll();
        $listAttributeTypeKey = [];
        $listAttributeType->map(function ($attributeType) use (&$listAttributeTypeKey) {
            $listAttributeTypeKey[$attributeType['id']] = $attributeType['attribute_cd'];
        });

        $attributeTypeValue = AttributeConstant::attribute_type_value;
        $storedProductAttribute = $this->productAttributeRepository->create(array(
            'attribute_type_id' => $payload['attribute_type_id'],
            'attribute_group_id' => $payload['attribute_group_id'],
            'attribute_display_name' => $payload['attribute_display_name'],
            'attribute_cd' => $payload['attribute_cd'],
            'is_default' => $payload['is_default'],
            'is_require' => $payload['is_require'],
            'active_status' => 'active',
        ));

        if ($attributeTypeValue[$listAttributeTypeKey[$payload['attribute_type_id']]] == 'float') {
            foreach ($payload['value'] as $productAttributeValue) {
                $this->attributeFloatRepository->create(array(
                    'attribute_id' => $storedProductAttribute['id'],
                    'value_display_name' => $productAttributeValue,
                    'value' => $productAttributeValue,
                ));
            }
        } elseif ($attributeTypeValue[$listAttributeTypeKey[$payload['attribute_type_id']]] == 'int') {
            foreach ($payload['value'] as $productAttributeValue) {
                $this->attributeIntRepository->create(array(
                    'attribute_id' => $storedProductAttribute['id'],
                    'value_display_name' => $productAttributeValue,
                    'value' => $productAttributeValue,
                ));
            }
        } else {
            foreach ($payload['value'] as $productAttributeValue) {
                $this->attributeVarcharRepository->create(array(
                    'attribute_id' => $storedProductAttribute['id'],
                    'value_display_name' => $productAttributeValue,
                    'value' => $productAttributeValue,
                ));
            }
        }

        if (!is_null($storedProductAttribute)) {
            DB::commit();
            Event::dispatch(new AttributeInsertEvent($storedProductAttribute));
        } else {
            DB::rollBack();
            throw new PalException('E000001');
        }

        return $storedProductAttribute;
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
    public function update($attributeId, $payload) {
        $validators = Validator::make(
            array_merge($payload, ['id' => $attributeId]),
            array(
                'id' => 'required|exists:acc_t_product_attributes,id',
                'attribute_group_id' => 'required|exists:acc_t_attribute_groups,id',
                'attribute_cd' => "required|string|max:255|unique:acc_t_product_attributes,attribute_cd,{$attributeId}",
                'attribute_display_name' => "required|string|max:255|unique:acc_t_product_attributes,attribute_display_name,{$attributeId}",
                'attribute_type_id' => 'required|exists:acc_m_attribute_type,id',
                'is_default' => 'required|boolean',
                'is_require' => 'required|boolean',
                'value' => 'required',
                'value.*' => 'required|string|max:255',
        ));
        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',422);
        }

        $updatedProductAttribute = null;

        DB::beginTransaction();

        $listAttributeType = $this->attributeTypeRepository->getAll();
        $listAttributeTypeKey = [];
        $listAttributeType->map(function ($attributeType) use (&$listAttributeTypeKey) {
            $listAttributeTypeKey[$attributeType['id']] = $attributeType['attribute_cd'];
        });

        $attributeTypeValue = AttributeConstant::attribute_type_value;
        $updatedProductAttribute = $this->productAttributeRepository->updateById($attributeId, array(
            'attribute_type_id' => $payload['attribute_type_id'],
            'attribute_group_id' => $payload['attribute_group_id'],
            'attribute_display_name' => $payload['attribute_display_name'],
            'attribute_cd' => $payload['attribute_cd'],
            'is_default' => $payload['is_default'],
            'is_require' => $payload['is_require'],
            'active_status' => 'active',
        ));

        $this->attributeFloatRepository->delByCond(array(
            'attribute_id' => $attributeId
        ));
        $this->attributeIntRepository->delByCond(array(
            'attribute_id' => $attributeId
        ));
        $this->attributeVarcharRepository->delByCond(array(
            'attribute_id' => $attributeId
        ));

        if ($attributeTypeValue[$listAttributeTypeKey[$payload['attribute_type_id']]] == 'float') {
            foreach ($payload['value'] as $productAttributeValue) {
                $this->attributeFloatRepository->create(array(
                    'attribute_id' => $attributeId,
                    'value_display_name' => $productAttributeValue,
                    'value' => $productAttributeValue,
                ));
            }
        } elseif ($attributeTypeValue[$listAttributeTypeKey[$payload['attribute_type_id']]] == 'int') {
            foreach ($payload['value'] as $productAttributeValue) {
                $this->attributeIntRepository->create(array(
                    'attribute_id' => $attributeId,
                    'value_display_name' => $productAttributeValue,
                    'value' => $productAttributeValue,
                ));
            }
        } else {
            foreach ($payload['value'] as $productAttributeValue) {
                $this->attributeVarcharRepository->create(array(
                    'attribute_id' => $attributeId,
                    'value_display_name' => $productAttributeValue,
                    'value' => $productAttributeValue,
                ));
            }
        }

        if (!is_null($updatedProductAttribute)) {
            DB::commit();
            Event::dispatch(new AttributeUpdateEvent($updatedProductAttribute));
        } else {
            DB::rollBack();
            throw new PalException('E000001');
        }

        return $updatedProductAttribute;
    }

    /**
     * @inheritDoc
     */
    public function destroy($attributeId) {
        $validators = Validator::make(array(
            'id' => $attributeId
        ), array(
            'id' => 'required|exists:acc_t_product_attributes,id',
        ));
        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',422);
        }

        return $this->productAttributeRepository->delByCond(array(
            'id' => $attributeId
        ));
    }

    /**
     * @inheritDoc
     */
    public function updateStatus($attributeId, $payload) {
        $validators = Validator::make(array(
            'id' => $attributeId,
            'active_status' => $payload['active_status']
        ), array(
            'id' => 'required|exists:acc_t_product_attributes,id',
            'active_status' => 'required|in:active,inactive',
        ));
        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',422);
        }

        return $this->productAttributeRepository->updateById($attributeId, array(
            'active_status' => $payload['active_status']
        ));
    }
}
