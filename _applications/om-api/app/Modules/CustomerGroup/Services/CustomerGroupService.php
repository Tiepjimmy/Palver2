<?php

namespace App\Modules\CustomerGroup\Services;

use OmSdk\Modules\Customer\Repositories\Contracts\ICustomerGroupRepository;

class CustomerGroupService
{
    protected $customerGroupRepository;

    public function __construct(ICustomerGroupRepository $customerGroupRepository)
    {
        $this->customerGroupRepository = $customerGroupRepository;
    }

    public function list($request)
    {
        $keyword = $request->filled('s') ? $request->input('s') : null;

        $total = $this->customerGroupRepository->checkExist([
            'keyword' => $keyword
        ]);

        $listData = $this->customerGroupRepository->getMore([
            'keyword' => $keyword
        ]);

        return [
            'items' => $listData,
            'total' => $total
        ];
    }

    public function store($request)
    {
        $customerGroup = $this->customerGroupRepository->create([
            'name' => $request['name'],
            'store_id' => $request['store_id'],
            'created_by' => 1,
            'updated_by' => 1
        ]);

        return $customerGroup;
    }

    public function update($request, $id)
    {
        $customerGroupUpdate = $this->customerGroupRepository->updateById($id, [
            'name' => $request['name'],
            'store_id' => $request['store_id'],
            'created_by' => 1,
            'updated_by' => 1
        ]);

        return $customerGroupUpdate;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->customerGroupRepository->destroy([$id]);

    }
}