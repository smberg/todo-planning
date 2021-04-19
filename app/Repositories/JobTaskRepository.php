<?php
namespace App\Repositories;

use App\Abstracts\ApiRepository;
use App\Interfaces\ApiProviderInterface;

class JobTaskRepository extends ApiRepository implements ApiProviderInterface
{
    public function __construct()
    {
        $this->setApiUrl('https://www.mediaclick.com.tr/api/5d47f24c330000623fa3ebfa.json');
        $this->setProviderName('Business Tasks 2');
    }

    public function parseData($response)
    {
        $parsedData = array();

        $parsedData['level'] = $response['zorluk'];
        $parsedData['time'] = $response['sure'];
        $parsedData['name'] = $response['id'];

        return $parsedData;
    }
}
