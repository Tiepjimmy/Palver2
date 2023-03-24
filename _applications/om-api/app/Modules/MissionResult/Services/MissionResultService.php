<?php

namespace App\Modules\MissionResult\Services;

use App\Modules\MissionResult\Requests\MissionResultStoreRequest;
use App\Modules\MissionResult\Requests\MissionResultUpdateRequest;
use App\Modules\MissionResult\Resources\MissionResultResources;
use Common\Exceptions\PalValidationException;
use Exception;
use Illuminate\Support\Facades\Validator;
use OmSdk\Modules\Lead\Repositories\Contracts\ILeadRepository;
use OmSdk\Modules\MissionResult\Models\MissionResult;
use OmSdk\Modules\MissionResult\Repositories\Contracts\IMissionResultRepository;
use OmSdk\Modules\MissionResult\Repositories\Contracts\IMissionTaskRepository;
use OmSdk\Modules\MissionResult\Repositories\Contracts\IMissionTaskResultRepository;
use OmSdk\Modules\MissionResult\Repositories\Eloquent\MissionScriptRepository;

class MissionResultService
{
    protected $missionResultRepository;
    protected $missionTaskResultRepository;
    protected $missionTaskRepository;
    protected $leadRepository;

    public function __construct(
        IMissionResultRepository $missionResultRepository,
        IMissionTaskResultRepository $missionTaskResultRepository,
        IMissionTaskRepository $missionTaskRepository,
        ILeadRepository $leadRepository
    )
    {
        $this->missionResultRepository = $missionResultRepository;
        $this->missionTaskResultRepository = $missionTaskResultRepository;
        $this->missionTaskRepository = $missionTaskRepository;
        $this->leadRepository = $leadRepository;
    }

    /**
     * @param $request
     * @param $limit
     * @param $offset
     * @return array
     */
    public function list($request,  $limit,  $offset)
    {
        $keyword = $request->filled('s') ? $request->s : null;
        $task_id = $request->filled('task_id') ? $request->task_id : null;

        $condition = [
            'keyword' => $keyword,
            'task_id' => $task_id
        ];

        $totals = $this->missionResultRepository->checkExist($condition);

        $listMissionResult = $this->missionResultRepository->getMore(
            $condition,
            [
                'with' => [
                    'tasks'
                ],
                'limit' => $limit,
                'offset' => $offset

            ]
        );

        return [
            $listMissionResult,
            $totals
        ];
    }

    /**
     * @param MissionResultStoreRequest $request
     * @return mixed
     */
    public function store($request)
    {
        $request->merge([
            'is_active' => 1
        ]);

        /** @var MissionResult $missionResult */
        $missionResult = $this->missionResultRepository->create($request->toArray());

        if (! empty($request->task_ids) && is_array($request->task_ids)){
            $taskIds = $request->task_ids;
        } else {
            $condition['store_id'] = $missionResult->store_id;
            $tasks = $this->missionTaskRepository->getMore($condition);
            $taskIds = $tasks->pluck('id');
        }

        $missionResult->tasks()->sync($taskIds);

        return $missionResult;
    }

    /**
     * @param MissionResultUpdateRequest $request
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function update($request, $id)
    {
        if ($request->is_active == MissionResult::NOT_ACTIVE) {
            $this->resultNotUsed($id);
        }

        /** @var MissionResult $missionResult */
        $missionResult = $this->missionResultRepository->updateById($id, $request->toArray());

        if (! empty($request->task_ids) && is_array($request->task_ids)){
            $taskIds = $request->task_ids;
        } else {
            $condition['store_id'] = $missionResult->store_id;
            $tasks = $this->missionTaskRepository->getMore($condition);
            $taskIds = $tasks->pluck('id');
        }

        $missionResult->tasks()->sync($taskIds);

        return new MissionResultResources($missionResult);
    }

    /**
     * @return array
     */
    public function getAllResult($request)
    {
        $task_id = isset($request->task_id) ? $request->task_id : null;

        $condition = [
            'store_id' => 1,
            'is_active' => 1,
            'task_id' => $task_id
        ];
        return $this->missionResultRepository->getMore($condition);
    }

    /**
     * @param $id
     * @return mixed
     * @throws PalValidationException
     */
    public function destroy($id)
    {
        $conn = $this->missionResultRepository->getConnection();
        $validators = Validator::make(array('id' => $id), [
            'id' => 'exists:'.$conn.'.om_mission_results,id',
        ]);

        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',400);
        }

        $this->resultNotUsed($id);

        return $this->missionResultRepository->destroy([$id]);
    }

    /**
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function resultNotUsed($id)
    {
        $condition['result_id'] = $id;
        $condition['store_id'] = 1;
        $taskResutl = $this->missionTaskResultRepository->getMore($condition);

        if (! empty($taskResutl)) {
            $taskIds = $taskResutl->pluck('task_id');

            $conditionTask['mission_ids'] = $taskIds;
            $conditionTask['store_id'] = $taskIds;
            $leadByMission = $this->leadRepository->getOne($conditionTask);

            if ($leadByMission) {
                throw new Exception('Kết quả đang được dùng để chăm sóc khách hàng');
            }
        }

        $script = (new MissionScriptRepository())->getOne($condition);

        if ($script) {
            $conditionScript['mission_script_id'] = $script->id;
            $conditionScript['store_id'] = $script->id;
            $leadByScript = $this->leadRepository->getOne($conditionScript);

            if ($leadByScript) {
                throw new Exception('Kết quả đang được dùng để chăm sóc khách hàng');
            }
        }

        return true;
    }
}
