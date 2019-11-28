<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListModel extends Model
{
    protected $fillable = ['title','todolist_id','order'];
    protected $table = 'lists';
    public function todolist() {
        return $this->belongsTo(Todolist::class);
    }
    public function tasks() {
        return $this->hasMany(Task::class);
    }
}
