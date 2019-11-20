<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Team;
use App\User;

class TeamsController extends Controller
{
    public function index() {
        return auth()->user()->teams()->get();
    }

    public function store() {
        $team = new Team($this->validateTeam());
        $team->save();
        foreach(request()->users as $user_email) {
            $user_id = User::where('email', $user_email)->get()[0]['id'];
            $team->users()->attach($user_id);
        }
        $team->users()->attach(auth()->id());
        return $team;
    }


    protected function validateTeam() {
        return request()->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'users' => ['array']
        ]);
    }
}
