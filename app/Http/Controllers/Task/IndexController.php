<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, TaskService $taskService)
    {
        if (Auth::check()) {
            $today = Carbon::now()->format('Y-m-d');
            $tomorrow = Carbon::now()->addDay()->format('Y-m-d');

            $user_id = Auth::user()->id;
            $tasks = $taskService->getTasks($user_id);
            $overdueCount = $taskService->getOverdueCount($tasks, $today);
            $untilTodayCount = $taskService->getUntilTodayCount($tasks, $today, $overdueCount);
            $untilTomorrowCount = $taskService->getUntilTomorrowCount($tasks, $tomorrow, $untilTodayCount);
        
            return view('task.index')
                ->with(['tasks' => $tasks, 'overdueCount' => $overdueCount, 'untilTodayCount' => $untilTodayCount, 'untilTomorrowCount' => $untilTomorrowCount]);
        } else {
            return view('task.index');
        }
    }
}
