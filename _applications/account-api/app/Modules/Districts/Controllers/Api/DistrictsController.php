<?php


namespace App\Modules\Districts\Controllers\Api;

use App\Modules\Districts\Services\IDistrictsService;
use Common\Http\Controllers\Api\AbstractApiController;
use Illuminate\Http\Request;
/**
 * Class DistrictsController
 * @package App\Modules\Districts\Controllers\Api
 */
class DistrictsController extends AbstractApiController
{
    /** @var  IDistrictsService */
    public $districtsService;
    public function __construct(IDistrictsService $districtsSv)
    {
        $this->districtsService = $districtsSv;
    }

    /**
     * Danh sách Quận/Huyện
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request){
        $districts = $this->districtsService->search($request->input());
        return $this->_responseSuccess('Xử lý thành công',$districts);
    }
}
