<?php

namespace App\Modules\Customer\Controllers\Api;

use Common\Http\Controllers\Api\AbstractApiController;

use Illuminate\Http\Request;
use App\Modules\Customer\Requests\CustomerAddress\CustomerAddressRequest;

use App\Modules\Customer\Services\CustomerAddressServices;
use App\Modules\Customer\Resources\CustomerAddressResource;

class CustomerAddressController extends AbstractApiController
{
    protected $customerAddressService;

    public function __construct(CustomerAddressServices $customerAddressServices)
    {
        parent::__construct();

        $this->customerAddressService = $customerAddressServices;
    }

    public function list(Request $request)
    {
        try {
            $payload = $request->all();

            $customerAddress = $this->customerAddressService->list($payload);
            $appendData = new CustomerAddressResource($customerAddress);
        } catch (\Exception $e) {
            throw $e;
        }
        return $this->_responseSuccess('Lấy danh sách thành công', $appendData);
    }

    public function show($customerAddress_id)
    {
        try {
            $customerAddress = $this->customerAddressService->show($customerAddress_id);
            $appendData = new CustomerAddressResource($customerAddress);
        } catch (\Exception $e) {
            throw $e;
        }
        return $this->_responseSuccess('Lấy chi tiết thành công', $appendData);
    }

    public function store(CustomerAddressRequest $request)
    {
        try {
            $payload = $request->only(['store_id', 'customer_id', 'mobile', 'email', 'country_id', 'province_id', 'district_id', 'ward_id', 'address', 'is_default']);
            $payload = array_merge($payload, array('created_by' => 1));
            $customerAddress = $this->customerAddressService->store($payload);

            $appendData = new CustomerAddressResource($customerAddress);
        } catch (\Exception $e) {
            throw $e;
        }

        return $this->_responseSuccess('Tạo mới thành công', $appendData);
    }

    public function update(CustomerAddressRequest $request, $customerAddress_id)
    {
        try {
            $payload = $request->only(['mobile', 'email', 'country_id', 'province_id', 'district_id', 'ward_id', 'address', 'is_default']);
            $customerAddress = $this->customerAddressService->update($payload, $customerAddress_id);

            $appendData = new CustomerAddressResource($customerAddress);
        } catch (\Exception $e) {
            throw $e;
        }

        return $this->_responseSuccess('Cập nhật thành công', $appendData);
    }

    public function destroy($customerAddress_id)
    {
        try {
            $this->customerAddressService->destroy($customerAddress_id);
        } catch (\Exception $e) {
            throw $e;
        }

        return $this->_responseSuccess('Xoá thành công');
    }
}
