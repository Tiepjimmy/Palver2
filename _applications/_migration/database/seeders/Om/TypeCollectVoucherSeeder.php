<?php

namespace Database\Seeders\Om;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use OmSdk\Modules\Payment\Models\TypeCollectVoucher;

class TypeCollectVoucherSeeder extends Seeder
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
            $listTypeCollectVoucher = [
                [
                    'type_code' => 'TDT',
                    'type_name' => 'Tự động',
                    'is_active' => 1,
                    'is_business_result' => 1,
                    'note' => 'Tự động thu',
                ]
            ];
            foreach ($listTypeCollectVoucher as $typeCollectVoucher) {
                TypeCollectVoucher::updateOrCreate(array(
                    'type_code' => $typeCollectVoucher['type_code'],
                    'type_name' => $typeCollectVoucher['type_name'],
                    'is_active' => $typeCollectVoucher['is_active'],
                    'is_business_result' => $typeCollectVoucher['is_business_result'],
                    'note' => $typeCollectVoucher['note'],
                ));
            }
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            throw $error;
        }
    }
}
