<?php

namespace App\Modules\Order\Controllers\Api;

use Common\Http\Controllers\Api\AbstractApiController;
use App\Modules\Order\Requests\OrderCancelReasonIndexRequest;
use App\Modules\Order\Requests\OrderCancelReasonStoreRequest;
use App\Modules\Order\Requests\OrderCancelReasonUpdateRequest;
use App\Modules\Order\Services\OrderCancelReasonService;

/**
 * Class OrderCancelReasonController
 * @package App\Modules\Order\Controllers\Api
 */
class OrderCancelReasonController extends AbstractApiController
{
    protected $orderCancelReasonService;

    /**
     * OrderCancelReasonController constructor.
     * @param OrderCancelReasonService $orderCancelReasonService
     */
    public function __construct(OrderCancelReasonService $orderCancelReasonService)
    {
        parent::__construct();
        $this->orderCancelReasonService = $orderCancelReasonService;
    }

    /**
     * Lấy danh sách lý do hủy đơn hàng
     * @param OrderCancelReasonIndexRequest $request
     * @return mixed
     * @throws \Common\Exceptions\PalException
     */
    public function index(OrderCancelReasonIndexRequest $request)
    {
        $keyword = $request->input('keyword') ?? '';
        $limit = $request->input('limit') ? (int)$request->input('limit') : 10;
        $offset = $request->input('offset') ? (int)$request->input('offset') : 0;
        $listOrderCancelReason = $this->orderCancelReasonService->getList($keyword, $limit, $offset);
        return $this->_responseSuccess('Xử lý thành công', $listOrderCancelReason);
    }

    /**
     * Lưu thông tin tạo mới lý do hủy đơn hàng
     * @param OrderCancelReasonStoreRequest $request
     * @return mixed
     * @throws \Common\Exceptions\PalException
     */
    public function store(OrderCancelReasonStoreRequest $request)
    {
        $storedOrderCancelReason = $this->orderCancelReasonService->store($request);
        return $this->_responseSuccess('Xử lý thành công', $storedOrderCancelReason);
    }

    /**
     * Lấy chi tiết lý do hủy đơn hàng
     * @param numeric $id
     * @return mixed
     * @throws \Common\Exceptions\PalException
     * @throws \Common\Exceptions\PalValidationException
     */
    public function edit($id)
    {
        $detailOrderCancelReason = $this->orderCancelReasonService->getDetail($id);
        return $this->_responseSuccess('Xử lý thành công', $detailOrderCancelReason);
    }

    /**
     * Lưu thông tin cập nhật lý do hủy đơn hàng
     * @param OrderCancelReasonUpdateRequest $request
     * @param numeric $id
     * @return mixed
     * @throws \Common\Exceptions\PalException
     * @throws \Common\Exceptions\PalValidationException
     */
    public function update(OrderCancelReasonUpdateRequest $request, $id)
    {
        $updatedOrderCancelReason = $this->orderCancelReasonService->update($request, $id);
        return $this->_responseSuccess('Xử lý thành công', $updatedOrderCancelReason);
    }

    /**
     * Xóa lý do hủy đơn hàng
     * @param numeric $id
     * @return mixed
     * @throws \Common\Exceptions\PalException
     * @throws \Common\Exceptions\PalValidationException
     */
    public function destroy($id)
    {
        $destroyedOrderCancelReason = $this->orderCancelReasonService->destroy($id);
        return $this->_responseSuccess('Xử lý thành công', $destroyedOrderCancelReason);
    }
}
