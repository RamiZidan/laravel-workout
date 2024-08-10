<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMuscle extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'level',
        'muscle_id'
    ];

######################## Begin relations ##################

 public function user(){
    return $this -> belongsTo('App\Models\User', 'user_id');
}

public function muscle(){
    return $this -> belongsTo('App\Models\Muscle', 'muscle_id');
}

######################## end relations ##################
}
