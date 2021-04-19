<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    use HasFactory;
    protected $fillable = ['developer', 'time', 'level'];
    public $timestamps = false;
    protected $appends = array('tasks', 'task_count', 'workload', 'estimated_workload');
    public static $weeklyWorkHour = 45;
    protected array $tasks = array();
    protected int $estimated_workload = 0;

    public function getTasksAttribute()
    {
        return $this->tasks;
    }

    public function getTaskCountAttribute()
    {
        return count($this->tasks);
    }

    public function getEstimatedWorkloadAttribute()
    {
        return $this->estimated_workload;
    }

    public function setEstimatedWorkloadAttribute($estimatedWorkload)
    {
        $this->estimated_workload = $estimatedWorkload;
    }

    public function assignTask(&$task)
    {
        if(($task->level > $this->level) || $task->assigned) return false;
        $this->tasks[] = $task;
        $task->assigned = true;
        $task->dev_id = $this->id;
        return true;
    }

    public function canDoTask($task)
    {
        return ($task->level <= $this->level);
    }

    public function isAvailableForTask($task)
    {
        return ($this->calculateWorkload() > $this->estimated_workload && $task->level <= $this->level);
    }

    public function getWorkloadAttribute()
    {
        return $this->calculateWorkload();
    }

    public function calculateWorkload()
    {
        $workload = 0;
        foreach($this->tasks as $task) {
            $workload += ($task['time'] / $this->time);
        }
        return $workload;
    }

    public function getWeeklyPlan()
    {
        $weeks = array();
        $weekWork = 0;
        $currentWeek = 1;
        foreach($this->tasks as $task)
        {
            $nextWeek = 0;
            $weekLimit = ($weekWork + $task->time);
            if($weekLimit > self::$weeklyWorkHour)
            {
                $nextWeek = $weekLimit - self::$weeklyWorkHour;
                $nextWeekTask = clone $task;
                $nextWeekTask->time = $nextWeek;
                $weeks[($currentWeek+1)][] = $nextWeekTask;
                $task->time -= $nextWeek;
            }

            $weeks[$currentWeek][] = $task;
            $weekWork += $task->time;

            if($weekWork >= self::$weeklyWorkHour)
            {
                $weekWork = ($nextWeek > 0) ? $nextWeek : 0;
                $currentWeek++;
            }
        }
        return $weeks;
    }

    public static function getDevsOrdered() {
        return self::orderBy('level', 'desc')->get();
    }

    public static function groupDevsByLevel(Collection $developers)
    {
        $levelGroupedDevs = array();
        foreach($developers as $dev) {
            $levelGroupedDevs[$dev->level][] = $dev;
        }
        return $levelGroupedDevs;
    }
}
