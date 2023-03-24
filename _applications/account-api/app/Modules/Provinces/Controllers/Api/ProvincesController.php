<?php


namespace App\Modules\Provinces\Controllers\Api;

use App\Modules\Provinces\Services\IProvincesService;
use Common\Http\Controllers\Api\AbstractApiController;
use Illuminate\Http\Request;
/**
 * Class ProvincesController
 * @package App\Modules\Provinces\Controllers\Api
 */
class ProvincesController extends AbstractApiController
{
    /** @var  IProvincesService */
    public $provincesService;
    public function __construct(IProvincesService $provincesSv)
    {
        $this->provincesService = $provincesSv;
    }

    /**
     * Danh sách Thành phố/Tỉnh
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request){
        $provinces = $this->provincesService->search($request->input());
        return $this->_responseSuccess('Xử lý thành công',$provinces);
    }


}
