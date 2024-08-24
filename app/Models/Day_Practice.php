<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day_Practice extends Model
{
    use HasFactory;

    protected $table = "day_practices";

    protected $fillable = [
        'day_id',
        'user_id',
        'course_id',
        'created_at'
    ];

    
######################## Begin relations ##################

 public function user(){
    return $this -> belongsTo('App\Models\User', 'user_id');
}

public function day(){
    return $this -> belongsTo('App\Models\Day', 'day_id');
}

public function course(){
    return $this -> belongsTo('App\Models\Course', 'course_id');
}

######################## end relations ##################
}
