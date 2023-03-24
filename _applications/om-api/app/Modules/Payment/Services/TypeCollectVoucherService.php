<?php

namespace App\Modules\Payment\Services;

use Illuminate\Support\Facades\Validator;
use Common\Exceptions\PalException;
use Common\Exceptions\PalValidationException;
use OmSdk\Modules\Payment\Repositories\Contracts\ITypeCollectVoucherRepository;

/**
 * Class TypeCollectVoucherService
 * @package App\Modules\Payment\Services
 */
class TypeCollectVoucherService
{
    protected $typeCollectVoucherRepository;

    /**
     * TypeCollectVoucherService constructor.
     * @param ITypeCollectVoucherRepository $typeCollectVoucherRepository
     */
    public function __construct(
        ITypeCollectVoucherRepository $typeCollectVoucherRepository
    )
    {
        $this->typeCollectVoucherRepository = $typeCollectVoucherRepository;
    }

    /**
     * Lấy danh sách loại chứng từ thu
     * @param numeric $perPage
     * @return mixed
     * @throws PalException
     */
    public function getList($perPage)
    {
        $listTypeCollectVoucher = null;
        $listTypeCollectVoucher = $this->typeCollectVoucherRepository->customPaginate(
            array(),
            array(),
            $perPage
        );

        if (is_null($listTypeCollectVoucher)) {
            throw new PalException('E000001');
        }

        return $listTypeCollectVoucher;
    }

    /**
     * Lưu thông tin tạo mới loại chứng từ thu
     * @param mixed $request
     * @return mixed
     * @throws PalException
     */
    public function store($request)
    {
        $connectedDb = $this->typeCollectVoucherRepository->getConnection();
        $validators = Validator::make($request,
            array(
                'type_code' => "unique:{$connectedDb}.om_type_collect_vouchers,type_code",
                'type_name' => "unique:{$connectedDb}.om_type_collect_vouchers,type_name",
            ),
            array(
                'type_code.unique' => 'Trường mã loại chứng từ thu đã tồn tại',
                'type_name.unique' => 'Trường tên loại chứng từ thu đã tồn tại',
            )
        );

        if ($validators->fails()) {
            throw new PalValidationException($validators);
        }

        $storedTypeCollectVoucher = null;
        $storedTypeCollectVoucher = $this->typeCollectVoucherRepository->create(array(
            'type_code' => $request['type_code'],
            'type_name' => $request['type_name'],
            'note' => $request['note'] ?? '',
            'is_active' => $request['is_active'],
            'is_business_result' => $request['is_business_result'],
        ));

        if (is_null($storedTypeCollectVoucher)) {
            throw new PalException('E000001');
        }

        return $storedTypeCollectVoucher;
    }

    /**
     * Lấy thông tin chi tiết loại chứng từ thu
     * @param numeric $id
     * @return mixed
     * @throws PalException
     * @throws PalValidationException
     */
    public function getDetail($id)
    {
        $connectedDb = $this->typeCollectVoucherRepository->getConnection();
        $validators = Validator::make(array(
            'id' => $id
        ), array(
            'id' => "required|exists:{$connectedDb}.om_type_collect_vouchers,id",
        ));

        if ($validators->fails()) {
            throw new PalValidationException($validators);
        }

        $TypeCollectVoucher = null;
        $TypeCollectVoucher = $this->typeCollectVoucherRepository->getById($id);

        if (is_null($TypeCollectVoucher)) {
            throw new PalException('E000001');
        }

        return $TypeCollectVoucher;
    }

    /**
     * Lưu thông tin cập nhập loại chứng từ thu
     * @param mixed $request
     * @param numeric $id
     * @return mixed
     * @throws PalException
     * @throws PalValidationException
     */
    public function update($request, $id)
    {
        $connectedDb = $this->typeCollectVoucherRepository->getConnection();
        $validators = Validator::make(array_merge($request,
            array('id' => $id)),
            array(
                'id' => "required|exists:{$connectedDb}.om_type_collect_vouchers,id",
                'type_code' => "unique:{$connectedDb}.om_type_collect_vouchers,type_code,{$id}",
                'type_name' => "unique:{$connectedDb}.om_type_collect_vouchers,type_name,{$id}",
            ),
            array(
                'type_code.unique' => 'Trường mã loại chứng từ thu đã tồn tại',
                'type_name.unique' => 'Trường tên loại chứng từ thu đã tồn tại',
            )
        );

        if ($validators->fails()) {
            throw new PalValidationException($validators);
        }

        $updatedTypeCollectVoucher = null;
        $updatedTypeCollectVoucher = $this->typeCollectVoucherRepository->updateById($id, array(
            'type_code' => $request['type_code'],
            'type_name' => $request['type_name'],
            'note' => $request['note'] ?? '',
            'is_active' => $request['is_active'],
            'is_business_result' => $request['is_business_result'],
        ));

        if (is_null($updatedTypeCollectVoucher)) {
            throw new PalException('E000001');
        }

        return $updatedTypeCollectVoucher;
    }

    /**
     * Xóa loại chứng từ thu
     * @param numeric $id
     * @return mixed
     * @throws PalException
     * @throws PalValidationException
     */
    public function destroy($id)
    {
        $connectedDb = $this->typeCollectVoucherRepository->getConnection();
        $validators = Validator::make(array(
            'id' => $id
        ), array(
            'id' => "required|exists:{$connectedDb}.om_type_collect_vouchers,id",
        ));

        if ($validators->fails()) {
            throw new PalValidationException($validators);
        }

        $destroyedTypeCollectVoucher = null;
        $destroyedTypeCollectVoucher = $this->typeCollectVoucherRepository->delByCond(array(
            'id' => $id
        ));

        if (is_null($destroyedTypeCollectVoucher)) {
            throw new PalException('E000001');
        }

        return $destroyedTypeCollectVoucher;
    }

}