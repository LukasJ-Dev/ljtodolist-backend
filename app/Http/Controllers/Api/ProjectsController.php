<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Project;
use App\Team;

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
        //$projects = Project::where('belongs_to', auth()->id())->get();

        //return auth()->user()->teams()->projects()->get();
        //$procedure->stages()->pluck('stages.id')->toArray();
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
        return "You do not belong to the team!";
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
