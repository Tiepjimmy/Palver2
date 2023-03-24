<?php

namespace Database\Seeders\Account\MasterData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use AccountSdkDb\Modules\Master\Models\AttributeType;

class AttributeTypeSeeder extends Seeder
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
            $attributeTypeData = array(
                array(
                    'attribute_name' => 'droplist',
                    'attribute_cd' => 'droplist',
                ),
                array(
                    'attribute_name' => 'date',
                    'attribute_cd' => 'date',
                ),
                array(
                    'attribute_name' => 'text',
                    'attribute_cd' => 'text',
                ),
                array(
                    'attribute_name' => 'number',
                    'attribute_cd' => 'number',
                ),
            );
            foreach ($attributeTypeData as $attributeType) {
                AttributeType::updateOrCreate(array(
                    'attribute_name' => $attributeType['attribute_name'],
                    'attribute_cd' => $attributeType['attribute_cd']
                ));
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
