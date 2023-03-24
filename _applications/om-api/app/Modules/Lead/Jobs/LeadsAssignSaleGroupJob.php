<?php

namespace App\Modules\Lead\Jobs;

use App\Jobs\BaseJob;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;
use OmSdk\Modules\Lead\Models\Lead;
use OmSdk\Modules\Lead\Repositories\Contracts\ILeadRepository;

class LeadsAssignSaleGroupJob extends BaseJob
{
    /**
     * @var array $leadIds
     */
    protected $leadIds;

    /**
     * @var array $saleGroupIds
     */
    protected $saleGroupIds;

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

        $this->saleGroupIds = $data['saleGroupIds'] ?? [];
        $this->leadIds = $data['leadIds'] ?? [];
        $this->assignAll = $data['assignAll'] ?? false;
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
        $saleGroupIds = array_filter($this->saleGroupIds);
        $leadIds = array_filter($this->leadIds);

        if (empty($userIds) || empty($leadIds)) {
            return;
        }

        $leads = $this->getLeadRepository()->getListByIds($leadIds);

        if (empty($leads->isEmpty())) {
            return;
        }

        $this->assignLead($leads, $saleGroupIds);
    }

    /**
     * @return void
     */
    protected function assignAll()
    {
        $saleGroupIds = array_filter($this->saleGroupIds);

        if (empty($saleGroupIds)) {
            return;
        }

        $query = Lead::query()
            ->where('store_id', 1);

        $query->chunkById($this->chunkCount, function (Collection $leads) use ($saleGroupIds) {
            $this->assignLead($leads, $saleGroupIds);

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
        $this->currentGroupIndex = 0;

        /** @var Lead $lead */
        foreach ($leads as $lead) {
            $lead->assigned_group_id = $saleGroupIds[$this->currentGroupIndex];
            $lead->group_assigned_at = Carbon::now();

            try {
                $updated = $lead->update();

                $this->currentGroupIndex += 1;

                if (! isset($saleGroupIds[$this->currentGroupIndex])) {
                    $this->currentGroupIndex = 0;
                }
            } catch (\Throwable $exception) {
                Log::info(__METHOD__, [$exception->getMessage()]);
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
