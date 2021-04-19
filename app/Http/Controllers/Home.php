<?php

namespace App\Http\Controllers;
use App\Models\JobTask;
use App\Models\Developer;

class Home extends Controller
{
    function index()
    {
        $tasks = JobTask::getTasksOrdered();
        $developers = Developer::getDevsOrdered();
        $workloads = JobTask::getWorkload();
        $levelGroupedDevs = Developer::groupDevsByLevel($developers);

        // Grouping workloads by level
        $levelGroupedWorkloads = array();
        foreach($workloads as $workload) {
            $levelGroupedWorkloads[$workload->level] = $workload->total_time;
        }

        // Setting estimated workloads per developer
        foreach($levelGroupedDevs as $devList) {
            foreach($devList as $dev) {
                $devCount = count($devList);
                $dev->estimated_workload = $levelGroupedWorkloads[$dev->level] / $devCount;
            }
        }

        // Assigning tasks to the developers
        foreach($tasks as $task) {
            $selectedDev = 0;
            $lowestWorkload = -1;
            $lowestAvailableWorkload = -1;
            $availableDev = -1;

            // Checking devs for the best assignment
            foreach($developers as $key => $developer)
            {
                $developerWorkload = $developer->workload;
                if($lowestWorkload == -1) $lowestWorkload = $developerWorkload;

                // Get a developer who has the lowest workload
                if($developer->canDoTask($task) && $developerWorkload < $lowestWorkload) {
                    $selectedDev = $key;
                    $lowestWorkload = $developerWorkload;
                }

                // Get a developer who has finished tasks in their own level
                if($developer->isAvailableForTask($task)) {
                    if($lowestAvailableWorkload == -1 || $developerWorkload < $lowestAvailableWorkload) {
                        $lowestAvailableWorkload = $developerWorkload;
                        $availableDev = $key;
                    }
                }
            }

            if($availableDev !== -1 && $developers[$selectedDev]->workload > $developers[$availableDev]->workload)
            {
                $developers[$availableDev]->assignTask($task);
            }
            else
            {
                $developers[$selectedDev]->assignTask($task);
            }
        }


        $totalWorkTime = 0;
        foreach($developers as $dev)
        {
            // Get total worktime by highest dev workload
            if($dev->workload > $totalWorkTime)
            {
                $totalWorkTime = $dev->workload;
            }
        }

        $estimatedWeek = round($totalWorkTime / Developer::$weeklyWorkHour);

        $result = array(
            'completionTime' => $totalWorkTime,
            'completionWeek' => $estimatedWeek,
            'devs' => $developers
        );
        return view('report', $result);
    }
}
