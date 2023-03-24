<?php

namespace App\Modules\Wards\Repositories\Eloquent;

use AccountSdkDb\Modules\Master\Models\Ward;
use AccountSdkDb\Modules\Master\Repositories\Eloquent\WardRepository;
use App\Modules\Wards\Repositories\Contracts\WardsInterface;

/**
 * Class WardsRepository
 * @package App\Modules\Wards\Repositories\Eloquent
 */
class WardsRepository extends WardRepository implements WardsInterface
{


    /**
     * @param mixed $conditions
     * @param mixed $query
     * @return mixed
     */
    public function _prepareConditions($conditions, $query)
    {
        $query = parent::_prepareConditions($conditions, $query);
        if (isset($conditions['district_id'])) {
            $district_id = $conditions['district_id'];
            $query->where('district_id', $district_id);
        }
        if (isset($conditions['ward_name'])) {
            $name = normalizer_normalize($conditions['ward_name']);
            if ($name) $query->where('ward_name', 'like', '%'.$name.'%');
        }
        if (isset($conditions['ward_cd'])) {
            $ward_cd = $conditions['ward_cd'];
            $query->where('ward_cd', $ward_cd);
        }
        return $query;
    }
}
