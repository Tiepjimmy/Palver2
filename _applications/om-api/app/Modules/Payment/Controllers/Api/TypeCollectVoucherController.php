<?php

namespace App\Modules\Payment\Controllers\Api;

use Illuminate\Http\Request;
use Common\Http\Controllers\Api\AbstractApiController;
use App\Modules\Payment\Requests\TypeCollectVoucherStoreRequest;
use App\Modules\Payment\Requests\TypeCollectVoucherUpdateRequest;
use App\Modules\Payment\Services\TypeCollectVoucherService;
use App\Modules\Payment\Resources\TypeCollectVoucherResource;
use App\Modules\Payment\Resources\TypeCollectVoucherListResource;

/**
 * Class TypeCollectVoucherController
 * @package App\Modules\Payment\Controllers\Api
 */
class TypeCollectVoucherController extends AbstractApiController
{
    protected $typeCollectVoucherService;

    public function __construct(TypeCollectVoucherService $typeCollectVoucherService)
    {
        parent::__construct();

        $this->typeCollectVoucherService = $typeCollectVoucherService;
    }

    /**
     * Lấy danh sách loại chứng từ thu
     * @param Request $request
     * @return mixed
     * @throws \Common\Exceptions\PalException
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page') ? (int)$request->input('per_page') : 10;

        $listTypeCollectVoucher = $this->typeCollectVoucherService->getList($perPage);

        return $this->_responseSuccess('Xử lý thành công', new TypeCollectVoucherListResource($listTypeCollectVoucher));
    }

    /**
     * Lưu thông tin tạo mới loại chứng từ thu
     * @param TypeCollectVoucherStoreRequest $request
     * @return mixed
     * @throws \Common\Exceptions\PalException
     */
    public function store(TypeCollectVoucherStoreRequest $request)
    {
        if (!$request->filled('is_active')) {
            $request->merge(array(
                'is_active' => 1
            ));
        }

        if (!$request->filled('is_business_result')) {
            $request->merge(array(
                'is_business_result' => 0
            ));
        }

        $payload = $request->only(array(
            'type_code',
            'type_name',
            'note',
            'is_active',
            'is_business_result',
        ));

        $storedTypeCollectVoucher = $this->typeCollectVoucherService->store($payload);

        return $this->_responseSuccess('Xử lý thành công', new TypeCollectVoucherResource($storedTypeCollectVoucher));

    }

    /**
     * Lấy thông tin chi tiết loại chứng từ thu
     * @param numeric $id
     * @return mixed
     * @throws \Common\Exceptions\PalException
     * @throws \Common\Exceptions\PalValidationException
     */
    public function edit($id)
    {
        $detailTypeCollectVoucher = $this->typeCollectVoucherService->getDetail($id);

        return $this->_responseSuccess('Xử lý thành công', new TypeCollectVoucherResource($detailTypeCollectVoucher));
    }

    /**
     * Lưu thông tin cập nhập loại chứng từ thu
     * @param TypeCollectVoucherUpdateRequest $request
     * @param numeric $typeCollectVoucherId
     * @return mixed
     * @throws \Common\Exceptions\PalException
     * @throws \Common\Exceptions\PalValidationException
     */
    public function update(TypeCollectVoucherUpdateRequest $request, $typeCollectVoucherId)
    {
        $payload = $request->only(array(
            'type_code',
            'type_name',
            'note',
            'is_active',
            'is_business_result',
        ));

        $updatedTypeCollectVoucher = $this->typeCollectVoucherService->update($payload, $typeCollectVoucherId);

        return $this->_responseSuccess( 'Xử lý thành công', new TypeCollectVoucherResource($updatedTypeCollectVoucher));
    }

    /**
     * Xóa loại chứng từ thu
     * @param numeric $id
     * @return mixed
     * @throws \Common\Exceptions\PalException
     * @throws \Common\Exceptions\PalValidationException
     */
    public function destroy($id)
    {
        $destroyedTypeCollectVoucher = $this->typeCollectVoucherService->destroy($id);

        return $this->_responseSuccess('Xử lý thành công', $destroyedTypeCollectVoucher);
    }

}