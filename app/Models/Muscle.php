<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Muscle extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
    ];

######################## Begin relations ##################

 public function exercises(){
    return $this -> hasMany('App\Models\Exercise', 'muscle_id', 'id');
}

public function muscles(){
    return $this -> hasMany('App\Models\UserMuscle', 'muscle_id', 'id');
}

######################## end relations ##################
}
