<?php


namespace App\Modules\Stores\Controllers\Api;

use App\Modules\Stores\Services\IStoresService;
use Common\Http\Controllers\Api\AbstractApiController;
use Illuminate\Http\Request;
/**
 * Class StoresController
 * @package App\Modules\Stores\Controllers\Api
 */
class StoresController extends AbstractApiController
{
    /** @var  IStoresService */
    public $storeService;

    public function __construct(IStoresService $storeSv)
    {
        $this->storeService = $storeSv;
    }

    /**
     * Danh sách cơ cấu tổ chức
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request){
        $store = $this->storeService->search($request->input());
        return $this->_responseSuccess('Xử lý thành công',$store);
    }

    /**
     * lấy bản ghi cơ cấu tổ chức theo id
     * @param mixed $id
     * @return mixed
     */
    public function show($id) {
        $store = $this->storeService->get($id);
        return $this->_responseSuccess('Xử lý thành công',$store);
    }

    /**
     * Các thông tin liên quan đến cơ cấu tổ chức
     * @return mixed
     */
    public function create(){
        $store = $this->storeService->create();
        return $this->_responseSuccess('Xử lý thành công',$store);
    }

    /**
     * Thêm mới cơ cấu tổ chức
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request) {
        $createStore = $this->storeService->store($request->input());
        return $this->_responseSuccess('Khởi tạo thành công',$createStore,201);
    }

    /**
     * Cập nhật cơ cấu tổ chức
     * @param mixed $id
     * @param Request $request
     * @return mixed
     */
    public function update($id,Request $request) {
        $updateStore = $this->storeService->update($id,$request->input());
        return $this->_responseSuccess('Cập nhật thành công',$updateStore,201);
    }
}
