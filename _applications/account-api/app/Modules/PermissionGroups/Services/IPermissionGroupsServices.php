<?php


namespace App\Modules\PermissionGroups\Services;

/**
 * PermissionGroups Service
 * @package App\Modules\PermissionGroups\Services
 */
interface IPermissionGroupsServices
{
    /**
     * Danh sách nhóm quyền
     *
     * @param  array $request
     * @return array
     */
    public function index($request);

    /**
     * Tạo nhóm quyền
     *
     * @param  array $request
     * @return array
     */
    public function create($request);

    /**
     * Lưu nhóm quyền
     *
     * @param  array $input
     * @return mixed
     */
    public function crudStore($input);

    /**
     * Sửa nhóm quyền
     *
     * @param  integer $id
     * @param  array $request
     * @return array
     */
    public function edit($id, $request);

    /**
     * Cập nhật nhóm quyền
     *
     * @param  integer $id
     * @param  array $input
     * @return mixed
     */
    public function crudUpdate($id, $input);

    /**
     * Tạo nhóm quyền Default
     *
     * @return boolean
     */
    public function createDefaultPermissionGroups();
}