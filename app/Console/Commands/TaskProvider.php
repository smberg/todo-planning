<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Interfaces\ApiProviderInterface;
use App\Models\JobTask;

class TaskProvider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'taskprovider:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get API data from providers';

    protected $apiProviders;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ApiProviderInterface ...$apiProviders)
    {
        parent::__construct();
        $this->apiProviders = $apiProviders;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach ($this->apiProviders as $api) {
            $this->warn('Fetching: ' . $api->providerName);
            $api->fetchAndSave();
            $this->info('Fetched: ' . $api->providerName);
        }
    }
}
