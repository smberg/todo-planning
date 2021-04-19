<?php
namespace App\Repositories;

use App\Abstracts\ApiRepository;
use App\Interfaces\ApiProviderInterface;

class BusinessTaskRepository extends ApiRepository implements ApiProviderInterface
{
    public function __construct()
    {
        $this->setApiUrl('https://www.mediaclick.com.tr/api/5d47f235330000623fa3ebf7.json');
        $this->setProviderName('Business Tasks');
    }

    public function parseData($response)
    {
        $key = array_key_first($response);
        $values = $response[$key];

        $parsedData = array();

        $parsedData['level'] = $values['level'];
        $parsedData['time'] = $values['estimated_duration'];
        $parsedData['name'] = $key;

        return $parsedData;
    }
}


