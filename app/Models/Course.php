<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'duration',
        'is_public',
        'created_by',
        'left_days',
        
    ];

######################## Begin relations ##################
  
public function days(){
    return $this -> hasMany('App\Models\Course_Day', 'course_id', 'id');
}

public function practiced_days(){
    return $this -> hasMany('App\Models\Day_Practice', 'course_id', 'id');
}

public function practices(){
    return $this -> hasMany('App\Models\Practice', 'course_id', 'id');
}

public function user(){
    return $this -> hasOne('App\Models\User', 'course_id', 'id');
}

public function creater(){
    return $this -> belongsTo('App\Models\User', 'created_by');
}

######################## end relations ##################

}
