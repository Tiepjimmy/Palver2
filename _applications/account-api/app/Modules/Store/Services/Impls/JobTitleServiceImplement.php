<?php

namespace App\Modules\Store\Services\Impls;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Common\Exceptions\PalException;
use Common\Exceptions\PalValidationException;
use App\Modules\Store\Events\JobTitleInsertEvent;
use App\Modules\Store\Repositories\Contracts\JobTitleInterface;
use App\Modules\Store\Repositories\Contracts\StoreInterface;
use App\Modules\Store\Services\IJobTitleService;
use AccountSdkDb\Modules\Store\Services\IAssignmentStoreService;

/**
 * @inheritDoc
 */
class JobTitleServiceImplement implements IJobTitleService
{
    protected $assignmentStoreService;
    protected $jobTitleRepository;
    protected $storeRepository;

    /**
     * JobTitleServiceImplement constructor.
     * @param IAssignmentStoreService $assignmentStoreService
     * @param JobTitleInterface $jobTitleRepository
     * @param StoreInterface $storeRepository
     */
    public function __construct(IAssignmentStoreService $assignmentStoreService,
                                JobTitleInterface $jobTitleRepository,
                                StoreInterface $storeRepository
    )
    {
        $this->assignmentStoreService = $assignmentStoreService;
        $this->jobTitleRepository = $jobTitleRepository;
        $this->storeRepository = $storeRepository;
    }

    /**
     * @inheritDoc
     */
    public function search($keyword, $limit, $offset) {
        $listStore = $this->assignmentStoreService->getAssignedStore();
        $listStoreId = $listStore->map(function ($store) {
            return $store['id'];
        })->toArray();
        $listStoreWithJobTitle = $this->storeRepository->getMore(
            array(
                'list_store_id' => $listStoreId
            ),
            array(
                'with' => array('jobTitles')
            )
        )->toArray();
        if ($keyword) {
            foreach ($listStoreWithJobTitle as $storeIndex => $storeWithJobTitle) {
                $checkKeyword = false;
                if (is_numeric(stripos($storeWithJobTitle['store_name'], $keyword))) {
                    $checkKeyword = true;
                }
                if (count($storeWithJobTitle['job_titles']) > 0) {
                    $jobTitles = $storeWithJobTitle['job_titles'];
                    foreach ($jobTitles as $jobTitle) {
                        if (is_numeric(stripos($jobTitle['job_title_name'], $keyword))) {
                            $checkKeyword = true;
                        }
                    }
                }
                if (!$checkKeyword) {
                    unset($listStoreWithJobTitle[$storeIndex]);
                }
            }
        }
        return array(
            'items' => collect($listStoreWithJobTitle)->splice($offset, $limit),
            'total' => count($listStoreWithJobTitle),
            'limit' => $limit,
            'offset' => $offset,
        );
    }

    /**
     * @inheritDoc
     */
    public function getCreateInfo() {
        $listStore = $this->assignmentStoreService->getAssignedStore();

        return array(
            'list_store' => $listStore,
        );
    }

    /**
     * @inheritDoc
     */
    public function store($payload) {
        $validators = Validator::make($payload, array(
            'store_id' => 'required|exists:acc_t_stores,id',
            'active_status' => 'required|string|max:255',
            'job_title_name' => 'required|string|max:255',
            'job_title_type' => 'required|string|in:manager,staff,other',
        ));
        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',200);
        }

        $storedJobTitle = null;
        $storedJobTitle = $this->jobTitleRepository->create(array(
            'store_id' => $payload['store_id'],
            'active_status' => $payload['active_status'],
            'job_title_name' => $payload['job_title_name'],
            'job_title_type' => $payload['job_title_type'],
        ));


        if (!is_null($storedJobTitle)) {
            Event::dispatch(new JobTitleInsertEvent($storedJobTitle));
        } else {
            throw new PalException('E000001');
        }

        return $storedJobTitle;
    }

    /**
     * @inheritDoc
     */
    public function update($attributeId, $payload) {
        $validators = Validator::make($payload, array(
            'store_id' => 'required|exists:acc_t_stores,id',
            'active_status' => 'required|string|max:255',
            'job_title_name' => 'required|string|max:255',
            'job_title_type' => 'required|string|in:manager,staff,other',
        ));
        if ($validators->fails()) {
            throw new PalValidationException($validators,'E000003','Lỗi validate',200);
        }

        $updatedJobTitle = null;
        $updatedJobTitle = $this->jobTitleRepository->updateById($attributeId, array(
            'store_id' => $payload['store_id'],
            'active_status' => $payload['active_status'],
            'job_title_name' => $payload['job_title_name'],
            'job_title_type' => $payload['job_title_type'],
        ));

        if (!is_null($updatedJobTitle)) {
            Event::dispatch(new JobTitleInsertEvent($updatedJobTitle));
        } else {
            throw new PalException('E000001');
        }

        return $updatedJobTitle;
    }

}
