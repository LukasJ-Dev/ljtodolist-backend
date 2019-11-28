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
            $todolists = Todolist::where('project_id',$project->id)->get();
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

    public function update($id) {
        $new_project = $this->validateProject();
        $project = Project::findOrFail($id);
        $exists = auth()->user()->teams->contains(request('belongs_to'));
        $belongs_to_team = auth()->user()->teams->contains($project->belongs_to);
        if($exists and $belongs_to_team) {
            $project->title = request('title');
            $project->description = request('description');
            $project->belongs_to = request('belongs_to');
            if(request('image') !== null) {
                $imagePath = request('image')->store('projects', 'public');
                $project->image = $imagePath;
            }
            $project->save();
            return $project;
        }
        abort(403, 'Unauthorized action.');
    }

    public function destroy($id) {
        $project = Project::findOrFail($id)->delete();
        return $project;
    }

    protected function storeProject($project) {

    }

    protected function validateProject() {
        return request()->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'description' => ['required', 'min:3'],
            'belongs_to' => ['required'],
            'image' => ['image']
        ]);
    }
}
