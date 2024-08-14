<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Practice extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'exercise_id',
        'day_id',
        'duration',
        'feed_back',
    ];

    
######################## Begin relations ##################

 public function user(){
    return $this -> belongsTo('App\Models\User', 'user_id');
}

public function exercise(){
    return $this -> belongsTo('App\Models\Exercise', 'exercise_id');
}

public function course(){
    return $this -> belongsTo('App\Models\Course', 'course_id');
}

######################## end relations ##################
}
