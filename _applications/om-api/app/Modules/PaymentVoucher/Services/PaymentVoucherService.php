<?php

namespace App\Modules\PaymentVoucher\Services;

use App\Modules\Order\Repositories\Eloquent\OrderPaymentRepository;
use Common\Exceptions\PalException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use OmSdk\Exceptions\PalValidationException;
use OmSdk\Modules\Customer\Repositories\Eloquent\CustomerGroupRepository;
use OmSdk\Modules\Order\Repositories\Eloquent\OrderPaymentMethodRepository;
use OmSdk\Modules\Order\Repositories\Eloquent\OrderRepository;
use OmSdk\Modules\PaymentVoucher\Repositories\Contracts\IOrderPaymentVoucherRepository;
use OmSdk\Modules\PaymentVoucher\Repositories\Eloquent\PaymentVoucherRepository;
use OmSdk\Modules\TypePaymentVoucher\Repositories\Eloquent\TypePaymentVoucherRepository;

class PaymentVoucherService
{
    protected $orderPaymentVoucherRepository;
    protected $paymentVoucherRepository;
    protected $typePaymentVoucherRepository;
    protected $customerGroupRepository;
    protected $orderRepository;
    protected $orderPaymentRepository;
    protected $orderPaymentMethodRepository;
    public function __construct(
        PaymentVoucherRepository $paymentVoucherRepository,
        IOrderPaymentVoucherRepository $orderPaymentVoucherRepository,
        TypePaymentVoucherRepository $typePaymentVoucherRepository,
        CustomerGroupRepository $customerGroupRepository,
        OrderRepository $orderRepository,
        OrderPaymentRepository $orderPaymentRepository,
        OrderPaymentMethodRepository $orderPaymentMethodRepository
    )
    {
        $this->paymentVoucherRepository = $paymentVoucherRepository;
        $this->orderPaymentVoucherRepository = $orderPaymentVoucherRepository;
        $this->typePaymentVoucherRepository = $typePaymentVoucherRepository;
        $this->customerGroupRepository = $customerGroupRepository;
        $this->orderRepository = $orderRepository;
        $this->orderPaymentRepository = $orderPaymentRepository;
        $this->orderPaymentMethodRepository = $orderPaymentRepository;
    }

    /**
     * Lấy danh sách chứng từ chi
     *
     * @param mixed $data
     * @return mixed
     */
    public function search($data = [])
    {
        $paymentVoucher = null;
        $paymentVoucher = $this->paymentVoucherRepository->customPaginate(
            $data,
            [
                'with'=>
                    [
                        'orderPaymentVoucher',
                        'typePaymentVoucher',
                        'customer',
                        'user',
                        'customerGroup',
                        'orderPaymentVoucher.order'
                    ]
            ],
            $data['per_page']
        );
        if(is_null($paymentVoucher)){
            throw new PalException('E000001');
        }
        return $paymentVoucher;
    }

    /**
     * Các thông tin liên quan đến chứng từ chi
     * @return mixed
     */
    public function create(){
        $typePaymentVoucher = $this->typePaymentVoucherRepository->getMore(['is_active' => 1 ]);
        $customerGroup = $this->customerGroupRepository->getMore(
            [],
            [
                'with'=>[
                    'customer'
                ]
            ],
            false
        );
        return [
            'type_payment_voucher' => $typePaymentVoucher,
            'customer_group' => $customerGroup,
        ];
    }

    /**
     * Thêm chứng từ chi
     * @param mixed $data
     * @return mixed
     */
    public function store($data)
    {
        $store = null;
        $typePaymentVoucher = null;
        $typePaymentVoucher = $this->typePaymentVoucherRepository->getById($data['type_payment_voucher_id']);
        if(is_null($typePaymentVoucher)){
            throw new PalException('E000001');
        }
        $customerGroup = null;
        $customerGroup = $this->customerGroupRepository->getById($data['customer_group_id']);
        if(is_null($customerGroup)){
            throw new PalException('E000001');
        }
        $data['voucher_code'] = $this->rand_code($typePaymentVoucher->type_code,$data['store_id']);
        $data['created_by'] = Auth::id() ?? 1;
        $store = $this->paymentVoucherRepository->create($data);
        if (isset($data['payment_id']) && !empty($store) && $customerGroup->id == 1 || $customerGroup->id == 2) {
            if (is_array($data['payment_id']) && count($data['payment_id'])) {
                foreach ($data['payment_id'] as $payment) {
                    $param = [];
                    $param['payment_voucher_id'] = (int)$store->id;
                    $param['payment_id'] = (int)$payment;
                    $this->orderPaymentVoucherRepository->create($param);
                }
            }
        }
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
        $connectedDb = $this->paymentVoucherRepository->getConnection();
        $validators = Validator::make(
            [
                'id' => $id
            ],
            [
                'id' => "required|exists:{$connectedDb}.om_payment_vouchers,id",
            ]
        );
        if ($validators->fails()) {
            throw new PalValidationException($validators,'','',422);
        }
        $paymentVoucher = $this->paymentVoucherRepository->getById(
            $id,
            [],
            [
                'with'=>[
                    'orderPaymentVoucher',
                    'typePaymentVoucher',
                    'customer',
                    'customerGroup',
                    'orderPaymentVoucher.order'
                ]
            ]
        );
        if (empty($paymentVoucher)) {
            throw new PalException('E000001');
        }
        return $paymentVoucher;
    }

    /**
     *  Sửa chứng từ chi
     * @param mixed $data
     * @param mixed $id
     * @return mixed
     */
    public function update($data, $id)
    {
        $connectedDb = $this->paymentVoucherRepository->getConnection();
        $validators = Validator::make(
            [
                'id' => $id
            ],
            [
                'id' => "required|exists:{$connectedDb}.om_payment_vouchers,id",
            ]
        );
        if ($validators->fails()) {
            throw new PalValidationException($validators,'','',422);
        }
        $update = null;
        $typePaymentVoucher = null;
        $customerGroup = null;
        $customerGroup = $this->customerGroupRepository->getById($data['customer_group_id']);
        if(is_null($customerGroup)){
            throw new PalException('E000001');
        }
        $data['updated_by'] = Auth::id() ?? 1;
        $update = $this->paymentVoucherRepository->updateById($id,$data);
        if (!empty($update) && $customerGroup->id == 1 || $customerGroup->id == 2 ) {
            if (isset($data['payment_id']) && is_array($data['payment_id']) && count($data['payment_id'])) {
                $orderPaymentVoucher = [
                    'payment_voucher_id' => (int)$update->id
                ];
                $this->orderPaymentVoucherRepository->delByCond($orderPaymentVoucher);
                foreach ($data['payment_id'] as $payment) {
                    $param = [];
                    $param['payment_voucher_id'] = (int)$update->id;
                    $param['payment_id'] = (int)$payment;
                    $this->orderPaymentVoucherRepository->create($param);
                }
            }
        }
        if (is_null($update)) {
            throw new PalException('E000001');
        }
        return $update;
    }

    /**
     *  hủy trạng thái chứng từ chi
     * @param mixed $id
     * @return mixed
     */
    public function cancelStatus($id){
        $connectedDb = $this->paymentVoucherRepository->getConnection();
        $validators = Validator::make(
            [
                'id' => $id
            ],
            [
                'id' => "required|exists:{$connectedDb}.om_payment_vouchers,id",
            ]
        );
        if ($validators->fails()) {
            throw new PalValidationException($validators,'','',422);
        }
        $update = null;
        $param = [];
        $param['is_active'] = 0;
        $update = $this->paymentVoucherRepository->updateById($id,$param);
        if (is_null($update)) {
            throw new PalException('E000001');
        }
        return $update;
    }

    /**
     * Lấy danh sách đơn hàng theo id khách hàng
     * @param mixed $data
     * @return mixed
     */
    public function getOrder($data)
    {
        $connectedDb = $this->typePaymentVoucherRepository->getConnection();
        $validators = Validator::make(
            $data,
            array(
                'type_voucher' => "exists:{$connectedDb}.om_payment_methods,type_voucher",
                'customer_group_id' => "exists:{$connectedDb}.om_customer_groups,id",
                'customer_id' => "exists:{$connectedDb}.om_customers,id",
            ),
            array(
                'type_voucher.exists' => 'Loại chứng từ không tồn tại',
                'customer_id.exists' => 'Khách hàng không tồn tại',
                'customer_group_id.exists' => 'Đối tượng nhận không tồn tại',
            )
        );

        if ($validators->fails()) {
            throw new PalValidationException($validators,'','',422);
        }


        $PaymentMethod = $this->orderPaymentMethodRepository->getMore(
            [
                'type_voucher' => $data['type_voucher']
            ],
            [],
            false

        );
        $currentPaymentMethodIds = collect($PaymentMethod)->map(function ($orderPaymentMethod) { return $orderPaymentMethod->id; })->toArray();
        $paramOrder = [
            'customer_id' => $data['customer_id'],
            'customer_group_id' => $data['customer_group_id'],
        ];
        $orders = null;
        $paymentVouchers = null;
        $orders = $this->orderRepository->getMore($paramOrder,
            [
                'with' => 'orderPayment'
            ],
            false
        )->toArray();
        $paymentVouchers = null;
        $paymentVouchers = $this->paymentVoucherRepository->getMore(
            [],
            [
                'with'=>
                    [
                        'orderPaymentVoucher',
                    ]
            ],
            false
        )->toArray();
        $getOrderPayments = [];
        if (!is_null($paymentVouchers)){
            foreach ($paymentVouchers as $paymentVoucher) {
                if (count($paymentVoucher['order_payment_voucher']) >= 1 ) {
                    $getOrderPayments[]  = $paymentVoucher['order_payment_voucher'][0];
                }
            }
        }
        $checkOrderId = collect($getOrderPayments)->map(function ($orderId) { return $orderId['order_id']; })->toArray();
        foreach ($orders as $orderIndex => $order) {
            $orders[$orderIndex]['order_payments'] = [];
            if (in_array($order['id'], $checkOrderId))  {
                continue;
            }
            if (count($order['order_payment']) > 0) {
                $orderPayments = $order['order_payment'];
                foreach ($orderPayments as $orderPayment) {
                    if (in_array($orderPayment['payment_method_id'], $currentPaymentMethodIds) && $orderPayment['confirmed_by']) {
                        array_push($orders[$orderIndex]['order_payments'], $orderPayment);
                    }
                }
            }
        }
        $orders = collect($orders)->filter(function($order) {
            return count($order['order_payments']) > 0;
        })->toArray();

        if (count($orders) == 1) {
            $orders = array_values($orders);
        }
        return collect(array_values($orders));
    }

    /**
     *  Tạo mã code chứng từ chi
     * @param mixed $type_code
     * @param mixed $store_id
     * @return mixed
     */
    public function rand_code($type_code,$store_id){
        $rand_code = '';
        $rand_code = $type_code.$store_id. sprintf("%06d", mt_rand(1, 999999));
        $param = [];
        $param = ['rand_code' => $rand_code];
        $paymentVoucher = null;
        $paymentVoucher = $this->paymentVoucherRepository->getOne($param);
        if (!is_null($paymentVoucher) && $paymentVoucher->voucher_code == $rand_code) {
            $rand_code = $this->rand_code($type_code,$store_id);
        }
        return $rand_code;
    }
}