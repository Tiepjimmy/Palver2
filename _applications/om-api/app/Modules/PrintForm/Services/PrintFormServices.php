<?php

namespace App\Modules\PrintForm\Services;

use App\Http\PalServiceErrorCode;
use OmSdk\Exceptions\PalException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Modules\PrintForm\Requests\PrintFormRequest;
use App\Modules\PrintForm\Requests\PrintFormUpdateRequest;
use OmSdk\Modules\PrintForm\Repositories\Contracts\IPrintFormRepository;

class PrintFormServices
{
    protected $printFormRepository;

    public function __construct(IPrintFormRepository $printFormRepository)
    {
        $this->printFormRepository = $printFormRepository;
    }

    /**
     * @param PrintFormRequest $request
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function getList($request, $limit, $offset)
    {
        $condition = [
            'filter' => $request->all()
        ];
        $listData = $this->printFormRepository->getMore($condition);
        $total = count($listData);

        return [
            $listData,
            $total
        ];
    }

    /**
     * Gets the system forms.
     *
     * @return     <type>  The system forms.
     */
    public function getSystemForms()
    {
        return $this->printFormRepository->getMore(['is_system' => 1], [], false);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $conn = $this->printFormRepository->getConnection();
        $validator = Validator::make(array('id' => $id), [
            'id' => 'exists:'.$conn.'.om_printed_forms,id',
        ]);

        if ($validator->fails()) {
            throw new PalException(PalServiceErrorCode::LOI_VALIDATE);
        }

        $printForm = null;
        $printForm = $this->printFormRepository->getById($id);

        if (is_null($printForm)) {
            throw new PalException(PalServiceErrorCode::LOI_PHAT_SINH);
        }

        return $printForm;
    }

    /**
     * @param PrintFormUpdateRequest $request
     * @param $id
     * @return void
     */
    public function update($request, $id)
    {
        $conn = $this->printFormRepository->getConnection();
        $validator = Validator::make(array('id' => $id), [
            'id' => 'exists:'.$conn.'.om_printed_forms,id',
        ]);

        if ($validator->fails()) {
            throw new PalException(PalServiceErrorCode::LOI_VALIDATE);
        }

        $printFormUpdate = null;
        $printFormUpdate = $this->printFormRepository->updateById($id, [
            'store_id' => 1,
            'title' => $request['title'],
            'type' => $request['type'],
            'content' => $request['content'],
            'is_active' => isset($request['is_active']) ? $request['is_active'] : 1,
            'updated_by' => 1,
        ]);

        if (isset($request['is_default'])) {
            if ($request['is_default'] == 1) {
                $this->printFormRepository->updateByCondition(['store_id' => 1 ], ['is_default' => 0], [], true);
            }
            
            $printFormUpdate = $this->printFormRepository->updateById($id, ['is_default' => $request['is_default']]);
        }

        if (is_null($printFormUpdate)) {
            throw new PalException(PalServiceErrorCode::LOI_HE_THONG);
        }
        return $printFormUpdate;
    }

    /**
     * { function_description }
     *
     * @param      array  $input  The input
     */
    public function store(array $input)
    {
        $this->validateStoreAction($input);
        
        $input['is_active'] = 1;
        $input['created_by'] = 1;

        return $this->printFormRepository->create($input);
    }

    /**
     * { function_description }
     *
     * @param      array                           $input  The input
     *
     * @throws     \OmSdk\Exceptions\PalException  (description)
     */
    private function validateStoreAction(array $input)
    {
        

        $validator = Validator::make(
            ['form' => $input],
            [
            'form' => [
                'filled',
                'array',
                function ($attribute, $value, $fail) {
                    // $hasExists = $this->printFormRepository->checkExist([
                    //     'store_id' => $value['store_id'],
                    //     'type' => $value['type']
                    // ]);
                    
                    // if ($hasExists) {
                    //     $fail('Đã tồn tại form này');
                    // }
                    //...
                }]
            ]
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
