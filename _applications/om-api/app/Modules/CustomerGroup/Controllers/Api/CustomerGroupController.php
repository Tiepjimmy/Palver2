<?php

namespace App\Modules\CustomerGroup\Controllers\Api;

use App\Http\PalServiceErrorCode;
use App\Modules\CustomerGroup\Requests\CustomerGroupStoreRequest;
use App\Modules\CustomerGroup\Requests\CustomerGroupUpdateRequest;
use App\Modules\CustomerGroup\Services\CustomerGroupService;
use Common\Http\Controllers\Api\AbstractApiController;
use Illuminate\Http\Request;

class CustomerGroupController extends AbstractApiController
{
    protected $customerGroupService;

    /**
     * CustomerGroupController constructor.
     * @param CustomerGroupService $customerGroupService
     */
    public function __construct(CustomerGroupService $customerGroupService)
    {
        parent::__construct();

        $this->customerGroupService = $customerGroupService;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $data = $this->customerGroupService->list($request);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $data);
    }

    /**
     * @param CustomerGroupStoreRequest $request
     * @return mixed
     */
    public function store(CustomerGroupStoreRequest $request)
    {
        $data = $this->customerGroupService->store($request->all());

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $data);
    }

    /**
     * @param CustomerGroupUpdateRequest $request
     * @param $id
     * @return mixed
     */
    public function update(CustomerGroupUpdateRequest $request, $id)
    {
        $customerGroupUpdate = $this->customerGroupService->update($request->toArray(), $id);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR ,$customerGroupUpdate);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $customerDestroy = $this->customerGroupService->destroy($id);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $customerDestroy);
    }
}