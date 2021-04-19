<?php

namespace App\Abstracts;
use App\Interfaces\ApiProviderInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use App\Models\JobTask;

abstract class ApiRepository implements ApiProviderInterface
{
    public string $providerName;
    private string $apiURL;
    public Collection $tasks;

    public function fetchTasks()
    {
        $response = Http::get($this->apiURL);
        if($response->successful()) {
            $data = collect($response->json());
            $parsedData = $data->map(array($this, 'parseData'));
            $this->tasks = $parsedData;
            return $this->tasks;
        } else {
            $response->throw();
        }
    }

    public function fetchAndSave()
    {
        $tasks = $this->fetchTasks()->all();
        foreach($tasks as $task) {
            JobTask::create([
                'level' => $task['level'],
                'time' => $task['time'],
                'name' => $task['name']
            ]);
        }
    }

    public function setProviderName(string $providerName) {
        $this->providerName = $providerName;
    }

    public function setApiUrl(string $apiURL) {
        $this->apiURL = $apiURL;
    }
}
