<?php

namespace App\Modules\Provinces\Repositories\Eloquent;

use AccountSdkDb\Modules\Master\Models\Province;
use AccountSdkDb\Modules\Master\Repositories\Eloquent\ProvinceRepository;
use App\Modules\Provinces\Repositories\Contracts\ProvincesInterface;

/**
 * Class ProvincesRepository
 * @package App\Modules\Example\Repositories\Eloquent
 */
class ProvincesRepository extends ProvinceRepository implements ProvincesInterface
{

    /**
     * @param mixed $conditions
     * @param mixed $query
     * @return mixed
     * @author HuyDien <huydien.it@gmail.com>
     */
    public function _prepareConditions($conditions, $query)
    {
        $query = parent::_prepareConditions($conditions, $query);
//        if (isset($conditions['province_name'])) {
//            $province_name = $conditions['province_name'];
//            $query->where('province_name', $province_name);
//        }
        if (isset($conditions['province_name'])) {
            $name = normalizer_normalize($conditions['province_name']);
            if ($name) $query->where('province_name', 'like', '%'.$name.'%');
        }
        if (isset($conditions['province_cd'])) {
            $province_cd = $conditions['province_cd'];
            $query->where('province_cd', $province_cd);
        }
        return $query;
    }
}
