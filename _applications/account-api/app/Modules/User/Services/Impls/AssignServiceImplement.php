<?php

namespace App\Modules\User\Services\Impls;

use App\Modules\User\Services\IAssignService;
use Illuminate\Support\Facades\Event;
use Common\Exceptions\PalException;
use App\Modules\User\Events\AssignInsertEvent;
use App\Modules\User\Events\AssignPermissionGroupInsertEvent;
use App\Modules\User\Repositories\Contracts\AssignInterface;
use App\Modules\User\Repositories\Contracts\AssignPermissionGroupInterface;

/**
 * @inheritDoc
 */
class AssignServiceImplement implements IAssignService
{
    protected $assignInterface;
    protected $assignPermissionGroupRepository;

    /**
     * AssignServiceImplement constructor.
     * @param AssignInterface $assignRepository
     * @param AssignPermissionGroupInterface $assignPermissionGroupRepository
     */
    public function __construct(AssignInterface $assignRepository,
                                AssignPermissionGroupInterface $assignPermissionGroupRepository
    )
    {
        $this->assignInterface = $assignRepository;
        $this->assignPermissionGroupRepository = $assignPermissionGroupRepository;
    }

    /**
     * @inheritDoc
     */
    public function addAssign($userId, $listStore, $listJobTitle, $listPermissionGroup) {
        $createdAssign = null;
        $createdAssignPermissionGroup = null;

        foreach ($listStore as $index => $storeId) {
            $createdAssign = $this->assignInterface->create(array(
                'store_id' => $storeId,
                'user_id' => $userId,
                'job_title_id' => $listJobTitle[$index]
            ));

            foreach ($listPermissionGroup as $permissionGroup) {
                $createdAssignPermissionGroup = $this->assignPermissionGroupRepository->create(array(
                    'assign_id' => $createdAssign->id,
                    'permission_group_id' => $permissionGroup
                ));
            }
        }

        if (!is_null($createdAssign)) {
            Event::dispatch(new AssignInsertEvent($createdAssign));
            Event::dispatch(new AssignPermissionGroupInsertEvent($createdAssignPermissionGroup));
        } else {
            throw new PalException('E000001');
        }
    }

    /**
     * @inheritDoc
     */
    public function removeAssign($userId) {
        $assign = $this->assignInterface->getMore(
            array(
                'user_id' => $userId
            )
        );
        $listAssignId = $assign->map(function ($assign) {
            return $assign->id;
        });
        $this->assignInterface->delByCond(
            array(
                'user_id' => $userId
            )
        );
        $this->assignPermissionGroupRepository->delByCond(
            array(

                'list_assign_id' => $listAssignId
            )
        );
    }
}
