<?php

namespace App\Modules\Order\Services;

use AccountSdkDb\Modules\Store\Repositories\Contracts\StoreInterface;
use App\Modules\Order\Requests\OrderStoreRequest;
use Illuminate\Support\Collection;
use Common\Exceptions\PalException;
use Illuminate\Support\Facades\Validator;
use Inventory\Modules\Stock\Models\Stock;
use App\Modules\Order\Requests\OrderRequest;
use Common\Exceptions\PalValidationException;
use OmSdk\Modules\Order\Models\Order;
use OmSdk\Modules\Order\Services\IOrderService;
use AccountSdkDb\Modules\Product\Models\Product;
use OmSdk\Modules\Order\Services\IOrderApproveService;
use OmSdk\Modules\Order\Services\IOrderStatusLogsService;
use AccountSdkDb\Modules\Product\Services\IProductService;
use OmSdk\Modules\Order\Services\IOrderPaymentConfirmService;
use AccountSdkDb\Modules\Warehouse\Services\IWavehouseService;
use OmSdk\Modules\Order\Repositories\Contracts\IOrderRepository;
use Inventory\Modules\Stock\Repositories\Contracts\StockInterface;
use OmSdk\Modules\Customer\Repositories\Contracts\ICustomerRepository;
use OmSdk\Modules\Order\Repositories\Contracts\IOrderAddressRepository;
use OmSdk\Modules\Order\Repositories\Contracts\IOrderNotesRepository;
use OmSdk\Modules\Order\Repositories\Contracts\IOrderStatusRepository;
use OmSdk\Modules\Order\Repositories\Contracts\IOrderPaymentRepository;
use OmSdk\Modules\Order\Repositories\Contracts\IOrderProductRepository;
use AccountSdkDb\Modules\Product\Repositories\Contracts\ProductInterface;
use OmSdk\System\Constants\OrderStatus;

class OrdersService
{
    protected $orderRepository;
    protected $orderStatusRepository;
    protected $stockRepository;
    protected $productService;
    protected $wavehouseService;
    protected $customerRepository;
    protected $orderNotesRepository;
    protected $orderProductRepository;
    protected $storeRepository;
    protected $productRepository;
    protected $sdkOrderServices;
    protected $orderAddress;
    private $orderApproveService;
    private $orderPaymentRepository;
    private $paymentConfirmService;
    private $orderStatusLogsService;

    public function __construct(
        IOrderRepository $orderRepository,
        IOrderStatusRepository $orderStatusRepository,
        StockInterface $stockRepository,
        IProductService $productService,
        IWavehouseService $wavehouseService,
        ICustomerRepository $customerRepository,
        IOrderNotesRepository $orderNotesRepository,
        IOrderProductRepository $orderProductRepository,
        StoreInterface $storeRepository,
        ProductInterface $productRepository,
        IOrderService $sdkOrderServices,
        IOrderAddressRepository $orderAddress,
        IOrderApproveService $orderApproveService,
        IOrderPaymentRepository $orderPaymentRepository,
        IOrderPaymentConfirmService $paymentConfirmService,
        IOrderStatusLogsService $orderStatusLogsService
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderStatusRepository = $orderStatusRepository;
        $this->stockRepository = $stockRepository;
        $this->productService = $productService;
        $this->wavehouseService = $wavehouseService;
        $this->customerRepository = $customerRepository;
        $this->orderNotesRepository = $orderNotesRepository;
        $this->orderProductRepository = $orderProductRepository;
        $this->storeRepository = $storeRepository;
        $this->productRepository = $productRepository;
        $this->sdkOrderServices = $sdkOrderServices;
        $this->orderAddress = $orderAddress;
        $this->orderApproveService = $orderApproveService;
        $this->orderPaymentRepository = $orderPaymentRepository;
        $this->paymentConfirmService = $paymentConfirmService;
        $this->orderStatusLogsService = $orderStatusLogsService;
    }

    /**
     * Listing orders
     *
     * @param OrderRequest $request
     * @param $limit
     * @param $offset
     * @return array
     */
    public function list($request, $limit, $offset)
    {
        $store_id = [1];

        $conditions = [
            'filter' => array_merge($request->all(), $store_id)
        ];

        $total = $this->orderRepository->checkExist($conditions);

        $listData = $this->orderRepository->getMore(
            $conditions,
            [
                'limit' => $limit,
                'offset' => $offset,
                'orderBy' => 'id',
                'width' => ['orderAddress.province', 'orderAddress.district', 'orderAddress.ward']
            ]
        );

        return [
            $listData,
            $total
        ];
    }

    /**
     * Service lấy danh sách trạng thái đơn hàng
     * @return Collection
     */
    public function getListStatus()
    {
        $conditions = [
            'store_id' => 1,
            'is_active'=> 1
        ];

        return $this->orderStatusRepository->getMore($conditions);
    }

    /**
     * Service lấy danh sách kho
     * @return array
     */
    public function getListStock()
    {
        $store_id = 1;

        $conditions = [
            'store_id' => $store_id,
            'type'=> 'sell'
        ];

        $data = $this->wavehouseService->getBranchedWarehouse($conditions);

        return $data;
    }

    /**
     * @param $stock_id
     * @return Collection
     */
    public function getListProductStock($stock_id)
    {
        $data = Product::query()
            ->select(['acc_t_products.*', 'inv_stocks.quantity As quantity'])
            ->join('inv_stocks', 'inv_stocks.product_id', '=', 'acc_t_products.id')
            ->where('inv_stocks.id', '=', $stock_id)
            ->where('inv_stocks.store_id', '=', 1)
            ->where('inv_stocks.quantity', '>', 0)
            ->where('inv_stocks.type', Stock::TYPE_SELL)
            ->distinct()
            ->get();

        return $data;
    }

    /**
     * @param $request
     * @return array
     */
    public function getListProduct($request)
    {
        $conditions = [
            'store_id' => 1,
            'product_name' => $request->name
        ];

        $listData = $this->productService->getRetailProducts($conditions, [], 5);

        return $listData;
    }

    /**
     * Api tạo đơn hàng
     * @param OrderStoreRequest $request
     * @return int|null
     */
    public function store($request)
    {
        return $this->sdkOrderServices->store($request);
    }

    /**
     * Api chi tiết đơn hàng
     * @param $id
     * @return mixed
     */
    public function detail($id)
    {
        return $this->sdkOrderServices->detail($id);
    }

    /**
     * @param $request
     * @param $id
     * @return mixed
     */
    public function update($request, $id)
    {
        return $this->sdkOrderServices->update($request, $id);
    }

    /**
     * @return mixed
     */
    public function getListAddress($request)
    {
        $storeId = 1;

        $customerId = isset($request->customer_id) ? $request->customer_id : null;

        $data = $this->orderAddress->getMore([
            'store_id' =>$storeId,
            'customer_id' => $customerId
        ]);

        return $data;
    }

    /**
     * Duyệt danh sách đơn hàng
     *
     * @param      array   $orderIDs  Danh sách đơn hàng
     *
     * @return     bool
     */
    public function approve(array $orderIDs) : bool
    {
        return $this->orderApproveService->execute($orderIDs);
    }

    /**
     * @param $orderId
     * @return mixed
     */
    public function unApprove($orderId)
    {
        /** @var Order $order */
        $order = $this->orderRepository->getOne([
            'id' => $orderId
        ]);

        if (! $order) {
            return false;
        }

        $conditions = [
            'id' => $orderId
        ];

        $fillData = [
            'approved_at' => null,
            'approved_user_id' => null,
            'order_status_id' => OrderStatus::XAC_NHAN_CHOT_DON
        ];

        return $this->orderRepository->updateByCondition($conditions, $fillData);
    }

    /**
     * Xác nhận doanh thu thanh toán
     *
     * @param      array   $paymentIDs  Danh sách ID thanh toán
     *
     * @return     bool
     */
    public function paymentConfirm(array $paymentIDs) : bool
    {
        return $this->paymentConfirmService->confirm($paymentIDs);
    }

    /**
     * Hủy xác nhận doanh thu thanh toán
     *
     * @param      int    $receiptVoucherID  The receipt voucher id
     * @param      array  $paymentIDs        Danh sách ID thanh toán
     *
     * @return     bool
     */
    public function cancelPaymentConfirm(int $receiptVoucherID, array $paymentIDs) : bool
    {
        return $this->paymentConfirmService->cancelConfirm($receiptVoucherID, $paymentIDs);
    }

    /**
     * Lấy lịch sử thanh toán đơn hàng
     *
     * @param      int     $orderIDs  ID đơn hàng
     *
     * @return     Collection
     */
    public function paymentHistory(array $orderIDs) : Collection
    {
        return $this->sdkOrderServices->paymentHistory($orderIDs);
    }

    /**
     * Lưu thông tin thanh toán cho đơn hàng
     * @param array $payload
     * @return mixed
     * @throws PalException
     */
    public function checkout($payload)
    {
        $validators = Validator::make($payload, array(
            'order_id' => "required|exists:om_orders,id",
        ));

        if ($validators->fails()) {
            throw new PalValidationException($validators, 'E000003', 'Lỗi validate', 422);
        }

        $storedOrderCheckout = null;
        $storedOrderCheckout = $this->orderPaymentRepository->create(array(
            'store_id' => $payload['store_id'],
            'order_id' => $payload['order_id'],
            'invoice_id' => $payload['invoice_id'] ?? null,
            'payment_method_id' => $payload['payment_method_id'],
            'payment_amount' => $payload['payment_amount'],
            'note' => $payload['note'] ?? null,
            'created_by' => $payload['created_by']
        ));

        if (is_null($storedOrderCheckout)) {
            throw new PalException('E000001');
        }

        return $storedOrderCheckout;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function listCheckout($id)
    {
        $condition = [
            'store_id' => 1,
            'order_id' => $id
        ];

        return $this->orderPaymentRepository->getMore($condition);
    }

    /**
     * @param int $orderId
     * @return Collection
     */
    public function getSubStatuses(int $orderId)
    {
        /** @var Order $order */
        $order = $this->orderRepository->getOne(
            [
                'id' => $orderId
            ],
        );

        if (! $order || empty($order->orderStatus)) {
            return collect();
        }

        return $this->orderStatusRepository->getMore([
            'filter' => [
                'level' => $order->orderStatus->level,
                'is_not_system' => 1
            ]
        ]);
    }

    /**
     * @param int $orderId
     * @param int $cancelReasonId
     * @return bool
     */
    public function cancel(int $orderId, int $cancelReasonId)
    {
        /** @var Order $order */
        $order = $this->orderRepository->getOne(
            [
                'id' => $orderId
            ],
        );

        if (! $order) {
            return false;
        }

        return $this->orderRepository->updateById($orderId, [
            'cancel_reason_id' => $cancelReasonId,
            'order_status_id' => OrderStatus::HUY_DON,
        ]);
    }

    /**
     * @param array $orderIds
     * @return bool
     */
    public function shipping(array $orderIds)
    {
        $orderIds = array_filter($orderIds);

        if (empty($orderIds)) {
            return false;
        }

        return $this->orderRepository->updateByCondition(
            [
                'id' => $orderIds
            ],
            [
                'order_status_id' => OrderStatus::CHUYEN_HANG
            ],
            [],
            true
        );
    }

    /**
     * @param int $orderId
     * @return bool
     */
    public function shippingSuccess(int $orderId)
    {
        /** @var Order $order */
        $order = $this->orderRepository->getOne(
            [
                'id' => $orderId
            ],
        );

        if (! $order) {
            return false;
        }

        return $this->orderRepository->updateById($orderId, [
            'order_status_id' => OrderStatus::GIAO_HANG_THANH_CONG,
        ]);
    }

    /**
     * @param int $orderId
     * @return bool
     */
    public function refund(int $orderId)
    {
        /** @var Order $order */
        $order = $this->orderRepository->getOne(
            [
                'id' => $orderId
            ],
        );

        if (! $order) {
            return false;
        }

        return $this->orderRepository->updateById($orderId, [
            'order_status_id' => OrderStatus::CHUYEN_HOAN,
        ]);
    }
}
