<?php

namespace App\Modules\MissionResult\Controllers\Api;

use App\Http\PalServiceErrorCode;
use App\Modules\MissionResult\Requests\MissionResultStoreRequest;
use App\Modules\MissionResult\Requests\MissionResultUpdateRequest;
use App\Modules\MissionResult\Resources\MissionResultResources;
use App\Modules\MissionResult\Services\MissionResultService;
use Common\Http\Controllers\Api\AbstractApiController;
use Illuminate\Http\Request;

class MissionResultController extends AbstractApiController
{
    protected $missionResultService;

    /**
     * MissionResultController constructor.
     * @param MissionResultService $missionResultService
     */
    public function __construct(MissionResultService $missionResultService)
    {
        parent::__construct();

        $this->missionResultService = $missionResultService;
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

        [$items, $total] = $this->missionResultService->list($request, $limit, $offset);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, [
            'items' => $items,
            'total' => $total,
            'limit' => $limit
        ]);
    }

    /**
     * @param MissionResultStoreRequest $request
     * @return mixed
     */
    public function store(MissionResultStoreRequest $request)
    {
        $missionResultStore = $this->missionResultService->store($request);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $missionResultStore);
    }

    /**
     * @param MissionResultUpdateRequest $request
     * @param $id
     * @return mixed
     */
    public function update(MissionResultUpdateRequest $request, $id)
    {
        $missionResultUpdate = $this->missionResultService->update($request, $id);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $missionResultUpdate);
    }

    /**
     * @return mixed
     */
    public function allResult(Request $request)
    {
        $missionResultData = $this->missionResultService->getAllResult($request);

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR,
            [
                'items' => MissionResultResources::collection($missionResultData)
            ]
        );
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $missionResultDestroy = $this->missionResultService->destroy($id);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $missionResultDestroy);
    }
}
