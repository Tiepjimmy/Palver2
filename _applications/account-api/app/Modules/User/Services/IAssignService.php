<?php

namespace App\Modules\User\Services;

/**
 * Interface IAssignService
 * @package App\Modules\User\Services
 */
interface IAssignService
{

    /**
     * Thêm thông tin bổ nhiệm user
     * @param numeric $userId
     * @param array $listStore
     * @param array $listJobTitle
     * @param array $listPermissionGroup
     * @return mixed
     */
    public function addAssign($userId, $listStore, $listJobTitle, $listPermissionGroup);

    /**
     * Hủy thông tin bổ nhiệm user
     * @param numeric $userId
     * @return mixed
     */
    public function removeAssign($userId);

}