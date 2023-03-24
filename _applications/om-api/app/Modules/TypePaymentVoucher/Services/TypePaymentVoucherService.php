<?php

namespace App\Modules\TypePaymentVoucher\Services;

use Common\Exceptions\PalException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use OmSdk\Exceptions\PalValidationException;
use OmSdk\Modules\PaymentVoucher\Repositories\Eloquent\PaymentVoucherRepository;
use OmSdk\Modules\TypePaymentVoucher\Repositories\Eloquent\TypePaymentVoucherRepository;

class TypePaymentVoucherService
{
    protected $typePaymentVoucherRepository;
    protected $paymentVoucherRepository;
    public function __construct(
        TypePaymentVoucherRepository $typePaymentVoucherRepository,
        PaymentVoucherRepository $paymentVoucherRepository
    )
    {
        $this->typePaymentVoucherRepository = $typePaymentVoucherRepository;
        $this->paymentVoucherRepository = $paymentVoucherRepository;
    }

    /**
     * Lấy danh sách loại chứng từ chi
     *
     * @param mixed $conditions
     * @return mixed
     */
    public function search($perPage)
    {
        $paymentVoucher = null;
        $paymentVoucher = $this->typePaymentVoucherRepository->customPaginate([],[],$perPage);
        if(is_null($paymentVoucher)){
            throw new PalException('E000001');
        }
        return $paymentVoucher;
    }

    /**
     * Service create paymentAccount
     * @param mixed $data
     * @return mixed
     */
    public function store($data)
    {
        $connectedDb = $this->typePaymentVoucherRepository->getConnection();
        $validator = Validator::make($data,
            ['type_code' => "unique:{$connectedDb}.om_type_payment_vouchers,type_code"],
            [
                'type_code.unique' => 'Trường mã loại chứng từ chi đã tồn tại',
            ]
        );
        if ($validator->fails()) {
            throw new PalValidationException($validator,'','',422);
        }
        $store = null;
        $store = $this->typePaymentVoucherRepository->create($data);
        if(is_null($store)){
            throw new PalException('E000001');
        }
        return $store;
    }

    /**
     * Lấy thông tin chi tiết
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        $connectedDb = $this->typePaymentVoucherRepository->getConnection();
        $validators = Validator::make(
            [
                'id' => $id
            ],
            [
                'id' => "required|exists:{$connectedDb}.om_type_payment_vouchers,id",
            ]
        );
        if ($validators->fails()) {
            throw new PalValidationException($validators,'','',422);
        }
        $paymentVoucher = $this->typePaymentVoucherRepository->getById($id);
        if (empty($paymentVoucher)) {
            throw new PalException('E000001');
        }
        return $paymentVoucher;
    }

    /**
     * @param mixed $data
     * @param mixed $id
     * @return mixed
     */
    public function update($data, $id)
    {

        $connectedDb = $this->typePaymentVoucherRepository->getConnection();
        $validators = Validator::make(
            [
                'id' => $id
            ],
            [
                'id' => "required|exists:{$connectedDb}.om_type_payment_vouchers,id",
            ]
        );
        if ($validators->fails()) {
            throw new PalValidationException($validators,'','',422);
        }
        if (isset($data['is_active']) && $data['is_active'] == 0 ) {
            $checkCode = null;
            $paramtypePaymentVoucher = [
                'type_payment_voucher_id' => $id
            ];
            $checkCode = $this->paymentVoucherRepository->getOne($paramtypePaymentVoucher);
            if (!is_null($checkCode)) {
                throw new PalException('OMP0007',$data['type_code'] .' '.$data['type_name']. ' đã được sử dụng. Bạn không thể thực hiện chức năng này');
            }
        }
        $update = null;
        $update = $this->typePaymentVoucherRepository->updateById($id,$data);
        if (is_null($update)) {
            throw new PalException('E000001');
        }
        return $update;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $connectedDb = $this->typePaymentVoucherRepository->getConnection();
        $validators = Validator::make(
            [
                'id' => $id
            ],
            [
                'id' => "required|exists:{$connectedDb}.om_type_payment_vouchers,id",
            ]
        );
        if ($validators->fails()) {
            throw new PalValidationException($validators,'','',422);
        }
        $param = [
            'id' => $id
        ];
        $typePaymentVoucher = null;
        $checkCode = null;
        $typePaymentVoucher = $this->typePaymentVoucherRepository->getById($id);
        $paymentVoucher = [
            'type_payment_voucher_id' => $typePaymentVoucher->id
        ];
        $checkCode = $this->paymentVoucherRepository->getOne($paymentVoucher);
        if (!is_null($checkCode)) {
            throw new PalException('OMP0007',$typePaymentVoucher->type_code .' '.$typePaymentVoucher->type_name. ' đã được sử dụng. Bạn không thể thực hiện chức năng này');
        }
        $destroyId =  $this->typePaymentVoucherRepository->delByCond($param);
        return $destroyId;
    }
}