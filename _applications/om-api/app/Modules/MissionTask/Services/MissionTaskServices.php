<?php

namespace App\Modules\MissionTask\Services;

use App\Modules\MissionTask\Requests\MissionTaskStoreRequest;
use App\Modules\MissionTask\Requests\MissionTaskUpdateRequest;
use Common\Exceptions\PalValidationException;
use Illuminate\Support\Facades\Validator;
use Exception;
use OmSdk\Modules\Lead\Repositories\Contracts\ILeadRepository;
use OmSdk\Modules\MissionResult\Models\MissionTask;
use OmSdk\Modules\MissionResult\Repositories\Contracts\IMissionTaskRepository;
use OmSdk\Modules\MissionResult\Repositories\Eloquent\MissionScriptRepository;

class MissionTaskServices
{
    protected $missionTaskRepository;
    protected $leadRepository;

    /**
     * MissionTaskServices constructor.
     * @param IMissionTaskRepository $missionTaskRepository
     * @param ILeadRepository $leadRepository
     */
    public function __construct(IMissionTaskRepository $missionTaskRepository, ILeadRepository $leadRepository)
    {
        $this->missionTaskRepository = $missionTaskRepository;
        $this->leadRepository = $leadRepository;
    }

    /**
     * @param $request
     * @return array
     */
    public function list($request, $limit, $offset)
    {
        $keyword = $request->filled('s') ? $request->s : null;

        $condtions = [
            's' => $keyword,
        ];

        $total = $this->missionTaskRepository->checkExist($condtions);

        $listTask = $this->missionTaskRepository->getMore($condtions ,
            [
                'limit' => $limit,
                'offset' => $offset
            ]
        );

        return [
            $listTask,
            $total
        ];
    }

    /**
     * @param MissionTaskStoreRequest $request
     * @return mixed
     */
    public function store($request)
    {
        $request->merge([
            'is_active' => 1
        ]);

        $missionStore = $this->missionTaskRepository->create($request->toArray());

        if (isset($request->is_default)) {
            if ($request->is_default == MissionTask::IS_DEFAULT) {
                $listTask = $this->missionTaskRepository->getMore([
                    'is_active' => MissionTask::IS_ACTIVE,
                    'store_id' => 1
                ]);

                foreach ($listTask as $task) {
                    $taskId = $task->id;

                    $this->missionTaskRepository->updateById($taskId, [
                        'is_default' => MissionTask::NOT_DEFAULT
                    ]);
                }

                $missionTaskId = $missionStore->id;
                $missionStore = $this->missionTaskRepository->updateById($missionTaskId, [
                    'is_default' => MissionTask::IS_DEFAULT
                ]);
            }
        }

        return $missionStore;
    }

    /**
     * @param MissionTaskUpdateRequest $request
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function update($request, $id)
    {
        if ($request->is_active == MissionTask::NOT_ACTIVE) {
            $this->taskNotUsed($id);
        }

        $missionUpdate = $this->missionTaskRepository->updateById($id, $request->toArray());

        if (isset($request->is_default)) {
            if ($request->is_default == MissionTask::IS_DEFAULT) {
                $listTask = $this->missionTaskRepository->getMore([
                    'store_id' => 1,
                    'is_active' => MissionTask::IS_ACTIVE
                ]);

                foreach ($listTask as $task) {
                    $taskId = $task->id;

                    $this->missionTaskRepository->updateById($taskId, [
                        'is_default' => MissionTask::NOT_DEFAULT
                    ]);
                }

                $missionUpdate = $this->missionTaskRepository->updateById($id, [
                    'is_default' => MissionTask::IS_DEFAULT
                ]);
            }
        }

        return $missionUpdate;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        $storeId = 1;

        $condtions = [
            'store_id' => $storeId,
            'is_active' => 1
        ];
        $fetchOptions['select'] = ['id', 'name', 'is_active'];

        return $this->missionTaskRepository->getMore($condtions, $fetchOptions);
    }

    /**
     * @param $id
     * @return mixed
     * @throws PalValidationException
     * @throws Exception
     */
    public function destroy($id)
    {
        $conn = $this->missionTaskRepository->getConnection();
        $validators = Validator::make(array('id' => $id), [
            'id' => 'exists:'.$conn.'.om_mission_tasks,id',
        ]);

        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',400);
        }

        $this->taskNotUsed($id);

        return $this->missionTaskRepository->destroy([$id]);
    }

    /**
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function taskNotUsed($id)
    {
        $condition['mission_id'] = $id;
        $condition['store_id'] = 1;
        $leadByMission = $this->leadRepository->getOne($condition);

        if ($leadByMission) {
            throw new Exception('Nhiệm vụ đang được dùng để chăm sóc khách hàng');
        }

        $conditionScipt['task_id'] = $id;
        $script = (new MissionScriptRepository())->getOne($conditionScipt);

        if ($script) {
            $conditionScript['mission_script_id'] = $script->id;
            $conditionScript['store_id'] = $script->id;
            $leadByScript = $this->leadRepository->getOne($conditionScript);

            if ($leadByScript) {
                throw new Exception('Nhiệm vụ đang được dùng để chăm sóc khách hàng');
            }
        }

        return true;
    }
}
