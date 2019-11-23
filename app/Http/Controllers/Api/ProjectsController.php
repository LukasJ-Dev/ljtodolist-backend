<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Project;
use App\Team;
use App\Todolist;

class ProjectsController extends Controller
{
    public function index() {
        $teams = auth()->user()->teams()->get();
        $projects = collect();
        foreach ($teams as $team) {
            if(!empty($team)) {
                $projectsfromteam = Project::where('belongs_to', $team['id'])->get();
                foreach ($projectsfromteam as $project) {
                    $projects->push($project);
                }
                
            }
            
        }
        return $projects;
    }

    public function show($id) {
        $project = Project::findOrFail($id);
        $exists = auth()->user()->teams->contains($project->belongs_to);
        if($exists) {
            $todolists = Todolist::findOrFail($project->id);
            return array("project" => $project, "todolists" => $todolists);
        }
        return ["You do not belong to the team!"];
    }

    public function store() {
        
        $project = $this->validateProject();
        $exists = auth()->user()->teams->contains($project['belongs_to']);
        if($exists) {
            $imagePath = request('image')->store('projects', 'public');
            $project['image'] = $imagePath;
            Project::create($project);
            return $project;
        }
        return ["You do not belong to the team!"];
    }



    protected function validateProject() {
        return request()->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'description' => ['required', 'min:3'],
            'belongs_to' => ['required'],
            'image' => ['required','image']
        ]);
    }
}
