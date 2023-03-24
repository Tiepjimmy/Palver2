<?php

namespace App\Modules\TypePaymentVoucher\Controllers\Api;

use App\Modules\TypePaymentVoucher\Resources\ListTypePaymentVoucherResource;
use App\Modules\TypePaymentVoucher\Requests\TypePaymentVoucherStoreRequest;
use App\Modules\TypePaymentVoucher\Requests\TypePaymentVoucherUpdateRequest;
use App\Modules\TypePaymentVoucher\Resources\TypePaymentVoucherResource;
use App\Modules\TypePaymentVoucher\Services\TypePaymentVoucherService;
use Common\Http\Controllers\Api\AbstractApiController;
use Illuminate\Http\Request;

class TypePaymentVoucherController extends AbstractApiController
{
    protected $typePaymentVoucherService;

    /**
     * @param TypePaymentVoucherService $campaignService
     */
    public function __construct(TypePaymentVoucherService $typePaymentVoucherService)
    {
        parent::__construct();

        $this->typePaymentVoucherService = $typePaymentVoucherService;
    }

    /**Lấy danh sách loại chứng từ chi
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page') ? (int)$request->input('per_page') : 10;
        $data = $this->typePaymentVoucherService->search($perPage);
        return $this->_responseSuccess('Xử lý thành công',new ListTypePaymentVoucherResource($data));
    }
    /**
     * Chi tiết loại chứng từ chi
     *  @param mixed $id
     * @return mixed
     */
    public function show($id)
    {
        $paymentVoucherStore = $this->typePaymentVoucherService->get($id);
        return $this->_responseSuccess('Xử lý thành công',new TypePaymentVoucherResource($paymentVoucherStore));
    }

    /**
     *Tạo mới loại chứng từ chi
     *
     * @param TypePaymentVoucherStoreRequest $request
     * @return mixed
     */
    public function store(TypePaymentVoucherStoreRequest $request)
    {
        $data = $request->only([
            'type_code',
            'type_name',
            'is_business_result',
            'note',
        ]);
        $paymentVoucherStore = $this->typePaymentVoucherService->store($data);
        return $this->_responseSuccess('Khởi tạo bản ghi thành công',new TypePaymentVoucherResource($paymentVoucherStore),201);
    }

    /**Update loại chứng từ chi
     *
     * @param TypePaymentVoucherUpdateRequest $request
     * @param  mixed $id
     * @return mixed
     */
    public function update(TypePaymentVoucherUpdateRequest $request, $id)
    {
        $data = $request->only([
            'type_code',
            'type_name',
            'is_business_result',
            'is_active',
            'note',
        ]);
        $paymentVoucherUpdate = $this->typePaymentVoucherService->update($data, $id);
        return $this->_responseSuccess('Cập nhật bản ghi thành công',new TypePaymentVoucherResource($paymentVoucherUpdate),201);
    }

    /***
     * Xóa loại chứng từ chi
     *
     * @param mixed $id
     * @return mixed
     */
    public function destroy($id)
    {
        $paymentVoucherdestroy = $this->typePaymentVoucherService->destroy($id);
        return $this->_responseSuccess('Xóa bản ghi thành công',$paymentVoucherdestroy,201);
    }

}