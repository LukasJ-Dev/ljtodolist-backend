<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
    protected $fillable = ['title','description', 'belongs_to', 'image'];
    public function team() {
        return $this->belongsTo(Team::class);
    }
    public function todolist() {
        return $this->hasMany(Todolist::class);
    }
}
