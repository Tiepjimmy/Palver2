<?php

namespace App\Modules\Customer\Services;

use AccountSdkDb\Modules\Master\Services\IDistrictsService;
use AccountSdkDb\Modules\Master\Services\IProvincesSevice;
use AccountSdkDb\Modules\Master\Services\IWardsSevice;
use App\Http\PalServiceErrorCode;
use App\Modules\Customer\Requests\CustomerStoreRequest;
use Common\Exceptions\PalValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use OmSdk\Exceptions\PalException;
use OmSdk\Modules\Customer\Models\Customer;
use OmSdk\Modules\Customer\Repositories\Contracts\ICustomerAddressRepository;
use OmSdk\Modules\Customer\Repositories\Contracts\ICustomerRepository;

class CustomerService
{
    protected $provincesService;
    protected $districtsService;
    protected $wardsService;
    protected $customerRepository;
    protected $customerAddressRepository;

    public function __construct(
        IProvincesSevice $provincesService,
        IDistrictsService $districtsService,
        IWardsSevice $wardsService,
        ICustomerRepository $customerRepository,
        ICustomerAddressRepository $customerAddressRepository
    )
    {
        $this->provincesService = $provincesService;
        $this->districtsService = $districtsService;
        $this->wardsService = $wardsService;
        $this->customerRepository = $customerRepository;
        $this->customerAddressRepository = $customerAddressRepository;
    }

    /**
     * Service lấy danh sách các tỉnh
     * @return array
     */
    public function getProvince()
    {
        $condition = array();
        $data = $this->provincesService->getProvinces($condition);

        return $data;
    }

    /**
     * Api lấy danh sách các quận huyện
     * @param $provinces
     * @return array
     */
    public function getDistrict($provinces)
    {
        $data = $this->districtsService->getDistricts($provinces);

        return $data;
    }

    /**
     * Service lấy danh sách phường xã
     * @param $districtId
     * @return array
     */
    public function getWards($districtId)
    {
        $data = $this->wardsService->getWards($districtId);

        return $data;
    }

    /**
     * Api lấy danh sách khách hàng
     * @param $request
     * @return mixed
     */
    public function getList($request)
    {
        $keyword = $request->filled('s') ? $request->input('s') : null;

        $total = $this->customerRepository->checkExist([
            'keyword' => $keyword
        ]);

        $listCustomer = $this->customerRepository->getMore([
            'keyword' => $keyword
        ]);

        return [
            $listCustomer,
            $total
        ];
    }

    /**
     * Api thêm mới khách hàng
     * @param CustomerStoreRequest $request
     * @return mixed
     */
    public function store($request)
    {
        $request->merge([
           'code' => Str::uuid()
        ]);

        /** @var Customer $customerStore */
        $customerStore = $this->customerRepository->create($request->toArray());

        $customerId = $customerStore->id;
        if (!Str::isUuid($customerStore->code)){
            $this->customerRepository->updateById($customerId, [
                'code' => sprintf('KH%03d', $customerId),
            ]);
        }

        if ($customerStore->province_id && $customerStore->district_id && $customerStore->ward_id) {
            $this->customerAddressRepository->create([
                'store_id' => $customerStore->store_id,
                'mobile' => $customerStore->mobile,
                'customer_id' => $customerStore->id,
                'email' => $customerStore->email,
                'address' => $customerStore->address,
                'province_id' => $customerStore->province_id,
                'district_id' => $customerStore->district_id,
                'ward_id' => $customerStore->ward_id,
                'created_by' => $customerStore->created_by,
            ]);
        }

        return $customerStore;
    }

    /**
     * Cập nhật thông tin khách hàng
     * @param $request
     * @param $id
     * @return mixed
     * @throws PalValidationException
     */
    public function update($request ,$id)
    {
        // check trùng sdt
        $conn = $this->customerRepository->getConnection();

        $validators = Validator::make($request->all(), [
            'code' => 'unique:'.$conn.'.om_customers,mobile,'.$id,
        ]);

        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',400);
        }

        $customerUpdate = $this->customerRepository->updateById($id, $request->toArray());

        return $customerUpdate;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function detail($id)
    {
        $customerData = $this->customerRepository->getById($id);

        return $customerData;
    }

}