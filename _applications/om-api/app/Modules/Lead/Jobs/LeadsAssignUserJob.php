<?php

namespace App\Modules\Lead\Jobs;

use App\Jobs\BaseJob;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use OmSdk\Modules\Lead\Models\Lead;
use OmSdk\Modules\Lead\Repositories\Contracts\ILeadRepository;

class LeadsAssignUserJob extends BaseJob
{
    /**
     * @var array $leadIds
     */
    protected $leadIds;

    /**
     * @var array $userIds
     */
    protected $userIds;

    /**
     * @var bool $assignAll
     */
    protected $assignAll = false;

    /**
     * @var ILeadRepository $leadRepository
     */
    private $leadRepository;

    /**
     * @var int $chunkCount
     */
    private $chunkCount = 50;

    /**
     * @var int $currentGroupIndex
     */
    private $currentGroupIndex = 0;

    /**
     * LeadsAssignJob constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);

        $this->userIds = (array) ($data['userIds'] ?? []);
        $this->leadIds = (array) ($data['leadIds'] ?? []);
        $this->assignAll = (bool) ($data['assignAll'] ?? false);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    protected function _handle()
    {
        if (! $this->assignAll) {
            $this->assign();
        } else {
            $this->assignAll();
        }
    }

    /**
     * @return void
     */
    protected function assign()
    {
        $userIds = array_filter($this->userIds);
        $leadIds = array_filter($this->leadIds);

        if (empty($userIds) || empty($leadIds)) {
            return;
        }

        $leads = $this->getLeadRepository()->getListByIds($leadIds);

        if (empty($leads->isEmpty())) {
            return;
        }

        $this->assignLead($leads, $userIds);
    }

    /**
     * @return void
     */
    protected function assignAll()
    {
        $userIds = array_filter($this->userIds);

        if (empty($userIds)) {
            return;
        }

        $query = Lead::query()
            ->where('store_id', 1);

        $query->chunkById($this->chunkCount, function (Collection $leads) use ($userIds) {
            $this->assignLead($leads, $userIds);

            unset($leads);
        });
    }

    /**
     * @param Collection $leads
     * @param array $saleGroupIds
     * @return boolean
     */
    public function assignLead(Collection $leads, array $saleGroupIds)
    {
        /** @var Lead $lead */
        foreach ($leads as $lead) {
            $lead->assigned_user_id = $saleGroupIds[$this->currentGroupIndex];
            $lead->assigned_at = Carbon::now();

            $lead->update();

            $this->currentGroupIndex += 1;

            if (! isset($saleGroupIds[$this->currentGroupIndex])) {
                $this->currentGroupIndex = 0;
            }
        }

        return true;
    }

    /**
     * @return mixed|ILeadRepository
     */
    protected function getLeadRepository()
    {
        if (! $this->leadRepository) {
            $this->leadRepository = App::make(ILeadRepository::class);
        }

        return $this->leadRepository;
    }
}
