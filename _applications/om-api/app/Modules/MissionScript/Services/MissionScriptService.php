<?php

namespace App\Modules\MissionScript\Services;

use App\Modules\MissionScript\Requests\MissionScriptRequest;
use App\Modules\MissionScript\Requests\MissionScriptStoreRequest;
use Exception;
use OmSdk\Modules\Lead\Repositories\Contracts\ILeadRepository;
use OmSdk\Modules\MissionResult\Repositories\Contracts\IMissionScriptRepository;

class MissionScriptService
{
    protected $missionScriptRepository;
    protected $leadRepository;

    /**
     * MissionScriptService constructor.
     * @param IMissionScriptRepository $_missionScriptRepository
     *  @param ILeadRepository $leadRepository
     */
    public function __construct(IMissionScriptRepository $missionScriptRepository,  ILeadRepository $leadRepository)
    {
        $this->missionScriptRepository = $missionScriptRepository;
        $this->leadRepository = $leadRepository;
    }

    /**
     * @param MissionScriptRequest $request
     * @param $limit
     * @param $offset
     * @return array
     */
    public function list($request, $limit, $offset)
    {
        $task_id = $request->filled('task_id') ? $request->task_id : null;
        $result_id = isset($request->result_id) ? $request->result_id : null;

        $condition = [
            'task_id' => $task_id,
            'result_id' => $result_id
        ];

        $total = $this->missionScriptRepository->checkExist($condition);

        $listMissionResult = $this->missionScriptRepository->getMore(
            $condition,
            [
                'limit' => $limit,
                'offset' => $offset,
            ]);

        return [
            $listMissionResult,
            $total
        ];
    }

    /**
     * @param MissionScriptStoreRequest $request
     * @return mixed
     */
    public function store($request)
    {
        $request->merge([
            'store_id' => 1
        ]);

        return $this->missionScriptRepository->create($request->all());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        return $this->missionScriptRepository->getById($id);
    }

    /**
     * @param MissionScriptStoreRequest $request
     * @param $id
     * @return mixed
     */
    public function update($request, $id)
    {
        return $this->missionScriptRepository->updateById($id, $request->toArray());
    }

    /**
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function destroy($id)
    {
        $conditionScript['mission_script_id'] = $id;
        $leadByScript = $this->leadRepository->getOne($conditionScript);

        if ($leadByScript) {
            throw new Exception('Bộ thiết lập đang được dùng để chăm sóc khách hàng');
        }

        return $this->missionScriptRepository->destroy([$id]);
    }

    /**
     * @param MissionScriptRequest $request
     * @return mixed
     */
    public function getOneScript($request)
    {
        $condition = [
            'task_id' => $request->task_id,
            'result_id' => $request->result_id
        ];

        $script = $this->missionScriptRepository->getOne($condition) ?? null;

        return $script;
    }
}
