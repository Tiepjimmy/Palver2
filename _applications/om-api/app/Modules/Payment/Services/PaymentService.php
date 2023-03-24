<?php

namespace App\Modules\Payment\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use OmSdk\Exceptions\PalException;
use OmSdk\Exceptions\PalValidationException;
use OmSdk\Modules\Campaign\Repositories\Contracts\ICampaignRepository;
use OmSdk\Modules\Payment\Models\PaymentAccount;
use OmSdk\Modules\Payment\Repositories\Contracts\IPaymentAccountRepository;
use OmSdk\Modules\Payment\Repositories\Contracts\IPaymentAccountAssigneeRepository;

class PaymentService
{
    protected $paymentAccountRepository;
    protected $paymentAccountAsigneeRepository;
    protected $campaignRepository;

    /**
     * @param IPaymentAccountRepository $paymentAccountRepository
     * @param IPaymentAccountAssigneeRepository $paymentAccountAssigneeRepository
     * @param ICampaignRepository $campaignRepository
     */
    public function __construct(
        IPaymentAccountRepository $paymentAccountRepository,
        IPaymentAccountAssigneeRepository $paymentAccountAssigneeRepository,
        ICampaignRepository $campaignRepository)
    {
        $this->paymentAccountRepository = $paymentAccountRepository;
        $this->paymentAccountAsigneeRepository = $paymentAccountAssigneeRepository;
        $this->campaignRepository = $campaignRepository;
    }

    /**
     * Lấy danh sách tài khoản tiền marketing
     *
     * @param $request
     * @param $limit
     * @param $offset
     * @return array
     */
    public function list( $request, $limit, $offset)
    {
        $bank_name = $request->filled('bank_name') ? $request->input('bank_name') : null;

        $card_owner = $request->filled('card_owner') ? $request->input('card_owner') : null;

        $account_number = $request->filled('account_number') ? $request->input('account_number') : null;

        $totals = $this->paymentAccountRepository->checkExist([
            'card_owner' =>   $card_owner,
            'account_number' =>  $account_number,
            'bank_name'     =>  $bank_name
        ]);

        $listPayment = $this->paymentAccountRepository->getMore(
            array(
                'card_owner' =>   $card_owner,
                'account_number' =>  $account_number,
                'bank_name'     =>  $bank_name
            ),
            array(
                'limit' => $limit,
                'offset' => $offset,
            )
        );

        return array(
            'items' => $listPayment,
            'total' => $totals,
            'limit' => $limit,
            'offset' => $offset,
        );
    }

    /**
     * Service create paymentAccount
     * @param $request
     * @return mixed
     */
    public function store($request)
    {
        $conn = $this->paymentAccountRepository->getConnection();

        $validation = Validator::make($request, [
            'card_number' => 'unique:' . $conn . '.om_marketing_payment_accounts,card_number',
            'account_number' => 'unique:' . $conn . '.om_marketing_payment_accounts,account_number'
        ]);

        if ($validation->fails()) {
            throw new PalException('ERR_001');
        }

        $storePayment = $this->paymentAccountRepository->create([
            'store_id' => 1,
            'created_by' => 1,
            'bank_name' => $request['bank_name'],
            'card_type' => $request['card_type'],
            'card_number' => $request['card_number'],
            'is_active' => 1,
            'account_number' => $request['account_number'],
            'card_owner' => $request['card_owner']
        ]);

        $listUserAssigns = $request['user_assign_ids'];

        $storePayment->users()->sync($listUserAssigns);

        return $storePayment;
    }

    /**
     * @param $request
     * @param $paymentId
     * @return mixed
     */
    public function update ($paymentData, $paymentId)
    {
        $conn = $this->paymentAccountRepository->getConnection();

        $validation = Validator::make($paymentData, [
            'card_number' => 'unique:' . $conn . '.om_marketing_payment_accounts,card_number,' . $paymentId,
            'account_number' => 'unique:' . $conn . '.om_marketing_payment_accounts,account_number,' . $paymentId
        ]);

        if ($validation->fails()) {
            throw new PalException('ERR_001');
        }

        /** @var PaymentAccount $paymentUpdate */
        $paymentUpdate = $this->paymentAccountRepository->updateById($paymentId ,[
            'bank_name'     =>  $paymentData['bank_name'],
            'card_type'     =>  $paymentData['card_type'],
            'card_number'   =>  $paymentData['card_number'],
            'is_active'     =>  $paymentData['is_active'],
            'account_number'=>  $paymentData['account_number'],
            'card_owner'    =>  $paymentData['card_owner']
        ]);

        $listUserAssigns = $paymentData['user_assign_ids'];

        $paymentUpdate->users()->sync($listUserAssigns);

        return $paymentUpdate;
    }

    /**
     * @param $paymentId
     * @return mixed
     * @throws Exception
     */
    public function destroy($paymentId)
    {
        // check ton tai tai khoan chay chien dich
        /** @var PaymentAccount $payment */
        $payment = $this->paymentAccountRepository->getById($paymentId);

        $hasCampaign = $payment->campaigns()->exists();

        if ($hasCampaign > 0) {
            throw new Exception('Tài khoản đang chạy chiến dịch', 400);
        }

        return $this->paymentAccountRepository->delByCond([
            'id' => $paymentId
        ]);
    }

    /**
     * @param $listPaymentId
     * @return mixed
     * @throws PalValidationException
     */
    public function destroyMulti($listPaymentId)
    {
        foreach ($listPaymentId as $paymentId) {
            $validators = Validator::make(array(
                'id' => $paymentId
            ), array(
                'id' => 'required|exists:om_marketing_payment_accounts,id',
            ));

            if ($validators->fails()) {
                throw new PalValidationException($validators);
            }
        }

        return $this->paymentAccountRepository->destroy($listPaymentId);
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $store_id = 1;
        $fetchOptions['select'] = ['id', 'bank_name', 'card_owner', 'card_type'];

        $condition = [
            'store_id' => $store_id,
            'is_active' => 1
        ];

        $data = $this->paymentAccountRepository->getMore($condition, $fetchOptions);

        return $data;
    }
}