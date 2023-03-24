<?php

namespace App\Modules\Order\Controllers\Api;

use Common\Http\Controllers\Api\AbstractApiController;

use Illuminate\Http\Request;
use App\Modules\Order\Requests\Statuses\StatusRequest;

use App\Modules\Order\Services\StatusesServices;
use App\Modules\Order\Resources\StatusResource;

class StatusController extends AbstractApiController
{
    protected $statusesService;

    public function __construct(StatusesServices $statusesServices)
    {
        parent::__construct();

        $this->statusesService = $statusesServices;
    }

    public function list(Request $request)
    {
        try {
            $payload = $request->only(['store_id', 'page', 'limit', 'keyword', 'level', 'type']);

            $statuses = $this->statusesService->list($payload);
            $appendData = new StatusResource($statuses);
        } catch (\Exception $e) {
            throw $e;
        }
        return $this->_responseSuccess('Lấy danh sách thành công', $appendData);
    }

    public function show($statuses_id)
    {
        try {
            $statuses = $this->statusesService->show($statuses_id);
            $appendData = new StatusResource($statuses);
        } catch (\Exception $e) {
            throw $e;
        }
        return $this->_responseSuccess('Lấy chi tiết thành công', $appendData);
    }

    public function store(StatusRequest $request)
    {
        try {
            $payload = $request->only(['store_id', 'name', 'code', 'color', 'description', 'level', 'type', 'action_name', 'is_no_revenue', 'is_active']);
            $payload = array_merge($payload, array('created_by' => 1));
            $statuses = $this->statusesService->store($payload);

            $appendData = new StatusResource($statuses);
        } catch (\Exception $e) {
            throw $e;
        }

        return $this->_responseSuccess('Tạo mới thành công', $appendData);
    }

    public function update(StatusRequest $request, $statuses_id)
    {
        try {
            $payload = $request->only(['name', 'code', 'color', 'description', 'level', 'type', 'action_name', 'is_no_revenue', 'is_active']);
            $statuses = $this->statusesService->update($payload, $statuses_id);

            $appendData = new StatusResource($statuses);
        } catch (\Exception $e) {
            throw $e;
        }

        return $this->_responseSuccess('Cập nhật thành công', $appendData);
    }

    public function destroy($statuses_id)
    {
        try {
            $this->statusesService->destroy($statuses_id);
        } catch (\Exception $e) {
            throw $e;
        }

        return $this->_responseSuccess('Xoá thành công');
    }
}
