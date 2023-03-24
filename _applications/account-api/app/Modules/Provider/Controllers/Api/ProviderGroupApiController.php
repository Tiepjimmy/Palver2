<?php

namespace App\Modules\Provider\Controllers\Api;

use Illuminate\Http\Request;
use Common\Http\Controllers\Api\AbstractApiController;
use App\Modules\Provider\Services\IProviderService;

class ProviderGroupApiController extends AbstractApiController
{
    private $providerService;

    public function __construct(
        IProviderService $providerService
    ) {
        parent::__construct();
        $this->providerService = $providerService;
    }

    /**
     * Lưu thông tin tạo mới nhóm nhà cung cấp
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $storedProviderGroup = $this->providerService->storeProviderGroup($request->all());
        return $this->_responseSuccess('Xử lý thành công', $storedProviderGroup);
    }
}
