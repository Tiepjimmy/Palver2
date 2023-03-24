<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\PermissionGroups\Controllers\Api;

use Auth;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Common\Http\Controllers\Api\AbstractApiController;
use App\Modules\PermissionGroups\Services\IPermissionGroupsServices;

use App\Modules\PermissionGroups\Http\PalServiceErrorCode;
use App\Modules\PermissionGroups\Http\PalServiceHttpStatusCode;
use App\Modules\PermissionGroups\Requests\PermissionGroupsCreateRequest;
use App\Modules\PermissionGroups\Requests\PermissionGroupsUpdateRequest;

class PermissionGroupsController extends AbstractApiController
{
    protected $perGroupSev;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(IPermissionGroupsServices $perGroupSev)
    {
        parent::__construct();
        $this->perGroupSev = $perGroupSev;
    }

    /**
     * Display a listing of the PermissionGroups.
     * GET|HEAD /PermissionGroups
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $index =  $this->perGroupSev->index($request->all());

        return $this->_responseSuccess('Xử lý thành công', $index);
    }

    /**
     * create
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request) {
        $create =  $this->perGroupSev->create($request->all());

        return $this->_responseSuccess('Xử lý thành công', $create);
    }
    
    /**
     * store
     *
     * @param  PermissionGroupsCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PermissionGroupsCreateRequest $request)
    {
        $crud = $this->perGroupSev->crudStore($request->all());

        if ($crud->status && $crud->status === 200) {
            return $this->_responseSuccess('Khởi tạo thành công', $crud->data->toArray());
        }

        throw new \Exception(__('error_code.'.PalServiceErrorCode::LOI_HE_THONG));
    }
    
    /**
     * edit
     *
     * @param  Request $request
     * @param  mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request, $id) {
        $edit =  $this->perGroupSev->edit($id, $request->all());

        return $this->_responseSuccess('Xử lý thành công', $edit);
    }
    
    /**
     * update
     *
     * @param  PermissionGroupsUpdateRequest $request
     * @param  mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PermissionGroupsUpdateRequest $request, $id)
    {
        $update = $this->perGroupSev->crudUpdate($id, $request->all());

        if ($update->status && $update->status === 200) {
            return $this->_responseSuccess('Cập nhật thành công', $update->data->toArray());
        }

        throw new \Exception(__('error_code.'.PalServiceErrorCode::LOI_HE_THONG));
    }
    
    /**
     * createDefaultPermissionGroups
     *
     * @return mixed
     */
    public function createDefaultPermissionGroups() {
        return $this->perGroupSev->createDefaultPermissionGroups();
    }
}
