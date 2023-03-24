<?php

namespace App\Modules\MissionScript\Controllers\Api;

use App\Http\PalServiceErrorCode;
use App\Modules\MissionScript\Requests\MissionScriptRequest;
use App\Modules\MissionScript\Requests\MissionScriptStoreRequest;
use App\Modules\MissionScript\Requests\MissionScriptUpdateRequest;
use App\Modules\MissionScript\Resources\MissionScriptResources;
use App\Modules\MissionScript\Services\MissionScriptService;
use Common\Http\Controllers\Api\AbstractApiController;

class MissionScriptController extends AbstractApiController
{
    protected $missionScriptService;

    /**
     * MissionScriptController constructor.
     * @param MissionScriptService $missionScriptService
     */
    public function __construct(MissionScriptService $missionScriptService)
    {
        parent::__construct();

        $this->missionScriptService = $missionScriptService;
    }

    /**
     * @param MissionScriptRequest $request
     * @return mixed
     */
    public function index(MissionScriptRequest $request)
    {
        $limit = $request->filled('limit') &&
            is_numeric($request->input('limit')) ? (int)$request->input('limit') : 10;
        $offset = $request->filled('offset') &&
        is_numeric($request->input('offset')) ? (int)$request->input('offset') : 0;

        [$data, $total] = $this->missionScriptService->list($request, $limit, $offset);

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR,
            [
                'items' => MissionScriptResources::collection($data),
                'total' => $total,
                'limit' => $limit,
                'offset' => $offset
            ]
        );
    }

    /**
     * @param MissionScriptStoreRequest $request
     * @return mixed
     */
    public function store(MissionScriptStoreRequest $request)
    {
        $missionResultStore = $this->missionScriptService->store($request);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $missionResultStore);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        try {
            $data = $this->missionScriptService->edit($id);

            return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $data);
        } catch (\Exception $exception) {
            return $this->_responseError(PalServiceErrorCode::LOI_HE_THONG, [], 500);
        }
    }

    /**
     * @param MissionScriptUpdateRequest $request
     * @param $id
     * @return mixed
     */
    public function update(MissionScriptUpdateRequest $request ,$id)
    {
        $missionResultUpdate = $this->missionScriptService->update($request, $id);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $missionResultUpdate);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $missionScriptDestroy = $this->missionScriptService->destroy($id);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $missionScriptDestroy);

    }

    /**
     * @param MissionScriptRequest $request
     * @return mixed
     */
    public function getOneScript(MissionScriptRequest $request)
    {
        $data = $this->missionScriptService->getOneScript($request);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $data);
    }
}
