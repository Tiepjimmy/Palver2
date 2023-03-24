<?php

namespace App\Modules\Order\Services;

use Illuminate\Support\Facades\Validator;
use OmSdk\Modules\Order\Repositories\Contracts\IOrderStatusRepository;
use App\Modules\Order\Exceptions\OrderException;

class StatusesServices
{

    const DEFAULT_LIMIT_ROW = 10;
    protected $statusesRepository;

    public function __construct(IOrderStatusRepository $statusesRepository)
    {
        $this->statusesRepository = $statusesRepository;
    }

    public function list($payload)
    {
        $validator = Validator::make($payload, [
            'store_id' => 'required|numeric',
            'limit' => 'numeric|integer',
            'page' => 'numeric|integer',
            'keyword' => 'max:50',
            'level' => 'numeric|integer',
            'type' => 'numeric|integer'
        ]);

        if ($validator->fails()) {
            throw new OrderException('ERR_002');
        }

        $perPage = $payload['limit'] ?? self::DEFAULT_LIMIT_ROW;
        
        // return $this->statusesRepository->customPaginate($payload, [], $perPage);
        $result = $this->statusesRepository->getMore(['filter' => array_filter($payload)], [], $perPage);

        return [
            'items' => $result->items(),
            'total' => $result->total(),
            'page' => $result->currentPage(),
            'limit' => $perPage
        ];
    }

    public function show($id)
    {
        $conn = $this->statusesRepository->getConnection();
        $validator = Validator::make(array('id' => $id), [
            'id' => 'exists:'.$conn.'.om_order_statuses,id',
        ]);

        if ($validator->fails()) {
            throw new OrderException('ERR_003');
        }

        $statuses = $this->statusesRepository->getById($id);

        return $statuses;
    }

    public function store(array $payload)
    {
        $conn = $this->statusesRepository->getConnection();
        $validator = Validator::make($payload, [
            'code' => 'unique:'.$conn.'.om_order_statuses,code',
        ]);

        if ($validator->fails()) {
            throw new OrderException('ERR_002');
        }
 
        $statuses = $this->statusesRepository->create($payload);

        return $statuses;
    }

    public function update(array $payload, $id)
    {
        $conn = $this->statusesRepository->getConnection();
        $validator = Validator::make($payload, [
            'code' => 'unique:'.$conn.'.om_order_statuses,code,' . $id,
        ]);

        if ($validator->fails()) {
            throw new OrderException('ERR_001');
        }

        $statuses = $this->statusesRepository->updateById($id, $payload);

        return $statuses;
    }

    public function destroy($id)
    {
        $conn = $this->statusesRepository->getConnection();
        $validator = Validator::make(array('id' => $id), [
            'id' => 'exists:'.$conn.'.om_order_statuses,id',
        ]);

        if ($validator->fails()) {
            throw new OrderException('ERR_003');
        }

        $this->statusesRepository->destroy(array($id));

        return;
    }

    public function getAll()
    {
        $conditions['store_id'] = 1;
        $conditions['is_active'] = 1;
        $fetchOptions['select'] = ['id', 'name', 'color'];

        return $this->statusesRepository->getMore($conditions, $fetchOptions);
    }
}
