<?php

namespace App\Modules\Customer\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use OmSdk\Modules\Customer\Repositories\Contracts\ICustomerAddressRepository;
use App\Modules\Customer\Exceptions\CustomerAddressException;

class CustomerAddressServices
{

    const DEFAULT_LIMIT_ROW = 10;
    protected $customerAddressRepository;

    public function __construct(ICustomerAddressRepository $customerAddressRepository)
    {
        $this->customerAddressRepository = $customerAddressRepository;
    }

    public function list($payload)
    {
        $validator = Validator::make($payload, [
            'store_id' => 'required|numeric',
            'customer_id' => 'required|numeric',
            'limit' => 'numeric|integer',
            'page' => 'numeric|integer'
        ]);

        if ($validator->fails()) {
            throw new CustomerAddressException('ERR_002');
        }

        $perPage = $payload['limit'] ?? self::DEFAULT_LIMIT_ROW;

        $fetchOptions = [
            'with' => ['province', 'district', 'ward']
        ];

        // return $this->customerAddressRepository->customPaginate($payload, [], $perPage);
        $result = $this->customerAddressRepository->getMore($payload, $fetchOptions, $perPage);

        return [
            'items' => $result->items(),
            'total' => $result->total(),
            'page' => $result->currentPage(),
            'limit' => $perPage
        ];
    }

    public function show($id)
    {
        $conn = $this->customerAddressRepository->getConnection();
        $validator = Validator::make(array('id' => $id), [
            'id' => 'exists:'.$conn.'.om_customer_addresses,id',
        ]);

        if ($validator->fails()) {
            throw new CustomerAddressException('ERR_003');
        }

        $customerAddress = $this->customerAddressRepository->getById($id);

        return $customerAddress;
    }

    public function store(array $payload)
    {
        $payload['created_by'] = 111; // mock data
        $customerAddress = $this->customerAddressRepository->create($payload);

        return $customerAddress;
    }

    public function update(array $payload, $id)
    {
        $customerAddress = $this->customerAddressRepository->updateById($id, $payload);

        return $customerAddress;
    }

    public function destroy($id)
    {
        $conn = $this->customerAddressRepository->getConnection();
        $validator = Validator::make(array('id' => $id), [
            'id' => 'exists:'.$conn.'.om_customer_addresses,id',
        ]);

        if ($validator->fails()) {
            throw new CustomerAddressException('ERR_003');
        }

        $this->customerAddressRepository->destroy(array($id));

        return;
    }
}
