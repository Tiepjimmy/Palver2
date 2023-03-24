<?php

namespace App\Modules\Payment\Resources;

use Common\Http\Resources\AbstractResource;
use Common\Models\AbstractModel;
use Symfony\Component\Translation\Exception\InvalidResourceException;

/**
 * Class TypeCollectVoucherResource
 * @package App\Modules\Payment\Resources
 */
class TypeCollectVoucherResource extends AbstractResource
{
    /**
     * @param mixed $request
     * @return array
     */
    public function toArray($request)
    {
        if (!$this->resource instanceof AbstractModel) {
            throw new InvalidResourceException();
        }

        return [
            'id' => $this->resource['id'],
            'type_code' => $this->resource['type_code'],
            'type_name' => $this->resource['type_name'],
            'note' => $this->resource['note'],
            'is_active' => $this->resource['is_active'],
            'is_business_result' => $this->resource['is_business_result'],
            'created_at' => date_format($this->resource['created_at'],"H:i:s d/m/Y"),
            'updated_at' => date_format($this->resource['updated_at'],"H:i:s d/m/Y")
        ];
    }
}