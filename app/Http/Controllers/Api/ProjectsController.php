<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Project;

class ProjectsController extends Controller
{
    public function index() {
        $projects = Project::where('belongs_to', auth()->id())->get();

        return $projects;
    }

    public function store() {
        $data = $this->validateProject();
    }

    protected function validateProject() {
        return request()->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'description' => ['required', 'min:3']
        ]);
    }
}
