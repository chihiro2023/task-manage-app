<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Http\Requests\Task\CreateRequest;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateRequest $request)
    {
        $task = new Task;
        $task->user_id = $request->userId();
        $task->content = $request->content();
        $task->deadline = $request->deadline();
        $task->save();
        
        return redirect()
                ->route('task.index')
                ->with('feedback.success', "タスクを追加しました。");
    }
}
