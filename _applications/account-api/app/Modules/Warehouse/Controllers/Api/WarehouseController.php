<?php


namespace App\Modules\Warehouse\Controllers\Api;

use App\Modules\Warehouse\Services\IWarehouseService;
use Common\Http\Controllers\Api\AbstractApiController;
use Illuminate\Http\Request;
/**
 * Class WarehouseController
 * @package App\Modules\Warehouse\Controllers\Api
 */
class WarehouseController extends AbstractApiController
{
    /** @var  IWarehouseService */
    protected $warehouseervice;

    public function __construct(IWarehouseService $warehoussv)
    {
        $this->warehouseervice = $warehoussv;
    }

    /**
     * Danh sách kho
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request){
        $Warehouses = $this->warehouseervice->search($request->input());
        return $this->_responseSuccess('Xử lý thành công',$Warehouses);
    }

    /**
     * lấy bản ghi kho theo id
     * @param mixed $id
     * @return mixed
     */
    public function show($id) {
        $Warehouses = $this->warehouseervice->get($id);
        return $this->_responseSuccess('Xử lý thành công',$Warehouses);
    }

    /**
     * Các thông tin liên quan đến kho
     * @return mixed
     */
    public function create(){
        $Warehouses = $this->warehouseervice->create();
        return $this->_responseSuccess('Xử lý thành công',$Warehouses);
    }

    /**
     * Thêm mới kho
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request) {
        $createWarehouses = $this->warehouseervice->store($request->input());
        return $this->_responseSuccess('Khởi tạo thành công',$createWarehouses,201);
    }

    /**
     * Cập nhật kho
     * @param mixed $id
     * @param Request $request
     * @return mixed
     */
    public function update($id,Request $request) {
        $updateWarehouses = $this->warehouseervice->update($id,$request->input());
        return $this->_responseSuccess('Cập nhật thành công',$updateWarehouses,201);
    }


}
