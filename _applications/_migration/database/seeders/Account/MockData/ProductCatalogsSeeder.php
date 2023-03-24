<?php

namespace Database\Seeders\Account\MockData;

use AccountSdkDb\Modules\Product\Models\StoreProductCatalog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use AccountSdkDb\Modules\Product\Models\ProductCatalog;
use AccountSdkDb\Modules\Product\Models\ProductCatalogAttributeGroup;

class ProductCatalogsSeeder extends Seeder
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
            $catalogs = [
                [
                    'parent_id'=>null,
                    'product_catalog_cd'=>'',
                    'product_catalog_name'=>'Nước hoa',
                    'note'=>'Nước hoa cao cấp',
                    'product_cd_prefix'=>'pal001',
                    'active_status'=>'active',
                ],
                [
                    'parent_id'=>1,
                    'product_catalog_cd'=>'',
                    'product_catalog_name'=>'Nước hoa loại 1',
                    'note'=>'Nước hoa mùi hoa hồng',
                    'product_cd_prefix'=>'pal002',
                    'active_status'=>'active',
                ],
                [
                    'parent_id'=>2,
                    'product_catalog_cd'=>'',
                    'product_catalog_name'=>'Chi nhánh nước hoa loại 1',
                    'note'=>'Chi nhánh Hà nội Nước hoa mùi hoa hồng',
                    'product_cd_prefix'=>'pal004',
                    'active_status'=>'active',
                ],
                [
                    'parent_id'=>1,
                    'product_catalog_cd'=>'',
                    'product_catalog_name'=>'Nước hoa loại 2',
                    'note'=>'Nước hoa mùi hoa cúc',
                    'product_cd_prefix'=>'pal003',
                    'active_status'=>'active',
                ],

                [
                    'parent_id'=>null,
                    'product_catalog_cd'=>'',
                    'product_catalog_name'=>'Quần áo',
                    'note'=>'Quần áo make in Việt nam',
                    'product_cd_prefix'=>'vn001',
                    'active_status'=>'active',
                ],
                [
                    'parent_id'=>5,
                    'product_catalog_cd'=>'',
                    'product_catalog_name'=>'Quần',
                    'note'=>'Nước hoa mùi hoa hồng',
                    'product_cd_prefix'=>'vn002',
                    'active_status'=>'active',
                ],
                [
                    'parent_id'=>6,
                    'product_catalog_cd'=>'',
                    'product_catalog_name'=>'Quần bò',
                    'note'=>'Quần bò cao cấp',
                    'product_cd_prefix'=>'vn003',
                    'active_status'=>'active',
                ],
                [
                    'parent_id'=>5,
                    'product_catalog_cd'=>'',
                    'product_catalog_name'=>'Áo',
                    'note'=>'Áo cao cấp',
                    'product_cd_prefix'=>'vn004',
                    'active_status'=>'active',
                ],
                [
                    'parent_id'=>8,
                    'product_catalog_cd'=>'',
                    'product_catalog_name'=>'Áo Sơ mi',
                    'note'=>'Áo sơ mi',
                    'product_cd_prefix'=>'vn004',
                    'active_status'=>'active',
                ],

            ];
            $i = 0;
            foreach ($catalogs as $value) {
                $catalog = ProductCatalog::updateOrCreate(array(
                    'parent_id' => $value['parent_id'],
                    'product_catalog_cd' => $value['product_catalog_cd'],
                    'product_catalog_name' => $value['product_catalog_name'],
                    'note' => $value['note'],
                    'product_cd_prefix' => $value['product_cd_prefix'],
                    'active_status' => $value['active_status'],

                ));
                if (!empty($catalog)) {
                    StoreProductCatalog::updateOrCreate(array(
                        'store_id' => ++$i,
                        'product_catalog_id' => $catalog->id
                    ));
                }
            }
            $listProductCatalogAttributeGroup = [
                [
                    'product_catalog_id' => 5,
                    'attribute_group_id' => 1,
                ],
                [
                    'product_catalog_id' => 6,
                    'attribute_group_id' => 1,
                ],
                [
                    'product_catalog_id' => 7,
                    'attribute_group_id' => 1,
                ],
                [
                    'product_catalog_id' => 8,
                    'attribute_group_id' => 1,
                ],
                [
                    'product_catalog_id' => 9,
                    'attribute_group_id' => 1,
                ]
            ];
            foreach ($listProductCatalogAttributeGroup as $productCatalogAttributeGroup) {
                ProductCatalogAttributeGroup::updateOrCreate(array(
                    'product_catalog_id' => $productCatalogAttributeGroup['product_catalog_id'],
                    'attribute_group_id' => $productCatalogAttributeGroup['attribute_group_id']
                ));
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
