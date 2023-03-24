<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\Product\Repositories\Eloquent;

use AccountSdkDb\Modules\Master\Repositories\Eloquent\VolumeUnitRepository as BaseRepository;
use App\Modules\Product\Repositories\Contracts\VolumeUnitInterface;

/**
 * Class VolumeUnitRepository
 * @package App\Modules\Product\Repositories\Eloquent`
 * @author HuyDien <huydien.it@gmail.com>
 */
class VolumeUnitRepository extends BaseRepository implements VolumeUnitInterface
{
    /**
     * @param array $conditions
     * @param mixed $query
     * @return mixed
     * @author HuyDien <huydien.it@gmail.com>
     */
    public function _prepareConditions($conditions, $query)
    {
        $query = parent::_prepareConditions($conditions, $query);

        return $query;
    }
}
