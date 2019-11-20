<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['title','description', 'belongs_to', 'image'];
    public function team() {
        return $this->belongsTo(Team::class);
    }
}
