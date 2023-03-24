<?php


namespace App\Modules\ProductCatalogs\Controllers\Api;

use App\Modules\ProductCatalogs\Services\IProductCatalogsService;
use Common\Http\Controllers\Api\AbstractApiController;
use Illuminate\Http\Request;
/**
 * Class ProductCatalogsController
 * @package App\Modules\ProductCatalogs\Controllers\Api
 */
class ProductCatalogsController extends AbstractApiController
{
    /** @var  IProductCatalogsService */
    public $productCatalogService;
    public function __construct(IProductCatalogsService $productCatalogSv)
    {
        $this->productCatalogService = $productCatalogSv;
    }

    /**
     * Danh sách loại sản phẩm
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request){
        $productCatalog = $this->productCatalogService->search($request->input());
        return $this->_responseSuccess('Xử lý thành công',$productCatalog);
    }

    /**
     * Lấy bản ghi loại sản phẩm theo id
     * @param mixed $id
     * @return mixed
     */
    public function show($id) {
        $productCatalog = $this->productCatalogService->get($id);
        return $this->_responseSuccess('Xử lý thành công',$productCatalog);
    }

    /**
     * Các thông tin liên quan đến loại sản phẩm
     * @return mixed
     */
    public function create(){
        $productCatalog = $this->productCatalogService->create();
        return $this->_responseSuccess('Xử lý thành công',$productCatalog);
    }
    /**
     * Thêm mới loại sản phẩm
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request) {
        $createProductCatalog = $this->productCatalogService->store($request->input());
        return $this->_responseSuccess('Khởi tạo thành công',$createProductCatalog,201);
    }
    /**
     * Cập nhật loại sản phẩm
     * @param mixed $id
     * @param Request $request
     * @return mixed
     */
    public function update($id,Request $request) {
        $updateProductCatalog = $this->productCatalogService->update($id,$request->input());
        return $this->_responseSuccess('Cập nhật thành công',$updateProductCatalog,201);
    }


}
