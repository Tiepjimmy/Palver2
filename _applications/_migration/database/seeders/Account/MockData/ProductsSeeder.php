<?php

namespace Database\Seeders\Account\MockData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use AccountSdkDb\Modules\Product\Models\Product;
use AccountSdkDb\Modules\Product\Models\ProductGallery;
use AccountSdkDb\Modules\Product\Models\ProductEntity;
use AccountSdkDb\Modules\Product\Models\ProductEntityPrice;
use AccountSdkDb\Modules\Product\Models\ProductEntityAttributeFloat;
use AccountSdkDb\Modules\Product\Models\ProductEntityAttributeInt;
use AccountSdkDb\Modules\Product\Models\ProductEntityAttributeVarchar;
use AccountSdkDb\Modules\Product\Models\Combo;
use AccountSdkDb\Modules\Product\Models\RetailProduct;
use AccountSdkDb\Modules\Product\Models\RetailProductEntity;
use AccountSdkDb\Modules\Product\Models\RetailProductEntityPrice;
use AccountSdkDb\Modules\Product\Models\RetailProductGallery;
use AccountSdkDb\Modules\Provider\Models\ProductProvider;

class ProductsSeeder extends Seeder
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
            $productData = [
                [
                    'product_catalog_id' => 5,
                    'volume_unit_id' => 1,
                    'product_cd' => 'QAAS001',
                    'product_name' => 'Áo sweater',
                    'product_display_name' => 'Áo sweater',
                    'quantity' => 50,
                    'description' => 'Áo sweater phong cách, áo nỉ bông',
                    'product_avatar' => 'https://cf.shopee.vn/file/c03a5aba0abd13d74014c59a87f57864_tn',
                    'is_sales' => 'yes',
                    'is_enable_tax' => 'yes',
                    'tax_percent' => '50',
                    'product_type' => 'single',
                    'sku' => 'SKUQAAS001',
                    'unit' => 'Cái',
                    'product_image_url' => 'https://cf.shopee.vn/file/c03a5aba0abd13d74014c59a87f57864_tn',
                    'entity' => [
                        [
                            'product_entity_cd' => 'QAAS001',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQAAS001',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/c03a5aba0abd13d74014c59a87f57864_tn',
                            'user_id' => null,
                            'old_prices' => 10000,
                            'old_wholesale_prices' => 10000,
                            'old_cost_prices' => 10000,
                            'prices' => 10000,
                            'wholesale_prices' => 10000,
                            'cost_prices' => 10000,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Xanh'
                        ],
                        [
                            'product_entity_cd' => 'QAAS002',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQAAS002',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/c03a5aba0abd13d74014c59a87f57864_tn',
                            'user_id' => null,
                            'old_prices' => 10001,
                            'old_wholesale_prices' => 10001,
                            'old_cost_prices' => 10001,
                            'prices' => 10001,
                            'wholesale_prices' => 10001,
                            'cost_prices' => 10001,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Đỏ'
                        ]
                    ]
                ],
                [
                    'product_catalog_id' => 5,
                    'volume_unit_id' => 1,
                    'product_cd' => 'QAASMC001',
                    'product_name' => 'Áo sơ mi Cotton',
                    'product_display_name' => 'Áo sơ mi Cotton',
                    'quantity' => 50,
                    'description' => 'Áo sơ mi Cotton tay ngắn phong cách Pháp',
                    'product_avatar' => 'https://cf.shopee.vn/file/3626ccd2c9f0fd353c1dedbfb89f40cd_tn',
                    'is_sales' => 'yes',
                    'is_enable_tax' => 'yes',
                    'tax_percent' => '50',
                    'product_type' => 'single',
                    'sku' => 'SKUQAASMC001',
                    'unit' => 'Cái',
                    'product_image_url' => 'https://cf.shopee.vn/file/3626ccd2c9f0fd353c1dedbfb89f40cd_tn',
                    'entity' => [
                        [
                            'product_entity_cd' => 'QAASMC001',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQAASMC001',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/3626ccd2c9f0fd353c1dedbfb89f40cd_tn',
                            'user_id' => null,
                            'old_prices' => 10000,
                            'old_wholesale_prices' => 10000,
                            'old_cost_prices' => 10000,
                            'prices' => 10000,
                            'wholesale_prices' => 10000,
                            'cost_prices' => 10000,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Xanh'
                        ],
                        [
                            'product_entity_cd' => 'QAASMC002',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQAASMC002',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/3626ccd2c9f0fd353c1dedbfb89f40cd_tn',
                            'user_id' => null,
                            'old_prices' => 10001,
                            'old_wholesale_prices' => 10001,
                            'old_cost_prices' => 10001,
                            'prices' => 10001,
                            'wholesale_prices' => 10001,
                            'cost_prices' => 10001,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Đỏ'
                        ]
                    ]
                ],
                [
                    'product_catalog_id' => 5,
                    'volume_unit_id' => 1,
                    'product_cd' => 'QAAHN001',
                    'product_name' => 'Áo hoddie nỉ',
                    'product_display_name' => 'Áo hoddie nỉ',
                    'quantity' => 50,
                    'description' => 'Áo hoddie nỉ ấm áp mùa hè',
                    'product_avatar' => 'https://cf.shopee.vn/file/7731345aa64bd2c7526f0291bb55f132_tn',
                    'is_sales' => 'yes',
                    'is_enable_tax' => 'yes',
                    'tax_percent' => '50',
                    'product_type' => 'single',
                    'sku' => 'SKUQAAHN001',
                    'unit' => 'Cái',
                    'product_image_url' => 'https://cf.shopee.vn/file/7731345aa64bd2c7526f0291bb55f132_tn',
                    'entity' => [
                        [
                            'product_entity_cd' => 'QAAHN001',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQAAHN001',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/7731345aa64bd2c7526f0291bb55f132_tn',
                            'user_id' => null,
                            'old_prices' => 10000,
                            'old_wholesale_prices' => 10000,
                            'old_cost_prices' => 10000,
                            'prices' => 10000,
                            'wholesale_prices' => 10000,
                            'cost_prices' => 10000,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Xanh'
                        ],
                        [
                            'product_entity_cd' => 'QAAHN002',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQAAHN002',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/7731345aa64bd2c7526f0291bb55f132_tn',
                            'user_id' => null,
                            'old_prices' => 10001,
                            'old_wholesale_prices' => 10001,
                            'old_cost_prices' => 10001,
                            'prices' => 10001,
                            'wholesale_prices' => 10001,
                            'cost_prices' => 10001,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Đỏ'
                        ]
                    ]
                ],
                [
                    'product_catalog_id' => 5,
                    'volume_unit_id' => 1,
                    'product_cd' => 'QAACVTD001',
                    'product_name' => 'Áo cổ V tay dài',
                    'product_display_name' => 'Áo cổ V tay dài',
                    'quantity' => 50,
                    'description' => 'Áo cổ V tay dài Siêu Hot',
                    'product_avatar' => 'https://cf.shopee.vn/file/8a84892c04ae36cf58531f00b89a318b_tn',
                    'is_sales' => 'yes',
                    'is_enable_tax' => 'yes',
                    'tax_percent' => '50',
                    'product_type' => 'single',
                    'sku' => 'SKUQAACVTD001',
                    'unit' => 'Cái',
                    'product_image_url' => 'https://cf.shopee.vn/file/8a84892c04ae36cf58531f00b89a318b_tn',
                    'entity' => [
                        [
                            'product_entity_cd' => 'QAACVTD001',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQAACVTD001',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/8a84892c04ae36cf58531f00b89a318b_tn',
                            'user_id' => null,
                            'old_prices' => 10000,
                            'old_wholesale_prices' => 10000,
                            'old_cost_prices' => 10000,
                            'prices' => 10000,
                            'wholesale_prices' => 10000,
                            'cost_prices' => 10000,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Xanh'
                        ],
                        [
                            'product_entity_cd' => 'QAACVTD002',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQAACVTD002',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/8a84892c04ae36cf58531f00b89a318b_tn',
                            'user_id' => null,
                            'old_prices' => 10001,
                            'old_wholesale_prices' => 10001,
                            'old_cost_prices' => 10001,
                            'prices' => 10001,
                            'wholesale_prices' => 10001,
                            'cost_prices' => 10001,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Đỏ'
                        ]
                    ]
                ],
                [
                    'product_catalog_id' => 5,
                    'volume_unit_id' => 1,
                    'product_cd' => 'QAABN001',
                    'product_name' => 'Áo bèo nhún',
                    'product_display_name' => 'Áo bèo nhún',
                    'quantity' => 50,
                    'description' => 'Áo bèo nhún thắt nơ',
                    'product_avatar' => 'https://cf.shopee.vn/file/c6f586fe33a4c12d532f133761339948_tn',
                    'is_sales' => 'yes',
                    'is_enable_tax' => 'yes',
                    'tax_percent' => '50',
                    'product_type' => 'single',
                    'sku' => 'SKUQAABN001',
                    'unit' => 'Cái',
                    'product_image_url' => 'https://cf.shopee.vn/file/c6f586fe33a4c12d532f133761339948_tn',
                    'entity' => [
                        [
                            'product_entity_cd' => 'QAABN001',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQAABN001',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/c6f586fe33a4c12d532f133761339948_tn',
                            'user_id' => null,
                            'old_prices' => 10000,
                            'old_wholesale_prices' => 10000,
                            'old_cost_prices' => 10000,
                            'prices' => 10000,
                            'wholesale_prices' => 10000,
                            'cost_prices' => 10000,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Xanh'
                        ],
                        [
                            'product_entity_cd' => 'QAABN002',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQAABN002',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/c6f586fe33a4c12d532f133761339948_tn',
                            'user_id' => null,
                            'old_prices' => 10001,
                            'old_wholesale_prices' => 10001,
                            'old_cost_prices' => 10001,
                            'prices' => 10001,
                            'wholesale_prices' => 10001,
                            'cost_prices' => 10001,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Đỏ'
                        ]
                    ]
                ],[
                    'product_catalog_id' => 5,
                    'volume_unit_id' => 1,
                    'product_cd' => 'QAABN001',
                    'product_name' => 'Áo bèo nhún',
                    'product_display_name' => 'Áo bèo nhún',
                    'quantity' => 50,
                    'description' => 'Áo bèo nhún thắt nơ',
                    'product_avatar' => 'https://cf.shopee.vn/file/c6f586fe33a4c12d532f133761339948_tn',
                    'is_sales' => 'yes',
                    'is_enable_tax' => 'yes',
                    'tax_percent' => '50',
                    'product_type' => 'single',
                    'sku' => 'SKUQAABN001',
                    'unit' => 'Cái',
                    'product_image_url' => 'https://cf.shopee.vn/file/c6f586fe33a4c12d532f133761339948_tn',
                    'entity' => [
                        [
                            'product_entity_cd' => 'QAABN001',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQAABN001',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/c6f586fe33a4c12d532f133761339948_tn',
                            'user_id' => null,
                            'old_prices' => 10000,
                            'old_wholesale_prices' => 10000,
                            'old_cost_prices' => 10000,
                            'prices' => 10000,
                            'wholesale_prices' => 10000,
                            'cost_prices' => 10000,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Xanh'
                        ],
                        [
                            'product_entity_cd' => 'QAABN002',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQAABN002',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/c6f586fe33a4c12d532f133761339948_tn',
                            'user_id' => null,
                            'old_prices' => 10001,
                            'old_wholesale_prices' => 10001,
                            'old_cost_prices' => 10001,
                            'prices' => 10001,
                            'wholesale_prices' => 10001,
                            'cost_prices' => 10001,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Đỏ'
                        ]
                    ]
                ],
                [
                    'product_catalog_id' => 5,
                    'volume_unit_id' => 1,
                    'product_cd' => 'QAATCT001',
                    'product_name' => 'Áo thu đông cổ tròn',
                    'product_display_name' => 'Áo thu đông cổ tròn',
                    'quantity' => 50,
                    'description' => 'Áo thu đông cổ tròn nữ hàng Quảng Châu',
                    'product_avatar' => 'https://cf.shopee.vn/file/c6f586fe33a4c12d532f133761339948_tn',
                    'is_sales' => 'yes',
                    'is_enable_tax' => 'yes',
                    'tax_percent' => '50',
                    'product_type' => 'single',
                    'sku' => 'SKUQAATCT001',
                    'unit' => 'Cái',
                    'product_image_url' => 'https://cf.shopee.vn/file/c6f586fe33a4c12d532f133761339948_tn',
                    'entity' => [
                        [
                            'product_entity_cd' => 'QAATCT001',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQAATCT001',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/c6f586fe33a4c12d532f133761339948_tn',
                            'user_id' => null,
                            'old_prices' => 10000,
                            'old_wholesale_prices' => 10000,
                            'old_cost_prices' => 10000,
                            'prices' => 10000,
                            'wholesale_prices' => 10000,
                            'cost_prices' => 10000,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Xanh'
                        ],
                        [
                            'product_entity_cd' => 'QAATCT002',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQAATCT002',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/c6f586fe33a4c12d532f133761339948_tn',
                            'user_id' => null,
                            'old_prices' => 10001,
                            'old_wholesale_prices' => 10001,
                            'old_cost_prices' => 10001,
                            'prices' => 10001,
                            'wholesale_prices' => 10001,
                            'cost_prices' => 10001,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Đỏ'
                        ]
                    ]
                ],
                [
                    'product_catalog_id' => 5,
                    'volume_unit_id' => 1,
                    'product_cd' => 'QAANCV001',
                    'product_name' => 'Áo nhung cổ vuông',
                    'product_display_name' => 'Áo nhung cổ vuông',
                    'quantity' => 50,
                    'description' => 'Áo nhung cổ vuông Loại 1 (TQ)',
                    'product_avatar' => 'https://cf.shopee.vn/file/55b6691a5199c758c9d0daf194205e45_tn',
                    'is_sales' => 'yes',
                    'is_enable_tax' => 'yes',
                    'tax_percent' => '50',
                    'product_type' => 'single',
                    'sku' => 'SKUQAANCV001',
                    'unit' => 'Cái',
                    'product_image_url' => 'https://cf.shopee.vn/file/55b6691a5199c758c9d0daf194205e45_tn',
                    'entity' => [
                        [
                            'product_entity_cd' => 'QAANCV001',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQAANCV001',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/55b6691a5199c758c9d0daf194205e45_tn',
                            'user_id' => null,
                            'old_prices' => 10000,
                            'old_wholesale_prices' => 10000,
                            'old_cost_prices' => 10000,
                            'prices' => 10000,
                            'wholesale_prices' => 10000,
                            'cost_prices' => 10000,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Xanh'
                        ],
                        [
                            'product_entity_cd' => 'QAANCV002',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQAANCV002',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/55b6691a5199c758c9d0daf194205e45_tn',
                            'user_id' => null,
                            'old_prices' => 10001,
                            'old_wholesale_prices' => 10001,
                            'old_cost_prices' => 10001,
                            'prices' => 10001,
                            'wholesale_prices' => 10001,
                            'cost_prices' => 10001,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Đỏ'
                        ]
                    ]
                ],[
                    'product_catalog_id' => 5,
                    'volume_unit_id' => 1,
                    'product_cd' => 'QAANCV001',
                    'product_name' => 'Áo nhung cổ vuông',
                    'product_display_name' => 'Áo nhung cổ vuông',
                    'quantity' => 50,
                    'description' => 'Áo nhung cổ vuông Loại 1 (TQ)',
                    'product_avatar' => 'https://cf.shopee.vn/file/55b6691a5199c758c9d0daf194205e45_tn',
                    'is_sales' => 'yes',
                    'is_enable_tax' => 'yes',
                    'tax_percent' => '50',
                    'product_type' => 'single',
                    'sku' => 'SKUQAANCV001',
                    'unit' => 'Cái',
                    'product_image_url' => 'https://cf.shopee.vn/file/55b6691a5199c758c9d0daf194205e45_tn',
                    'entity' => [
                        [
                            'product_entity_cd' => 'QAANCV001',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQAANCV001',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/55b6691a5199c758c9d0daf194205e45_tn',
                            'user_id' => null,
                            'old_prices' => 10000,
                            'old_wholesale_prices' => 10000,
                            'old_cost_prices' => 10000,
                            'prices' => 10000,
                            'wholesale_prices' => 10000,
                            'cost_prices' => 10000,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Xanh'
                        ],
                        [
                            'product_entity_cd' => 'QAANCV002',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQAANCV002',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/55b6691a5199c758c9d0daf194205e45_tn',
                            'user_id' => null,
                            'old_prices' => 10001,
                            'old_wholesale_prices' => 10001,
                            'old_cost_prices' => 10001,
                            'prices' => 10001,
                            'wholesale_prices' => 10001,
                            'cost_prices' => 10001,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Đỏ'
                        ]
                    ]
                ],
                [
                    'product_catalog_id' => 5,
                    'volume_unit_id' => 1,
                    'product_cd' => 'QAATGY001',
                    'product_name' => 'Áo tập gym yoga',
                    'product_display_name' => 'Áo tập gym yoga',
                    'quantity' => 50,
                    'description' => 'Áo tập gym yoga',
                    'product_avatar' => 'https://cf.shopee.vn/file/75eec449839b889e4c6cc6c4bc76b5ee_tn',
                    'is_sales' => 'yes',
                    'is_enable_tax' => 'yes',
                    'tax_percent' => '50',
                    'product_type' => 'single',
                    'sku' => 'SKUQAATGY001',
                    'unit' => 'Cái',
                    'product_image_url' => 'https://cf.shopee.vn/file/75eec449839b889e4c6cc6c4bc76b5ee_tn',
                    'entity' => [
                        [
                            'product_entity_cd' => 'QAATGY001',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQAATGY001',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/75eec449839b889e4c6cc6c4bc76b5ee_tn',
                            'user_id' => null,
                            'old_prices' => 10000,
                            'old_wholesale_prices' => 10000,
                            'old_cost_prices' => 10000,
                            'prices' => 10000,
                            'wholesale_prices' => 10000,
                            'cost_prices' => 10000,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Xanh'
                        ],
                        [
                            'product_entity_cd' => 'QAATGY002',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQAATGY002',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/75eec449839b889e4c6cc6c4bc76b5ee_tn',
                            'user_id' => null,
                            'old_prices' => 10001,
                            'old_wholesale_prices' => 10001,
                            'old_cost_prices' => 10001,
                            'prices' => 10001,
                            'wholesale_prices' => 10001,
                            'cost_prices' => 10001,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Đỏ'
                        ]
                    ]
                ],
                [
                    'product_catalog_id' => 5,
                    'volume_unit_id' => 1,
                    'product_cd' => 'QAATGYTT001',
                    'product_name' => 'Áo tập gym yoga thể thao',
                    'product_display_name' => 'Áo tập gym yoga thể thao',
                    'quantity' => 50,
                    'description' => 'Áo tập gym yoga thể thao',
                    'product_avatar' => 'https://cf.shopee.vn/file/cd51b70014b7cf75dcb867fa3416c567_tn',
                    'is_sales' => 'yes',
                    'is_enable_tax' => 'yes',
                    'tax_percent' => '50',
                    'product_type' => 'single',
                    'sku' => 'SKUQAATGYTT001',
                    'unit' => 'Cái',
                    'product_image_url' => 'https://cf.shopee.vn/file/cd51b70014b7cf75dcb867fa3416c567_tn',
                    'entity' => [
                        [
                            'product_entity_cd' => 'QAATGYTT001',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQAATGYTT001',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/cd51b70014b7cf75dcb867fa3416c567_tn',
                            'user_id' => null,
                            'old_prices' => 10000,
                            'old_wholesale_prices' => 10000,
                            'old_cost_prices' => 10000,
                            'prices' => 10000,
                            'wholesale_prices' => 10000,
                            'cost_prices' => 10000,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Xanh'
                        ],
                        [
                            'product_entity_cd' => 'QAATGYTT002',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQAATGYTT002',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/cd51b70014b7cf75dcb867fa3416c567_tn',
                            'user_id' => null,
                            'old_prices' => 10001,
                            'old_wholesale_prices' => 10001,
                            'old_cost_prices' => 10001,
                            'prices' => 10001,
                            'wholesale_prices' => 10001,
                            'cost_prices' => 10001,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Đỏ'
                        ]
                    ]
                ],
                [
                    'product_catalog_id' => 5,
                    'volume_unit_id' => 1,
                    'product_cd' => 'QAALHV001',
                    'product_name' => 'Áo lụa hở vai',
                    'product_display_name' => 'Áo lụa hở vai',
                    'quantity' => 50,
                    'description' => 'Áo lụa hở vai',
                    'product_avatar' => 'https://cf.shopee.vn/file/a26fd42c5c5fe136064b50c46d33feda_tn',
                    'is_sales' => 'yes',
                    'is_enable_tax' => 'yes',
                    'tax_percent' => '50',
                    'product_type' => 'single',
                    'sku' => 'SKUQQAALHV001',
                    'unit' => 'Cái',
                    'product_image_url' => 'https://cf.shopee.vn/file/a26fd42c5c5fe136064b50c46d33feda_tn',
                    'entity' => [
                        [
                            'product_entity_cd' => 'QAALHV001',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQQAALHV001',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/a26fd42c5c5fe136064b50c46d33feda_tn',
                            'user_id' => null,
                            'old_prices' => 10000,
                            'old_wholesale_prices' => 10000,
                            'old_cost_prices' => 10000,
                            'prices' => 10000,
                            'wholesale_prices' => 10000,
                            'cost_prices' => 10000,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Xanh'
                        ],
                        [
                            'product_entity_cd' => 'QAALHV002',
                            'is_overwrite_prices' => 1,
                            'sku' => 'SKUQQAALHV002',
                            'has_options' => 1,
                            'product_entity_avatar' => 'https://cf.shopee.vn/file/a26fd42c5c5fe136064b50c46d33feda_tn',
                            'user_id' => null,
                            'old_prices' => 10001,
                            'old_wholesale_prices' => 10001,
                            'old_cost_prices' => 10001,
                            'prices' => 10001,
                            'wholesale_prices' => 10001,
                            'cost_prices' => 10001,
                            'apply_started_at' => now(),
                            'apply_ended_at' => now(),
                            'attribute_id' => 1,
                            'float_value' => 'Đỏ'
                        ]
                    ]
                ]
            ];

            foreach ($productData as $item) {
                //ID Tổ chức
                $store_id = rand(1, 10);
                //Sản phẩm đơn
                $product = Product::updateOrCreate(array(
                    'product_catalog_id' => $item['product_catalog_id'],
                    'volume_unit_id' => $item['volume_unit_id'],
                    'product_cd' => $item['product_cd'],
                    'product_name' => $item['product_name'],
                    'product_display_name' => $item['product_display_name'],
                    'quantity' => $item['quantity'],
                    'description' => $item['description'],
                    'product_avatar' => $item['product_avatar'],
                    'is_sales' => $item['is_sales'],
                    'is_enable_tax' => $item['is_enable_tax'],
                    'tax_percent' => $item['tax_percent'],
                    'product_type' => $item['product_type'],
                    'sku' => $item['sku'],
                    'unit' => $item['unit'],
                    'minimum_inventory' => 1
                ));

                //Sản phẩm combo
                $productCombo = Product::updateOrCreate(array(
                    'product_catalog_id' => $item['product_catalog_id'],
                    'volume_unit_id' => $item['volume_unit_id'],
                    'product_cd' => $item['product_cd'],
                    'product_name' => $item['product_name'],
                    'product_display_name' => $item['product_display_name'],
                    'quantity' => $item['quantity'],
                    'description' => $item['description'],
                    'product_avatar' => $item['product_avatar'],
                    'is_sales' => $item['is_sales'],
                    'is_enable_tax' => $item['is_enable_tax'],
                    'tax_percent' => $item['tax_percent'],
                    'product_type' => 'combo',
                    'sku' => $item['sku'],
                    'unit' => $item['unit'],
                    'minimum_inventory' => 1
                ));

                //Provider Sản phẩm
                ProductProvider::updateOrCreate(array(
                    'product_id' => $product->id,
                    'provider_id' => rand(1, 10)
                ));
                ProductProvider::updateOrCreate(array(
                    'product_id' => $productCombo->id,
                    'provider_id' => rand(1, 10)
                ));

                //Sản phẩm Entity combo
                $productEntityCombo = ProductEntity::updateOrCreate(array(
                    'product_id' => $productCombo->id,
                    'product_entity_cd' => $item['product_cd'],
                    'is_overwrite_prices' => 0,
                    'sku' => $item['sku'],
                    'has_options' => 0,
                    'product_entity_avatar' => $item['product_avatar'],
                    'is_show' => 1,
                    'minimum_inventory' => 1
                ));
                ProductEntityPrice::updateOrCreate(array(
                    'product_entity_id' => $productEntityCombo->id,
                    'user_id' => 1,
                    'old_prices' => 10000,
                    'old_wholesale_prices' => 10000,
                    'old_cost_prices' => 10000,
                    'prices' => 10000,
                    'wholesale_prices' => 10000,
                    'cost_prices' => 10000,
                    'apply_started_at' => now(),
                    'apply_ended_at' => now()
                ));

                //Chuẩn hóa sản phẩm đơn
                $retailProduct = RetailProduct::updateOrCreate(array(
                    'store_id' => $store_id,
                    'product_id' => $product->id,
                    'product_catalog_id' => $item['product_catalog_id'],
                    'volume_unit_id' => $item['volume_unit_id'],
                    'product_cd' => $item['product_cd'],
                    'product_name' => $item['product_name'],
                    'product_display_name' => $item['product_display_name'],
                    'quantity' => $item['quantity'],
                    'description' => $item['description'],
                    'product_avatar' => $item['product_avatar'],
                    'is_sales' => $item['is_sales'],
                    'is_enable_tax' => $item['is_enable_tax'],
                    'tax_percent' => $item['tax_percent'],
                    'product_type' => 'combo',
                    'sku' => $item['sku'],
                    'unit' => $item['unit'],
                    'minimum_inventory' => 1
                ));

                ProductGallery::updateOrCreate(array(
                    'product_id' => $product->id,
                    'product_image_url' => $item['product_image_url']
                ));

                RetailProductGallery::updateOrCreate(array(
                    'product_id' => $product->id,
                    'product_image_url' => $item['product_image_url']
                ));

                foreach ($item['entity'] as $entity) {
                    //Sản phẩm Entity đơn
                    $productEntity = ProductEntity::updateOrCreate(array(
                        'product_id' => $product->id,
                        'product_entity_cd' => $entity['product_entity_cd'],
                        'is_overwrite_prices' => $entity['is_overwrite_prices'],
                        'sku' => $entity['sku'],
                        'has_options' => $entity['has_options'],
                        'product_entity_avatar' => $entity['product_entity_avatar'],
                        'is_show' => 1,
                        'minimum_inventory' => 1
                    ));

                    ProductEntityPrice::updateOrCreate(array(
                        'product_entity_id' => $productEntity->id,
                        'user_id' => $entity['user_id'],
                        'old_prices' => $entity['old_prices'],
                        'old_wholesale_prices' => $entity['old_wholesale_prices'],
                        'old_cost_prices' => $entity['old_cost_prices'],
                        'prices' => $entity['prices'],
                        'wholesale_prices' => $entity['wholesale_prices'],
                        'cost_prices' => $entity['cost_prices'],
                        'apply_started_at' => $entity['apply_started_at'],
                        'apply_ended_at' => $entity['apply_ended_at']
                    ));

                    ProductEntityAttributeFloat::updateOrCreate(array(
                        'product_entity_id' => $productEntity->id,
                        'attribute_id' => 1,
                        'float_value' => 1000
                    ));

                    //Sản phẩm combo
                    Combo::updateOrCreate(array(
                        'product_id' => $productCombo->id,
                        'related_product_id' => $productEntity->id,
                        'quantity' => 2,
                        'prices' => 10000,
                    ));

                    //Chuẩn hóa sản phẩm Entity đơn
                    $retailProductEntity = RetailProductEntity::updateOrCreate(array(
                        'store_id' => $store_id,
                        'product_entity_id' => $productEntity->id,
                        'is_overwrite_prices' => $entity['is_overwrite_prices'],
                        'sku' => $entity['sku'],
                        'has_options' => $entity['has_options'],
                        'product_entity_avatar' => $entity['product_entity_avatar'],
                        'is_show' => 1,
                        'product_id' => $retailProduct->id,
                        'minimum_inventory' => 1
                    ));

                    RetailProductEntityPrice::updateOrCreate(array(
                        'product_entity_id' => $retailProductEntity->id,
                        'user_id' => 2,
                        'old_prices' => $entity['old_prices'],
                        'old_wholesale_prices' => $entity['old_wholesale_prices'],
                        'old_cost_prices' => $entity['old_cost_prices'],
                        'prices' => $entity['prices'],
                        'wholesale_prices' => $entity['wholesale_prices'],
                        'cost_prices' => $entity['cost_prices'],
                        'apply_started_at' => $entity['apply_started_at'],
                        'apply_ended_at' => $entity['apply_ended_at']
                    ));
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
