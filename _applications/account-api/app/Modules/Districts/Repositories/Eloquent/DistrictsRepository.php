<?php

namespace App\Modules\Districts\Repositories\Eloquent;

use AccountSdkDb\Modules\Master\Repositories\Eloquent\DistrictRepository;
use App\Modules\Districts\Repositories\Contracts\DistrictsInterface;

/**
 * Class DistrictsRepository
 * @package App\Modules\Districts\Repositories\Eloquent
 */
class DistrictsRepository extends DistrictRepository implements DistrictsInterface
{
    /**
     * @param mixed $conditions
     * @param mixed $query
     * @return mixed
     */
    public function _prepareConditions($conditions, $query)
    {
        $query = parent::_prepareConditions($conditions, $query);
        if (isset($conditions['province_id'])) {
            $province_id = $conditions['province_id'];
            $query->where('province_id', $province_id);
        }
        if (isset($conditions['district_name'])) {
            $name = normalizer_normalize($conditions['district_name']);
            if ($name) $query->where('district_name', 'like', '%'.$name.'%');
        }
        if (isset($conditions['district_cd'])) {
            $district_cd = $conditions['district_cd'];
            $query->where('district_cd', $district_cd);
        }
        return $query;
    }
}
