<?php

namespace App\Modules\Order\Controllers\Api;

use App\Modules\Order\Services\OrderProduct\GetByStoreService;
use Common\Http\Controllers\Api\AbstractApiController;
use App\Modules\Order\Requests\OrderProduct\GetByStoreRequest;

class OrderProductController extends AbstractApiController
{
    protected $getByStoreService;

    public function __construct(GetByStoreService $getByStoreService)
    {
        parent::__construct();

        $this->getByStoreService = $getByStoreService;
    }

    public function getByStore(GetByStoreRequest $request)
    {
        try {
            $payload = $request->only(['store_id', 'keyword', 'limit']);

            $appendData = $this->getByStoreService->execute($payload);
        } catch (\Exception $e) {
            throw $e;
        }
        return $this->_responseSuccess('Lấy danh sách thành công', $appendData);
    }
}
