<?php

namespace Database\Seeders\Om;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use OmSdk\Modules\Order\Models\OrderPaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    public function run()
    {
        DB::beginTransaction();
        try {
            $listPaymentMethod = [
                [
                    'store_id' => 1,
                    'name' => 'Tiền mặt',
                    'information' => 'Tiền mặt',
                    'created_by' => 1,
                    'type_voucher' => 'tien_mat'
                ],
                [
                    'store_id' => 1,
                    'name' => 'Quẹt thẻ',
                    'information' => 'Quẹt thẻ',
                    'created_by' => 1,
                    'type_voucher' => 'so_phu_ngan_hang'
                ],
                [
                    'store_id' => 1,
                    'name' => 'Chuyển khoản',
                    'information' => 'Chuyển khoản',
                    'created_by' => 1,
                    'type_voucher' => 'so_phu_ngan_hang'
                ],
                [
                    'store_id' => 1,
                    'name' => 'COD',
                    'information' => 'COD',
                    'created_by' => 1,
                    'type_voucher' => 'so_phu_ngan_hang'
                ],
                [
                    'store_id' => 1,
                    'name' => 'Ví E-commerce',
                    'information' => 'Ví E-commerce',
                    'created_by' => 1,
                    'type_voucher' => 'so_phu_ngan_hang'
                ]
            ];
            foreach ($listPaymentMethod as $paymentMethod) {
                OrderPaymentMethod::updateOrCreate(array(
                    'store_id' => $paymentMethod['store_id'],
                    'name' => $paymentMethod['name'],
                    'information' => $paymentMethod['information'],
                    'created_by' => $paymentMethod['created_by'],
                    'type_voucher' => $paymentMethod['type_voucher']
                ));
            }
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            throw $error;
        }
    }
}
