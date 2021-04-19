<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTask extends Model
{
    use HasFactory;
    protected $fillable = ['level', 'time', 'name'];
    protected $appends = array('assigned','dev_id');
    public $timestamps = false;
    protected bool $assigned = false;
    protected int $dev_id = 0;

    public function getAssignedAttribute()
    {
        return $this->assigned;
    }

    public function setAssignedAttribute(bool $assigned)
    {
        $this->assigned = $assigned;
    }

    public function getDevIdAttribute()
    {
        return $this->dev_id;
    }

    public function setDevIdAttribute(int $dev_id)
    {
        $this->dev_id = $dev_id;
    }

    public static function getWorkload()
    {
        return self::selectRaw('level, SUM(time) AS total_time')
                ->groupBy('level')
                ->orderBy('total_time', 'asc')
                ->get();
    }

    public static function getByLevel(int $level)
    {
        return self::where('level', $level)->get();
    }

    public static function getTotalTimeByLevel(int $level)
    {
        return self::selectRaw('SUM(time) AS total_time')
                ->groupBy('level')
                ->where('level', $level)->first();
    }

    public static function getTasksOrdered() {
        return self::orderBy('level', 'desc')
                    ->orderBy('time', 'asc')
                    ->get();
    }

    public static function groupTasksByLevel(Collection $tasks)
    {
        $levelGroupedTasks = array();
        foreach($tasks as $task) {
            $levelGroupedTasks[$task->level][] = $task;
        }
        return $levelGroupedTasks;
    }
}
