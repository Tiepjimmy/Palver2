<?php

namespace App\Modules\Lead\Controllers\Api;

use App\Http\PalServiceErrorCode;
use App\Modules\Lead\Requests\LeadStoreRequest;
use App\Modules\Lead\Resources\LeadResource;
use App\Modules\Lead\Services\LeadServices;
use App\Modules\Lead\Requests\LeadUpdateRequest;
use Common\Http\Controllers\Api\AbstractApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OmSdk\Exceptions\PalException;

class LeadController extends AbstractApiController
{
    protected $leadService;

    public function __construct(LeadServices $leadService)
    {
        parent::__construct();

        $this->leadService = $leadService;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $offset = (int) $request->offset;
        $limit = (int) $request->limit;
        $limit = $limit > 100 ? 100 : $limit;

        [$items, $total] = $this->leadService->list($request, $limit, $offset);

        return $this->_responseSuccess(
            PalServiceErrorCode::NO_ERROR,
            [
                'items' => LeadResource::collection($items),
                'total' => $total,
                'limit' => $limit
            ]
        );
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        try {
            $data = $this->leadService->show($id);

            return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $data);
        } catch (\Exception $exception) {
            return $this->_responseError(PalServiceErrorCode::LOI_HE_THONG, [], 500);
        }

    }

    /**
     * @param LeadStoreRequest $request
     * @return mixed
     */
    public function store(LeadStoreRequest $request)
    {
        try {
            $store = $this->leadService->store($request);

            return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $store);
        } catch (\Exception $exception) {
            Log::info($exception);
            return $this->_responseError(PalServiceErrorCode::LOI_HE_THONG, [], 500);
        }
    }

    /**
     * @param $id
     * @param LeadUpdateRequest $request
     * @return mixed
     */
    public function update($id, LeadUpdateRequest $request)
    {
        try {
            $update = $this->leadService->update($id, $request);

            return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $update);
        } catch (\Exception $exception) {
            return $this->_responseError(PalServiceErrorCode::LOI_HE_THONG, [], 500);
        }
    }

    /**
     * @param $id
     * @param LeadUpdateRequest $request
     * @return mixed
     */
    public function updateBySale($id, LeadUpdateRequest $request)
    {
        try {
            $update = $this->leadService->updateBySale($id, $request);

            return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $update);
        } catch (\Exception $exception) {
            return $this->_responseError(PalServiceErrorCode::LOI_HE_THONG, [], 500);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        try {
            $deleted = $this->leadService->destroy($id);

            return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $deleted);
        } catch (\Exception $exception) {
            return $this->_responseError(PalServiceErrorCode::LOI_HE_THONG, [], 500);
        }
    }
    /**
     * @param $id
     * @return mixed
     */
    public function reject($id)
    {
        try {
            $reject = $this->leadService->reject($id);

            return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $reject);
        } catch (\Exception $exception) {
            return $this->_responseError(PalServiceErrorCode::LOI_HE_THONG, [], 500);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function accept($id)
    {
        try {
            $accept = $this->leadService->accept($id);

            return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $accept);
        } catch (\Exception $exception) {
            return $this->_responseError(PalServiceErrorCode::LOI_HE_THONG, [], 500);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function cancel($id)
    {
        try {
            $cancel = $this->leadService->cancel($id);

            return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $cancel);
        } catch (\Exception $exception) {
            return $this->_responseError(PalServiceErrorCode::LOI_HE_THONG, [], 500);
        }
    }

    /**
     * @param $string
     * @return mixed
     */
    public function checkDuplicate($string)
    {
        try {
            $data = $this->leadService->checkDuplicate($string);

            return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $data);
        } catch (\Exception $exception) {
            return $this->_responseError(PalServiceErrorCode::LOI_HE_THONG, [], 500);
        }
    }

    /**
     * @return mixed
     */
    public function listStatus()
    {
        try {
            $data = $this->leadService->getListStatus();

            return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $data);
        } catch (\Exception $exception) {
            return $this->_responseError(PalServiceErrorCode::LOI_HE_THONG, [], 500);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assignSaleGroup(Request $request)
    {
        try {
            $saleGroupIds = (array) $request->get('sale_group');
            $leadIds = (array) $request->get('leadIds');

            if (empty($saleGroupIds)) {
                throw new PalException(PalServiceErrorCode::LOI_PHAT_SINH);
            }

            if (! empty($leadIds)) {
                $this->leadService->assignSaleGroup($saleGroupIds, $leadIds);
            } else {
                $this->leadService->assignSaleGroupAll($saleGroupIds);
            }

            return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, []);
        } catch (PalException $exception) {
            // @TODO: Log exception here
            Log::info(__METHOD__, [$exception]);

            return $this->_responseError($exception->getMessage(), [], $exception->getCode());
        } catch (\Exception $exception) {
            // @TODO: Log exception here
            Log::info(__METHOD__, [$exception]);

            return $this->_responseError(PalServiceErrorCode::LOI_HE_THONG, [], 500);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function assignUser(Request $request)
    {
        try {
            $userIds = (array) $request->get('users');
            $leadIds = (array) $request->get('leadIds');

            if (empty($userIds)) {
                throw new PalException(PalServiceErrorCode::LOI_PHAT_SINH);
            }

            if (! empty($leadIds)) {
                $this->leadService->assignUser($userIds, $leadIds);
            } else {
                $this->leadService->assignUserAll($userIds);
            }
        } catch (PalException $exception) {
            // @TODO: Log exception here
            Log::info(__METHOD__, [$exception]);

            return $this->_responseError($exception->getMessage(), [], $exception->getCode());
        } catch (\Exception $exception) {
            // @TODO: Log exception here
            Log::info(__METHOD__, [$exception]);

            return $this->_responseError(PalServiceErrorCode::LOI_HE_THONG, [], 500);
        }

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, []);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function settingAssignUser(Request $request)
    {
        try {
            $settings = (array) $request->get('user_assign_settings');

            $this->leadService->saveSettingAssignUser($settings);
        } catch (PalException $exception) {
            // @TODO: Log exception here
            Log::info(__METHOD__, [$exception]);

            return $this->_responseError($exception->getMessage(), [], $exception->getCode());
        } catch (\Exception $exception) {
            // @TODO: Log exception here
            Log::info(__METHOD__, [$exception]);

            return $this->_responseError(PalServiceErrorCode::LOI_HE_THONG, [], 500);
        }

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, []);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function settingAssignSaleGroup(Request $request)
    {
        try {
            $settings = (array) $request->get('group_assign_settings');

            $this->leadService->saveSettingAssignSaleGroup($settings);
        } catch (PalException $exception) {
            // @TODO: Log exception here
            Log::info(__METHOD__, [$exception]);

            return $this->_responseError($exception->getMessage(), [], $exception->getCode());
        } catch (\Exception $exception) {
            // @TODO: Log exception here
            Log::info(__METHOD__, [$exception]);

            return $this->_responseError(PalServiceErrorCode::LOI_HE_THONG, [], 500);
        }

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, []);
    }

    /**
     * @return mixed
     */
    public function getTotalLeaByStatus()
    {
        try {
            $data = $this->leadService->getTotalLeadByStatus();
        } catch (PalException $exception) {
            // @TODO: Log exception here
            Log::info(__METHOD__, [$exception]);

            return $this->_responseError($exception->getMessage(), [], $exception->getCode());
        } catch (\Exception $exception) {
            // @TODO: Log exception here

            return $this->_responseError(PalServiceErrorCode::LOI_HE_THONG, [], 500);
        }

        return $this->_responseSuccess(PalServiceErrorCode::NO_ERROR, $data);
    }
}