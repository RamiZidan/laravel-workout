<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Days_Have_Exercises extends Model
{
    use HasFactory;

    protected $table = 'days_have_exercises';
    protected $fillable = [
        'day_id',
        'exercise_id',
    ];

######################## Begin relations ##################

 public function day(){
    return $this -> belongsTo('App\Models\Course_Day', 'day_id');
}

public function exercise(){
    return $this -> belongsTo('App\Models\Exercise', 'exercise_id');
}

######################## end relations ##################

}
