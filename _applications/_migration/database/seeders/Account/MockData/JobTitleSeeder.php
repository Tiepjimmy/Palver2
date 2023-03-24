<?php

namespace Database\Seeders\Account\MockData;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use AccountSdkDb\Modules\Store\Models\JobTitle;

class JobTitleSeeder extends Seeder
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
            $listJobTitle = [
                [
                    'job_title_name' => 'Giám đốc',
                    'job_title_type' => 'manager',
                    'active_status' => 'active',
                ],
                [
                    'job_title_name' => 'Nhân viên sale',
                    'job_title_type' => 'staff',
                    'active_status' => 'active',
                ],
                [
                    'job_title_name' => 'Bảo vệ',
                    'job_title_type' => 'other',
                    'active_status' => 'active',
                ],
            ];
            for ($storeId = 1; $storeId <= 10; $storeId++) {
                foreach ($listJobTitle as $jobTitle) {
                    JobTitle::updateOrCreate(array(
                        'store_id' => $storeId,
                        'job_title_name' => $jobTitle['job_title_name'] . ' chi nhánh ' . $storeId,
                        'job_title_type' => $jobTitle['job_title_type'],
                        'active_status' => $jobTitle['active_status'],
                    ));
                }
            }
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            throw $error;
        }
    }
}
