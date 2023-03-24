<?php

namespace App\Modules\PrintForm\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\PalServiceErrorCode;
use App\Modules\PrintForm\Requests\PrintFormRequest;
use App\Modules\PrintForm\Services\PrintFormServices;
use App\Modules\PrintForm\Resources\PrintFormResource;
use Common\Http\Controllers\Api\AbstractApiController;
use App\Modules\PrintForm\Requests\PrintFormStoreRequest;
use App\Modules\PrintForm\Requests\PrintFormUpdateRequest;
use App\Modules\PrintForm\Resources\PrintFormSystemResource;
use Throwable;

class PrintFormController extends AbstractApiController
{
    protected $printFormService;

    public function __construct(PrintFormServices $printFormService)
    {
        parent::__construct();
        $this->printFormService = $printFormService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PrintFormRequest $request)
    {
        $limit = $request->limit ? (int)$request->limit : 10;
        $offset = $request->offset ? (int)$request->offset : 0;
        [$data, $total] = $this->printFormService->getList($request, $limit, $offset);

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR,
            [
                'items' =>  PrintFormResource::collection($data),
                'total' => $total,
                'limit' => $limit,
            ]
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrintFormStoreRequest $request)
    {
        try {
            $payload = $request->only(['store_id', 'title', 'type', 'content', 'is_default', ]);
            $receipts = $this->printFormService->store($payload);

            return $this->_responseSuccess('Tạo mẫu in thành công', []);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * Lấy danh sách shortcode của mẫu in
     *
     * @param      \Illuminate\Http\Request  $rquest  The rquest
     *
     * @return     Response
     */
    public function shortcode(Request $rquest)
    {
        return $this->_responseSuccess('Lấy danh sách short code thành công', config('print'));
    }

    /**
     * Lấy danh sách mẫu in hệ thống
     *
     * @param      \Illuminate\Http\Request  $rquest  The rquest
     *
     * @return     Response
     */
    public function systemForms(Request $rquest)
    {
        try {
            return $this->_responseSuccess(
                'Tạo mẫu in thành công',
                new PrintFormSystemResource($this->printFormService->getSystemForms())
            );
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->printFormService->show($id);

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR,
            $data
        );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PrintFormUpdateRequest $request, $id)
    {
        $printFormUpdate = $this->printFormService->update($request->all(), $id);

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $printFormUpdate);
    }
}
