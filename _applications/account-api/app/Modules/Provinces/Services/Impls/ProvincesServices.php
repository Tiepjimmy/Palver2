<?php
/**
 * Copyright (c) 2020. Electric
 */

namespace App\Modules\Provinces\Services\Impls;



use App\Modules\Provinces\Repositories\Contracts\ProvincesInterface;
use App\Modules\Provinces\Services\IProvincesService;

class ProvincesServices implements IProvincesService
{
    /** @var ProvincesInterface */
    protected $provincesRepository;

    public function __construct(ProvincesInterface $provincesRepoInterface)
    {
        $this->provincesRepository = $provincesRepoInterface;
    }
    /**
     * @inheritDoc
     */
    public function search($attributes)
    {
        $provinces = $this->provincesRepository->getMore($attributes);
        return $provinces->toArray();
    }
}
