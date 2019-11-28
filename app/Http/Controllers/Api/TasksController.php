<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Team;
use App\Task;
use App\Todolist;
use App\ListModel;

class TasksController extends Controller
{
    public function store() {
        $task = $this->validateTask();

        $project = ListModel::findOrFail($task['list_id'])->todolist->project;
        foreach (auth()->user()->teams as $team) {
            if(Team::findOrFail($project->belongs_to)['id'] == $team['id']) {
                $order = 0;
                $tasks = Task::where('list_id',$task['list_id'])->get();
                foreach ($tasks as $task_item) {
                    if($task_item->order >= $order) {
                        $order = $task_item->order+1;
                    }
            }

            $task['order'] = $order;

            Task::create($task);
            return $task;
        
        }
    }
        
        return "You do not belong to the team!";
    }
    protected function validateTask() {
        return request()->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'list_id' => ['required']
        ]);
    }
}
