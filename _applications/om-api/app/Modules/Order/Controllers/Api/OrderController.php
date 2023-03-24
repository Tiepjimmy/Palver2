<?php

namespace App\Modules\Order\Controllers\Api;

use App\Modules\Order\Resources\OrderPaymentResource;
use App\Modules\Order\Resources\StatusResource;
use Illuminate\Http\Request;
use App\Http\PalServiceErrorCode;
use App\Modules\Order\Requests\OrderRequest;
use App\Modules\Order\Services\OrdersService;
use App\Modules\Order\Resources\OrderResource;
use App\Modules\Order\Requests\OrderStoreRequest;
use App\Modules\Order\Requests\OrderUpdateRequest;
use App\Modules\Order\Resources\OrderNoteResource;
use App\Modules\Order\Resources\OrderAddressResource;
use Common\Http\Controllers\Api\AbstractApiController;
use App\Modules\Order\Requests\OrderApproveBulkRequest;
use App\Modules\Order\Requests\OrderCheckoutStoreRequest;
use App\Modules\Order\Resources\OrderStatusLogListResource;
use App\Modules\Order\Requests\OrderPaymentConfirmBulkRequest;
use Throwable;

class OrderController extends AbstractApiController
{
    protected $orderService;
    private $orderApproveService;

    /**
     * @param OrdersService $orderService
     */
    public function __construct(OrdersService $orderService)
    {
        parent::__construct();
        $this->orderService = $orderService;
    }

    /**
     * Service lấy danh sách đơn hàng
     * @param OrderRequest $request
     * @return mixed
     */
    public function index(OrderRequest $request)
    {
        $limit = (int) $request->limit;
        $offset = (int) $request->offset;

        [$items, $total] =  $this->orderService->list($request, $limit, $offset);

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR,
            [
                'items' => OrderResource::collection($items),
                'total' => $total,
                'limit' => $limit
            ]
        );
    }

    /**
     * Api lấy danh sách trạng thái đơn hàng
     * @return mixed
     */
    public function getListStatus()
    {
        $data = $this->orderService->getListStatus();

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $data);
    }

    /**
     * Api lấy danh sách kho hàng
     * @return mixed
     */
    public function getListStock()
    {
        $data = $this->orderService->getListStock();

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $data);
    }

    /**
     * Api lấy danh sách sản phẩm đơn hàng
     * @return mixed
     */
    public function getListProductStock($stock_id)
    {
        $data = $this->orderService->getListProductStock($stock_id);

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR,
            [
                'items' => $data
            ]
        );
    }

    /**
     * Api lấy danh sách sản phẩm
     * @return mixed
     */
    public function getListProduct(Request $request)
    {
        $data = $this->orderService->getListProduct($request);

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR,
            $data
        );
    }

    /**
     * @param OrderStoreRequest $request
     * @return mixed
     * @throws \OmSdk\Exceptions\PalException
     */
    public function store(OrderStoreRequest $request)
    {
        $storeOrder = $this->orderService->store($request);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $storeOrder);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function detail($id)
    {
        $data = $this->orderService->detail($id);

        $data = new OrderResource($data);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $data);
    }

    /**
     * @param OrderUpdateRequest $request
     * @param $id
     * @return mixed
     */
    public function update(OrderUpdateRequest $request, $id)
    {
        $orderUpdateData = $this->orderService->update($request, $id);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $orderUpdateData);
    }

    /**
     * @return mixed
     */
    public function listAddress(Request $request)
    {
        $orderNoteData = $this->orderService->getListAddress($request);

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR,
            [
            'items' => OrderAddressResource::collection($orderNoteData)
            ]
        );
    }

    /**
     * Duyệt đơn hàng
     *
     * @param      OrderApproveRequest  $request  The request
     * @param      <type>               $id       The identifier
     *
     * @return     void
     */
    public function approve(Request $request, int $id)
    {
        try {
            $receipts = $this->orderService->approve([$id]);

            return $this->_responseSuccess('Duyệt đơn hàng thành công', []);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return mixed
     * @throws Throwable
     */
    public function unApprove(Request $request, int $id)
    {
        try {
            $receipts = $this->orderService->unApprove([$id]);

            return $this->_responseSuccess('Duyệt đơn hàng thành công', []);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * Duyệt nhiều đơn hàng
     *
     * @param      OrderApproveBulkRequest  $request  The request
     *
     * @return     void
     */
    public function bulkApprove(OrderApproveBulkRequest $request)
    {
        try {
            $receipts = $this->orderService->approve($request->get('ids', []));

            return $this->_responseSuccess('Duyệt các đơn hàng thành công', []);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * { function_description }
     *
     * @param      \Illuminate\Http\Request  $request  The request
     * @param      int                       $ID       { parameter_description }
     *
     * @return     <type>                    ( description_of_the_return_value )
     */
    public function paymentConfirm(Request $request, int $ID)
    {
        try {
            $receipts = $this->orderService->paymentConfirm([$ID]);

            return $this->_responseSuccess('Xác nhận thanh toán thành công', []);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * { function_description }
     *
     * @param      OrderPaymentConfirmBulkRequest  $request  The request
     *
     * @return     <type>                          ( description_of_the_return_value )
     */
    public function bulkPaymentConfirm(OrderPaymentConfirmBulkRequest $request)
    {
        try {
            $receipts = $this->orderService->paymentConfirm($request->get('ids', []));

            return $this->_responseSuccess('Xác nhận các thanh toán thành công', []);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * Hủy xác nhận một thanh toán
     *
     * @param      \Illuminate\Http\Request  $request  The request
     * @param      int                       $ID       { parameter_description }
     *
     * @return     <type>                    ( description_of_the_return_value )
     */
    public function cancelPaymentConfirm(Request $request, int $ID)
    {
        try {
            $this->orderService->cancelPaymentConfirm(
                $request->get('receipt_voucher_id'),
                [$ID]
            );

            return $this->_responseSuccess('Hủy xác nhận thanh toán thành công', []);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * Hủy xác nhận nhiều thanh toán
     *
     * @param      OrderPaymentConfirmBulkRequest  $request  The request
     *
     * @return     <type>                          ( description_of_the_return_value )
     */
    public function bulkCancelPaymentConfirm(OrderPaymentConfirmBulkRequest $request)
    {
        try {
            $this->orderService->cancelPaymentConfirm(
                $request->get('receipt_voucher_id'),
                $request->get('ids', [])
            );

            return $this->_responseSuccess('Hủy xác nhận các thanh toán thành công', []);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * Lấy lịch sử thanh toán của một đơn hàng
     *
     * @param      \Illuminate\Http\Request  $request  The request
     * @param      <type>                    $orderID  The order id
     *
     * @return     <type>                    ( description_of_the_return_value )
     */
    public function paymentHistory(Request $request, $orderID)
    {
        try {
            $results = $this->orderService->paymentHistory($orderID);

            return $this->_responseSuccess('Lấy lịch sử thanh toán thành công', $results);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * Lấy lịch sử thanh toán của nhiều đơn hàng
     *
     * @param      \Illuminate\Http\Request  $request  The request
     * @param      <type>                    $orderID  The order id
     *
     * @return     <type>                    ( description_of_the_return_value )
     */
    public function bulkPaymentHistory(Request $request)
    {
        try {
            $results = $this->orderService->paymentHistory($request->get('ids', []));

            return $this->_responseSuccess('Lấy lịch sử thanh toán thành công', $results);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * Lấy lịch sử trạng thái đơn hàng
     *
     * @param      \Illuminate\Http\Request  $request  The request
     * @param      <type>                    $orderID  The order id
     *
     * @return     <type>                    ( description_of_the_return_value )
     */
    public function statusLogs(Request $request, $orderID)
    {
        try {
            $results = $this->orderService->statusLogs([$orderID]);

            return $this->_responseSuccess('Lấy lịch sử thanh toán thành công', new OrderStatusLogListResource($results));
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * Lưu thông tin thanh toán cho đơn hàng
     * @param OrderCheckoutStoreRequest $request
     * @param numeric $id
     * @return mixed
     * @throws \Common\Exceptions\PalException
     */
    public function checkout(OrderCheckoutStoreRequest $request, $id)
    {
        $request->merge(array(
            'order_id' => $id
        ));
        $storedOrderCheckout = $this->orderService->checkout($request->toArray());
        return $this->_responseSuccess('Xử lý thành công', $storedOrderCheckout);
    }

    /**
     * @param $id
     * @return mixed
     * @throws Throwable
     */
    public function listCheckout($id)
    {
        try {
            $data = $this->orderService->listCheckout($id);

            return $this->_responseSuccess('Lấy lịch sử thanh toán thành công',
                [
                    'items' => OrderPaymentResource::collection($data)
                ]
            );
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * @param $orderId
     * @return mixed
     */
    public function subStatuses($orderId)
    {
        $statuses = $this->orderService->getSubStatuses($orderId);

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR,
            [
                'items' => StatusResource::collection($statuses)
            ]
        );
    }

    /**
     * @param OrderUpdateRequest $request
     * @param $orderId
     * @return mixed
     */
    public function cancel(OrderUpdateRequest $request, $orderId)
    {
        $updated = $this->orderService->cancel($orderId, (int) $request->post('cancel_reason_id'));

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR
        );
    }

    /**
     * @param OrderUpdateRequest $request
     * @param $orderId
     * @return mixed
     */
    public function shipping(OrderUpdateRequest $request)
    {
        $orderIds = (array) $request->post('ids');

        $updated = $this->orderService->shipping($orderIds);

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR
        );
    }

    /**
     * @param OrderUpdateRequest $request
     * @param $orderId
     * @return mixed
     */
    public function shippingSuccess(OrderUpdateRequest $request, $orderId)
    {
        $updated = $this->orderService->shippingSuccess($orderId);

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR
        );
    }

    /**
     * @param OrderUpdateRequest $request
     * @param $orderId
     * @return mixed
     */
    public function refund(OrderUpdateRequest $request, $orderId)
    {
        $updated = $this->orderService->refund($orderId);

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR
        );
    }
}
