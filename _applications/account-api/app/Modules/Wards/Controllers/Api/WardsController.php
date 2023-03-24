<?php


namespace App\Modules\Wards\Controllers\Api;

use App\Modules\Wards\Services\IWardsService;
use Common\Http\Controllers\Api\AbstractApiController;
use Illuminate\Http\Request;
/**
 * Class WardsController
 * @package App\Modules\Wards\Controllers\Api
 */
class WardsController extends AbstractApiController
{
    /** @var  IWardsService */
    public $wardsService;
    public function __construct(IWardsService $wardsSv)
    {
        $this->wardsService = $wardsSv;
    }

    /**
     * Danh sách Phường/Xã
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request){
        $Wards = $this->wardsService->search($request->input());
        return $this->_responseSuccess('Xử lý thành công',$Wards);
    }


}
