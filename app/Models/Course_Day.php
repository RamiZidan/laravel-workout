<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course_Day extends Model
{
    use HasFactory;

    protected $table = 'course_days';

    protected $fillable = [
        'name',
        'course_id',
    ];
######################## Begin relations ##################


public function course(){
    return $this -> belongsTo('App\Models\Course', 'course_id');
}

public function exercises(){
    return $this -> hasMany('App\Models\Days_Have_Exercises', 'day_id', 'id');
}

public function practiced_days(){
    return $this -> hasMany('App\Models\Day_Practice', 'day_id', 'id');
}

######################## end relations ##################
}
