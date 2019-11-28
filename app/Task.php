<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
    protected $fillable = ['title','list_id','order'];
    public function list() {
        return $this->belongsTo(ListModel::class);
    }
}
