<?php

namespace App\Modules\PaymentVoucher\Controllers\Api;

use App\Modules\PaymentVoucher\Requests\PaymentVoucherStoreRequest;
use App\Modules\PaymentVoucher\Requests\PaymentVoucherUpdateRequest;
use App\Modules\PaymentVoucher\Resources\CreatePaymentVoucherResource;
use App\Modules\PaymentVoucher\Resources\ListPaymentVoucherResource;
use App\Modules\PaymentVoucher\Resources\OrderResource;
use App\Modules\PaymentVoucher\Resources\PaymentVoucherResource;
use App\Modules\PaymentVoucher\Services\PaymentVoucherService;
use Common\Http\Controllers\Api\AbstractApiController;
use Illuminate\Http\Request;

class PaymentVoucherController extends AbstractApiController
{
    protected $paymentVoucherService;

    /**
     * @param PaymentVoucherService $campaignService
     */
    public function __construct(PaymentVoucherService $paymentVoucherService)
    {
        parent::__construct();

        $this->paymentVoucherService = $paymentVoucherService;
    }

    /**Lấy danh sách chứng từ chi
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $data['per_page'] = $request->input('per_page') ? (int)$request->input('per_page') : 10;
        $paymentVoucher = $this->paymentVoucherService->search($data);
        return $this->_responseSuccess('Xử lý thành công',new ListPaymentVoucherResource($paymentVoucher));
    }

    /**
     * Chi tiết  chứng từ chi
     *  @param mixed $id
     * @return mixed
     */
    public function show($id)
    {
        $paymentVoucherStore = $this->paymentVoucherService->get($id);
        return $this->_responseSuccess('Xử lý thành công',new PaymentVoucherResource($paymentVoucherStore));
    }

    /**
     * Các thông tin liên quan đến chứng từ chi
     *  @param mixed $id
     * @return mixed
     */
    public function create()
    {
        $paymentVoucherStore = $this->paymentVoucherService->create();
        return $this->_responseSuccess('Xử lý thành công',new CreatePaymentVoucherResource($paymentVoucherStore));
    }

    /**
     *Tạo mới chứng từ chi
     *
     * @param Request $request
     * @return mixed
     */
    public function store(PaymentVoucherStoreRequest $request)
    {
        $data = $request->only([
            'store_id',
            'type_voucher',
            'type_payment_voucher_id',
            'customer_group_id',
            'amount',
            'payment_id',
            'confirmed_at',
            'is_business_result',
            'note',
            'description',
            'customer_id',
        ]);
        $paymentVoucherStore = $this->paymentVoucherService->store($data);
        return $this->_responseSuccess('Khởi tạo bản ghi thành công',new PaymentVoucherResource($paymentVoucherStore),201);
    }

    /**Update chứng từ chi
     *
     * @param Request $request
     * @param  mixed $id
     * @return mixed
     */
    public function update(PaymentVoucherUpdateRequest $request, $id)
    {
        $data = $request->only([
            'store_id',
            'type_voucher',
            'type_payment_voucher_id',
            'customer_group_id',
            'amount',
            'payment_id',
            'confirmed_at',
            'is_business_result',
            'note',
            'description',
            'customer_id',
        ]);
        $paymentVoucherUpdate = $this->paymentVoucherService->update($data, $id);
        return $this->_responseSuccess('Cập nhật bản ghi thành công',new PaymentVoucherResource($paymentVoucherUpdate),201);
    }

    /***
     * Hủy trạng thái chứng từ chi
     *
     * @param mixed $id
     * @return mixed
     */
    public function cancelStatus($id)
    {
        $paymentVoucherdestroy = $this->paymentVoucherService->cancelStatus($id);
        return $this->_responseSuccess('Hủy trạng thái thành công',$paymentVoucherdestroy,201);
    }

    /***
     * Lấy danh sách đơn hàng theo id loại chứng từ và id khách hàng
     *
     * @param mixed $data
     * @return mixed
     */
    public function getOrder(Request $request)
    {
        $data = $request->only([
            'customer_id',
            'customer_group_id',
            'type_voucher'
        ]);
        $paymentVoucherdestroy = $this->paymentVoucherService->getOrder($data);
        return $this->_responseSuccess('Xử lý thành công',new OrderResource($paymentVoucherdestroy),200);
    }

}