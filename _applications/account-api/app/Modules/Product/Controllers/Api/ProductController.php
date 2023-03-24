<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\Product\Controllers\Api;

use Auth;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Common\Http\Controllers\Api\AbstractApiController;
use AccountSdkDb\Modules\Store\Services\IAssignmentStoreService;
use App\Modules\Product\Services\IProductEntityServices;
use App\Modules\Product\Services\IProductServices;
use App\Modules\Product\Services\IRetailProductEntityServices;
use App\Modules\Product\Services\IRetailProductServices;

class ProductController extends AbstractApiController
{
    protected $proSev;
    protected $sdkProSev;
    protected $storeSev;
    protected $retailProSev;
    protected $retailProEntitySev;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(IProductServices $proSev,
                                IProductEntityServices $sdkProSev,
                                IAssignmentStoreService $storeSev,
                                IRetailProductServices $retailProSev,
                                IRetailProductEntityServices $retailProEntitySev)
    {
        parent::__construct();
        $this->proSev = $proSev;
        $this->sdkProSev = $sdkProSev;
        $this->storeSev = $storeSev;
        $this->retailProSev = $retailProSev;
        $this->retailProEntitySev = $retailProEntitySev;
    }

    /**
     * Check tổng công ty, chi nhánh
     * @return \Illuminate\Http\JsonResponse
     */
    public function ownerShop() {
        return $this->_responseSuccess('Xử lý thành công', $this->checkStore());
    }

    /**
     * Danh sách sản phẩm
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) {
        if ($this->checkStore()) {
            $index = $this->proSev->search($request->all());
        } else {
            $index = $this->retailProSev->search($request->all());
        }
        return $this->_responseSuccess('Xử lý thành công', $index);
    }

    /**
     * Tím kiếm sản phẩm chuẩn hoá
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchProduct(Request $request) {
        $index =  $this->proSev->search($request->all());
        return $this->_responseSuccess('Xử lý thành công', $index);
    }

    /**
     * Tìm kiếm sản phẩm biến thể
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchEntity(Request $request) {
        if ($this->checkStore()) {
            $index =  $this->sdkProSev->search($request->all());
        } else {
            $index =  $this->retailProEntitySev->search($request->all());
        }
        return $this->_responseSuccess('Xử lý thành công', $index);
    }

    /**
     * Chi tiết sản phẩm
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) {
        if ($this->checkStore()) {
            $show =  $this->proSev->getById($id);
        } else {
            $show =  $this->retailProSev->getById($id);
        }
        return $this->_responseSuccess('Xử lý thành công', $show);
    }

    /**
     * Thông tin tạo sản phẩm
     * @return \Illuminate\Http\JsonResponse
     */
    public function create() {
        $create =  $this->proSev->create();
        return $this->_responseSuccess('Xử lý thành công', $create);
    }

    /**
     * Lưu sản phẩm
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $input = $request->all();
        if (!$request->filled('product_cd')) {
            $input['product_cd'] = '';
        }
        if (!$request->filled('quantity')) {
            $input['quantity'] = 0;
        }
        // if (!$request->filled('don_vi_tinh')) {
        //     $input['don_vi_tinh'] = '';
        // }
        if (!$request->filled('description')) {
            $input['description'] = '';
        }
        if (!$request->filled('old_prices')) {
            $input['old_prices'] = 0;
        }
        if (!$request->filled('old_wholesale_prices')) {
            $input['old_wholesale_prices'] = 0;
        }
        if (!$request->filled('old_cost_prices')) {
            $input['old_cost_prices'] = 0;
        }
        $product_type = $request->input('product_type', 'single');

        if ($this->checkStore()) {
            if ($product_type == 'single') {
                $sanPham = $this->proSev->store($input);
            } else {
                $sanPham = $this->proSev->storeCombo($input);
            }
        } else {
            if ($product_type == 'single') {
                $sanPham = $this->retailProSev->store($input);
            } else {
                $sanPham = $this->retailProSev->storeCombo($input);
            }
        }
        

        return $this->_responseSuccess('Tạo mới thành công', $sanPham);
    }

    /**
     * Cập nhật sản phẩm
     * @param integer $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update($id, Request $request)
    {
        $product_type = $request->input('product_type', 'single');
        if ($this->checkStore()) {
            if ($product_type == 'single') {
                $sanPham = $this->proSev->update($id, $request->all());
            } else {
                $sanPham = $this->proSev->updateCombo($id, $request->all());
            }
        } else {
            if ($product_type == 'single') {
                $sanPham = $this->retailProSev->update($id, $request->all());
            } else {
                $sanPham = $this->retailProSev->updateCombo($id, $request->all());
            }
        }

        return $this->_responseSuccess('cập nhật thành công', $sanPham);
    }

    /**
     * Check Tổng công ty hay chi nhánh
     * @return bool
     */
    private function checkStore() {
        return $this->storeSev->checkStoreIsOwnerOrBranch();
    }

    public function importSingle(Request $request) {
        $input = $request->all();

        if ($this->checkStore()) {
            $sanPham = $this->proSev->importSingle($input);
        } else {
            $sanPham = $this->proSev->importSingleBranch($input);
        }
        
        return $this->_responseSuccess('Import thành công', $sanPham);
    }

    public function importCombo(Request $request) {
        $input = $request->all();

        if ($this->checkStore()) {
            $sanPham = $this->proSev->importCombo($input);
        } else {
            $sanPham = $this->proSev->importComboBranch($input);
        }
        
        return $this->_responseSuccess('Import thành công', $sanPham);
    }

    /**
     * destroy sản phẩm
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id) {
        if ($this->checkStore()) {
            $index = $this->proSev->delete($id);
        } else {
            $index = $this->retailProSev->delete($id);
        }
        return $this->_responseSuccess('Xử lý thành công', $index);
    }
}
