<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $taskId = (int) $request->route('taskId');
        $task = Task::where('id', $taskId)->firstOrFail();
        $task->delete();
        return redirect()->route('task.index');
            
    }
}
