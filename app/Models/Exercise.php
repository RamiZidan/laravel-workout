<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'set_count',
        'times',
        'level',
        'muscle_id'
    ];
######################## Begin relations ##################

 public function days(){
    return $this -> hasMany('App\Models\Days_Have_Exercises', 'exercise_id', 'id');
}

public function practices(){
    return $this -> hasMany('App\Models\Practice', 'exercise_id', 'id');
}

public function muscle(){
    return $this -> belongsto('App\Models\Muscle', 'muscle_id');
}



######################## end relations ##################
}
