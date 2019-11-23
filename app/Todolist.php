<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todolist extends Model
{
    protected $fillable = ['title','description', 'project_id', 'image'];
    public function project() {
        return $this->belongsTo(Project::class);
    }
}
