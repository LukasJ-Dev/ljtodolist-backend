<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';
    protected $fillable = ['name'];
    public function projects() {
        return $this->hasMany(Project::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }
}
