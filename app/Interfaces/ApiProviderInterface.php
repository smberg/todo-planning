<?php
namespace App\Interfaces;

interface ApiProviderInterface
{
    public function fetchTasks();
    public function fetchAndSave();
    public function parseData($response);
}
