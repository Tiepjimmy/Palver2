<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\Districts\Services\Impls;



use App\Modules\Districts\Repositories\Contracts\DistrictsInterface;
use App\Modules\Districts\Services\IDistrictsService;

class DistrictsServices implements IDistrictsService
{
    /** @var DistrictsInterface */
    protected $districtsRepository;

    public function __construct(DistrictsInterface $districtsRepoInterface)
    {
        $this->districtsRepository = $districtsRepoInterface;
    }
    /**
     * @inheritDoc
     */
    public function search($attributes)
    {
        $districts = $this->districtsRepository->getMore($attributes);
        return $districts->toArray();
    }
}
