<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function getTasks($user_id)
    {
        return Task::where('user_id', $user_id)->orderBy('deadline', 'ASC')->get();
    }

    public function getOverdueCount($tasks, $today)
    {
        return $tasks->where('deadline', '<', $today)->count();
    }

    public function getUntilTodayCount($tasks, $today, $overdueCount)
    {
        return $tasks->where('deadline', '=', $today)->count() + $overdueCount;
    }
    
    public function getUntilTomorrowCount($tasks, $tomorrow, $untilTodayCount)
    {
        return $tasks->where('deadline', '=', $tomorrow)->count() + $untilTodayCount;
        
    }
}