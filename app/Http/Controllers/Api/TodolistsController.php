<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Project;
use App\Team;
use App\Todolist;

class TodolistsController extends Controller
{
    public function store() {
        
        $todolist = $this->validateTodolist();
        $project = Project::findOrFail($todolist['project_id']);
        foreach (auth()->user()->teams as $team) {
            if(Team::findOrFail($project->belongs_to)['id'] == $team['id']) {
                $imagePath = request('image')->store('todolists', 'public');
                $todolist['image'] = $imagePath;
                Todolist::create($todolist);
                return $todolist;
            }
        
        }
        
        return "You do not belong to the team!";
    }

    public function show($id) {

        $todolist = Todolist::findOrFail($id);
        $project = Project::findOrFail($todolist->project_id);

        foreach (auth()->user()->teams as $team) {
            if(Team::findOrFail($project->belongs_to)['id'] == $team['id']) {
                return $todolist;
            }
        }

        
        return ["You do not own that todolist"];
    }


    protected function validateTodolist() {
        return request()->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'description' => ['required', 'min:3'],
            'project_id' => ['required'],
            'image' => ['required','image']
        ]);
    }
}
