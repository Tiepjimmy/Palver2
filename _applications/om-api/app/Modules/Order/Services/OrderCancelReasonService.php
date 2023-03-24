<?php

namespace App\Modules\Order\Services;

use Illuminate\Support\Facades\Validator;
use Common\Exceptions\PalException;
use Common\Exceptions\PalValidationException;
use App\Modules\Order\Repositories\Contracts\IOrderCancelReasonRepository;

/**
 * Class OrderCancelReasonService
 * @package App\Modules\Order\Services
 */
class OrderCancelReasonService
{
    protected $orderCancelReasonRepository;

    /**
     * OrderCancelReasonService constructor.
     * @param IOrderCancelReasonRepository $orderCancelReasonRepository
     */
    public function __construct(
        IOrderCancelReasonRepository $orderCancelReasonRepository
    )
    {
        $this->orderCancelReasonRepository = $orderCancelReasonRepository;
    }

    /**
     * Lấy danh sách lý do hủy đơn hàng
     * @param string $keyword
     * @param numeric $limit
     * @param numeric $offset
     * @return array
     * @throws PalException
     */
    public function getList($keyword, $limit, $offset)
    {
        $listOrderCancelReason = null;
        $listOrderCancelReason = $this->orderCancelReasonRepository->getMore(
            array(
                'keyword' => $keyword
            ),
            array(
                'orderBy' => 'id'
            ),
            false
        );

        if (is_null($listOrderCancelReason)) {
            throw new PalException('E000001');
        }

        $total = count($listOrderCancelReason);
        return array(
            'items' => $listOrderCancelReason->splice($offset, $limit),
            'total' => $total,
            'limit' => $limit,
            'offset' => $offset,
        );
    }

    /**
     * Lưu thông tin tạo mới lý do hủy đơn hàng
     * @param mixed $payload
     * @return mixed
     * @throws PalException
     */
    public function store($payload)
    {
        if (!$payload->filled('code')) {
            $newCode = 0;
            $listOrderCancelReason = $this->orderCancelReasonRepository->getAll();
            foreach ($listOrderCancelReason as $orderCancelReason) {
                if (is_numeric($orderCancelReason['code'])) {
                    if ((int)($orderCancelReason['code']) > $newCode) {
                        $newCode = (int)($orderCancelReason['code']);
                    }
                }
            }
            $payload->merge(array(
                'code' => $newCode + 1
            ));
        }
        $storedOrderCancelReason = null;
        $storedOrderCancelReason = $this->orderCancelReasonRepository->create(array(
            'store_id' => $payload['store_id'],
            'code' => $payload['code'],
            'content' => $payload['content'],
            'is_active' => $payload['is_active'],
            'created_by' => $payload['created_by'],
        ));

        if (is_null($storedOrderCancelReason)) {
            throw new PalException('E000001');
        }

        return $storedOrderCancelReason;
    }

    /**
     * Lấy chi tiết lý do hủy đơn hàng
     * @param numeric $id
     * @return mixed
     * @throws PalException
     * @throws PalValidationException
     */
    public function getDetail($id)
    {
        $validators = Validator::make(array(
            'id' => $id
        ), array(
            'id' => "required|exists:om_order_cancel_reasons,id",
        ));

        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',400);
        }

        $orderCancelReason = null;
        $orderCancelReason = $this->orderCancelReasonRepository->getById($id);

        if (is_null($orderCancelReason)) {
            throw new PalException('E000001');
        }

        return $orderCancelReason;
    }

    /**
     * Lưu thông tin cập nhật lý do hủy đơn hàng
     * @param mixed $request
     * @param numeric $id
     * @return mixed
     * @throws PalException
     * @throws PalValidationException
     */
    public function update($request, $id)
    {
        if (!$request->filled('code')) {
            $newCode = 0;
            $listOrderCancelReason = $this->orderCancelReasonRepository->getAll();
            foreach ($listOrderCancelReason as $orderCancelReason) {
                if (is_numeric($orderCancelReason['code'])) {
                    if ((int)($orderCancelReason['code']) > $newCode) {
                        $newCode = (int)($orderCancelReason['code']);
                    }
                }
            }
            $request->merge(array(
                'code' => $newCode + 1
            ));
        }
        $validators = Validator::make(array(
            'id' => $id
        ), array(
            'id' => "required|exists:om_order_cancel_reasons,id",
        ));

        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',400);
        }

        $updatedOrderCancelReason = null;
        $updatedOrderCancelReason = $this->orderCancelReasonRepository->updateById($id, array(
            'store_id' => $request['store_id'],
            'code' => $request['code'],
            'content' => $request['content'],
            'is_active' => $request['is_active'],
            'updated_by' => $request['updated_by'],
        ));

        if (is_null($updatedOrderCancelReason)) {
            throw new PalException('E000001');
        }

        return $updatedOrderCancelReason;

    }

    /**
     * Xóa lý do hủy đơn hàng
     * @param numeric $id
     * @return mixed
     * @throws PalException
     * @throws PalValidationException
     */
    public function destroy($id)
    {
        $validators = Validator::make(array(
            'id' => $id
        ), array(
            'id' => "required|exists:om_order_cancel_reasons,id",
        ));

        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',400);
        }

        $deletedOrderCancelReason = null;
        $deletedOrderCancelReason = $this->orderCancelReasonRepository->delByCond(array(
            'id' => $id
        ));

        if (is_null($deletedOrderCancelReason)) {
            throw new PalException('E000001');
        }

        return $deletedOrderCancelReason;
    }

}