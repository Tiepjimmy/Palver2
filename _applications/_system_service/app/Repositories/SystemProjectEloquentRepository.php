<?php


namespace App\Repositories;

use \Common\Repositories\Eloquent\AbstractEloquentRepository;

/**
 * Class AbstractEloquentRepository
 * @package App\Repositories
 */
abstract class SystemProjectEloquentRepository extends AbstractEloquentRepository
{

    /**
     * @param string $conn
     */
    protected function _setConnection($conn = '')
    {
        return config('database.default');
    }
}
