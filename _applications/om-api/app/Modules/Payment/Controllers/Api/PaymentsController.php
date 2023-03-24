<?php

namespace App\Modules\Payment\Controllers\Api;

use App\Http\PalServiceErrorCode;
use App\Modules\Payment\Requests\PaymentStoreRequest;
use App\Modules\Payment\Requests\PaymentUpdateRequest;
use App\Modules\Payment\Resources\PaymentResources;
use App\Modules\Payment\Services\PaymentService;
use Common\Http\Controllers\Api\AbstractApiController;
use Illuminate\Http\Request;

class PaymentsController extends AbstractApiController
{
    protected $paymentService;

    /**
     * @param PaymentService $paymentService
     */
    public function __construct(PaymentService $paymentService)
    {
        parent::__construct();

        $this->paymentService = $paymentService;
    }

    /**Lấy danh sách tài khoản tiền marketing
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request){
        $limit = $request->filled('limit')
            && is_numeric($request->input('limit')) ? (int)$request->input('limit') : 10;
        $offset = $request->filled('offset')
            && is_numeric($request->input('offset')) ? (int)$request->input('offset') : 0;

        $data = $this->paymentService->list( $request, $limit, $offset);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $data) ;
    }

    /**
     * Api tạo tài khoản tiền marketing
     *
     * @param PaymentStoreRequest $request
     * @return void
     */
    public function store(PaymentStoreRequest $request)
    {
        $paymentStore = $this->paymentService->store($request->toArray());

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $paymentStore) ;

    }

    /**Api update payment account
     *
     * @param PaymentUpdateRequest $request
     * @param $paymentId
     * @return void
     */
    public function update(PaymentUpdateRequest $request, $paymentId)
    {
        $paymentUpdate = $this->paymentService->update($request->toArray(), $paymentId);

        return $this->_responseSuccess( PalServiceErrorCode::NO_ERROR, $paymentUpdate);
    }

    /***
     * Api xóa tk tiền marketing
     *
     * @param $paymentId
     * @return void
     */
    public function destroy($paymentId)
    {
        $destroyPayment = $this->paymentService->destroy($paymentId);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $destroyPayment);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function destroyMulti(Request $request)
    {
        $listChannelId = $request->input('ids');

        $destroyChannel = $this->paymentService->destroyMultil($listChannelId);

        return $this->_responseSuccess( PalServiceErrorCode::NO_ERROR, $destroyChannel);
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        $listPayments = $this->paymentService->getAll();

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR,
            [
                'items' => PaymentResources::collection($listPayments)
            ]);
    }
}