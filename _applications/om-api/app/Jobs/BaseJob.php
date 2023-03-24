<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

abstract class BaseJob //implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var bool $log
     */
    private $log = false;

    /**
     * @var int $store_id
     */
    protected $store_id;

    /**
     * BaseJob constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->connection = 'redis';
        $this->queue = 'om' . ($this->queueName() ?? 'default');

        $this->store_id = (int) ($data['store_id'] ?? null);
    }

    /**
     * Main process
     *
     * @return void
     */
    abstract protected function _handle();

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            if ($this->log == true) {
                if (method_exists($this, 'info')) {
                    Log::info('> ' . $this->info());
                }

                Log::info(get_called_class() . '::handle::', [$this->store_id]);
            }

            $this->startQueue();

            $this->_handle();
        } catch (\Exception $exception) {
            //@TODO: Log exception
        } finally {
            $this->endQueue();
        }
    }

    /**
     * Get queue name
     * @return string
     */
    protected function queueName() :string
    {
        return 'default';
    }

    /**
     * Remove all params cached by request
     */
    public function flushGlobals()
    {
        request()->replace([]);
    }

    /**
     * @return void
     */
    protected function startQueue()
    {

    }

    /**
     * @return void
     */
    protected function endQueue()
    {
        $this->flushGlobals();
    }
}
