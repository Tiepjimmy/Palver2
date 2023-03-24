<?php

namespace App\Modules\Customer\Controllers\Api;

use App\Http\PalServiceErrorCode;
use App\Modules\Customer\Requests\CustomerStoreRequest;
use App\Modules\Customer\Requests\CustomerUpdateRequest;
use App\Modules\Customer\Resources\CustomerResources;
use App\Modules\Customer\Services\CustomerService;
use Common\Http\Controllers\Api\AbstractApiController;
use Illuminate\Http\Request;

class CustomerController extends AbstractApiController
{
    protected $customerService;

    /**
     * CustomerController constructor.
     * @param CustomerService $customerService
     */
    public function __construct(CustomerService $customerService)
    {
        parent::__construct();

        $this->customerService = $customerService;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        [$items ,$total] = $this->customerService->getList($request);

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR ,
            [
                'items' => CustomerResources::collection($items),
                'total' => $total
            ]
        );
    }

    /**
     * @param CustomerStoreRequest $request
     * @return mixed
     * @throws \OmSdk\Exceptions\PalException
     */
    public function store(CustomerStoreRequest $request)
    {
        $customerStore = $this->customerService->store($request);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $customerStore);
    }

    /**
     * @param CustomerUpdateRequest $request
     * @param $id
     * @return mixed
     * @throws \OmSdk\Exceptions\PalException
     */
    public function update(CustomerUpdateRequest $request, $id)
    {
        $customerUpdate = $this->customerService->update($request, $id);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $customerUpdate);
    }

    /**
     * Api lấy danh sách các tỉnh
     * @return mixed
     */
    public function getProvince()
    {
        $data = $this->customerService->getProvince();

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $data);
    }

    /**
     * Api lấy danh sách quận huyện
     * @param $province_id
     * @return mixed
     */
    public function getDistrict($province_id)
    {
        $data = $this->customerService->getDistrict($province_id);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $data);

    }

    /**
     * Api lấy chi tiết phường/xã
     * @param $districtId
     * @return mixed
     */
    public function getWards($districtId)
    {
        $data = $this->customerService->getWards($districtId);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $data);
    }

    /**
     * @param $id
     * @return void
     */
    public function detail($id)
    {
        $data = $this->customerService->detail($id);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $data);
    }

}
