<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\Wards\Services\Impls;



use App\Modules\Wards\Repositories\Contracts\WardsInterface;
use App\Modules\Wards\Services\IWardsService;

class WardsServices implements IWardsService
{
    /** @var WardsInterface */
    protected $wardsRepository;

    public function __construct(WardsInterface $wardsRepoInterface)
    {
        $this->wardsRepository = $wardsRepoInterface;
    }
    /**
     * @inheritDoc
     */
    public function search($attributes)
    {
        $Wards = $this->wardsRepository->getMore($attributes);
        return $Wards->toArray();
    }
}
