<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Team;
use App\Todolist;
use App\ListModel;

class ListsController extends Controller
{
    public function store() {
        
        $list = $this->validateList();

        $todolist = Todolist::findOrFail($list['todolist_id']);
        $project = $todolist->project;
        foreach (auth()->user()->teams as $team) {
            if(Team::findOrFail($project->belongs_to)['id'] == $team['id']) {
                $order = 0;
                $lists = $todolist->lists;
                foreach ($lists as $list_item) {
                    if($list_item->order >= $order) {
                        $order = $list_item->order+1;
                    }
                }
                
                $list['order'] = $order;

                ListModel::create($list);
                return $list;
            }
        
        }
        
        return ["You do not belong to the todolist!"];
    }

    protected function validateList() {
        return request()->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'todolist_id' => ['required']
        ]);
    }
}
