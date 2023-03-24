<?php

namespace Database\Seeders\Account\MockData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use AccountSdkDb\Modules\Product\Models\ProductAttribute;
use AccountSdkDb\Modules\Product\Models\AttributeFloat;
use AccountSdkDb\Modules\Product\Models\AttributeInt;
use AccountSdkDb\Modules\Product\Models\AttributeVarchar;
use AccountSdkDb\Modules\Product\Models\AttributeGroup;

class ProductAttributeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $listAttributeGroup = [
                [
                    'attribute_group_name' => 'Nhóm thuộc tính thời trang nam',
                    'attribute_group_cd' => 'THOITRANGNAM',
                    'active_status' => 'active',
                ]
            ];
            foreach ($listAttributeGroup as $attributeGroup) {
                AttributeGroup::create(array(
                    'attribute_group_name' => $attributeGroup['attribute_group_name'],
                    'attribute_group_cd' => $attributeGroup['attribute_group_cd'],
                    'active_status' => $attributeGroup['active_status'],
                ));
            }
            $listProductAttribute = [
                [
                    'attribute_type_id' => 1,
                    'attribute_group_id' => 1,
                    'is_default' => false,
                    'attribute_display_name' => 'Màu sắc',
                    'attribute_cd' => 'MAUSAC',
                    'is_require' => false,
                    'active_status' => 'active',
                    'value_type' => 'varchar',
                    'value' => [
                        'Xanh', 'Đỏ', 'Vàng'
                    ]
                ],
                [
                    'attribute_type_id' => 1,
                    'attribute_group_id' => 1,
                    'is_default' => false,
                    'attribute_display_name' => 'Hạn sử dụng',
                    'attribute_cd' => 'HANSUDUNG',
                    'is_require' => false,
                    'active_status' => 'active',
                    'value_type' => 'varchar',
                    'value' => [
                        '01/01/2022'
                    ]
                ],
                [
                    'attribute_type_id' => 1,
                    'attribute_group_id' => 1,
                    'is_default' => false,
                    'attribute_display_name' => 'Size quần',
                    'attribute_cd' => 'SIZEQUAN',
                    'is_require' => false,
                    'active_status' => 'active',
                    'value_type' => 'varchar',
                    'value' => [
                        'S', 'M', 'L', 'XL', 'XXL'
                    ]
                ],
                [
                    'attribute_type_id' => 1,
                    'attribute_group_id' => 1,
                    'is_default' => false,
                    'attribute_display_name' => 'Size giày nam',
                    'attribute_cd' => 'SIZEGIAYNAM',
                    'is_require' => false,
                    'active_status' => 'active',
                    'value_type' => 'int',
                    'value' => [
                        '36', '37', '38', '39', '40'
                    ]
                ],
                [
                    'attribute_type_id' => 1,
                    'attribute_group_id' => 1,
                    'is_default' => false,
                    'attribute_display_name' => 'Khối lượng',
                    'attribute_cd' => 'KHOILUONG',
                    'is_require' => false,
                    'active_status' => 'active',
                    'value_type' => 'float',
                    'value' => [
                        0.5, 1.0, 1.5, 2.0, 2.5
                    ]
                ],
            ];
            foreach ($listProductAttribute as $indexProductAttribute => $productAttribute) {
                ProductAttribute::updateOrCreate(array(
                    'attribute_type_id' => $productAttribute['attribute_type_id'],
                    'attribute_group_id' => $productAttribute['attribute_group_id'],
                    'is_default' => $productAttribute['is_default'],
                    'attribute_display_name' => $productAttribute['attribute_display_name'],
                    'attribute_cd' => $productAttribute['attribute_cd'],
                    'is_require' => $productAttribute['is_require'],
                    'active_status' => $productAttribute['active_status'],
                ));
                if ($productAttribute['value_type'] == 'float') {
                    foreach ($productAttribute['value'] as $value) {
                        AttributeFloat::updateOrCreate(array(
                            'attribute_id' => $indexProductAttribute + 1,
                            'value_display_name' => $value,
                            'value' => $value,
                        ));
                    }
                } else if ($productAttribute['value_type'] == 'int') {
                    foreach ($productAttribute['value'] as $value) {
                        AttributeInt::updateOrCreate(array(
                            'attribute_id' => $indexProductAttribute + 1,
                            'value_display_name' => $value,
                            'value' => $value,
                        ));
                    }
                } else {
                    foreach ($productAttribute['value'] as $value) {
                        AttributeVarchar::updateOrCreate(array(
                            'attribute_id' => $indexProductAttribute + 1,
                            'value_display_name' => $value,
                            'value' => $value,
                        ));
                    }
                }
            }
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            throw $error;
        }
    }
}
