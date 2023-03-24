<?php

namespace App\Modules\MissionTask\Controllers\Api;

use App\Http\PalServiceErrorCode;
use App\Modules\MissionTask\Requests\MissionTaskStoreRequest;
use App\Modules\MissionTask\Requests\MissionTaskUpdateRequest;
use App\Modules\MissionTask\Resources\MissionTaskResource;
use App\Modules\MissionTask\Services\MissionTaskServices;
use Common\Http\Controllers\Api\AbstractApiController;
use Illuminate\Http\Request;

class MissionTaskController extends AbstractApiController
{
    protected $missionService;

    /**
     * MissionTaskController constructor.
     * @param MissionTaskServices $missionService
     */
    public function __construct(MissionTaskServices $missionService)
    {
        parent::__construct();

        $this->missionService = $missionService;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $limit = $request->filled('limit') &&
        is_numeric($request->input('limit')) ? (int)$request->input('limit') : 10;
        $offset = $request->filled('offset') &&
        is_numeric($request->input('offset')) ? (int)$request->input('offset') : 0;

        [$data, $total] = $this->missionService->list($request, $limit, $offset);

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR,
            [
                'items' => MissionTaskResource::collection($data),
                'total' => $total,
                'limit' => $limit,
                'offset' => $offset
            ]
        );
    }

    /**
     * @param MissionTaskStoreRequest $request
     * @return mixed
     */
    public function store(MissionTaskStoreRequest $request)
    {
        $missionTaskStore = $this->missionService->store($request);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $missionTaskStore);
    }

    /**
     * @param MissionTaskUpdateRequest $request
     * @param $id
     * @return mixed
     */
    public function update(MissionTaskUpdateRequest $request, $id)
    {
        $missionTaskUpdate = $this->missionService->update($request, $id);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $missionTaskUpdate);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $missionTaskUpdate = $this->missionService->destroy($id);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $missionTaskUpdate);
    }

    /**
     * @return mixed
     */
    public function allTask()
    {
        $data = $this->missionService->getAll();

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR ,
            [
                'items' => MissionTaskResource::collection($data)
            ]
        );

    }
}
