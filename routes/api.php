<?php

use App\Http\Controllers\UserMuscleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MuscleController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseDayController;
use App\Http\Controllers\DayPracticeController;
use App\Http\Controllers\DaysHaveExercisesController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\PracticeController;


Route::group(['midllware' => 'api'], function ($router) {
    Route::group(['prefix' => 'auth'], function ($router) {

        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
        Route::put('change_password', [AuthController::class, 'change_password']);
        Route::post('register', [AuthController::class, 'register']);


    });

    Route::group([], function ($router) {

        Route::put('user/update', [UserController::class, 'update']);

    });

   

    Route::group(
        ['middleware' => \App\Http\Middleware\Admin::class, 'prefix' => 'dashboard'],
        function ($router) {
            Route::group([
                'prefix' => 'muscles'

            ], function ($router) {
                Route::post('', [MuscleController::class, 'create']);
                Route::get('/{id}', [MuscleController::class, 'retrieve']);
                Route::put('/{id}', [MuscleController::class, 'update']);
                Route::delete('/{id}', [MuscleController::class, 'delete']);
                Route::get('', [MuscleController::class, 'index']);
            });

            Route::group([
                'prefix' => 'exercises'

            ], function ($router) {
                Route::post('', [ExerciseController::class, 'create']);
                Route::put('/{id}', [ExerciseController::class, 'update']);
                Route::delete('/{id}', [ExerciseController::class, 'delete']);
                Route::get('/{id}', [ExerciseController::class, 'retrieve']);
                Route::get('', [ExerciseController::class, 'index']);

            });

            Route::group([
                'prefix' => 'courses'
        
            ], function ($router) {
                Route::post('', [CourseController::class, 'create']);
                Route::put('/{id}', [CourseController::class, 'update']);
                Route::delete('/{id}', [CourseController::class, 'delete']);
                Route::get('/{id}', [CourseController::class, 'retrieve']);
                Route::get('', [CourseController::class, 'admin_index']);

                Route::group([
                    'prefix' => '{course_id}/course_day'
            
                ], function ($router) {
                    Route::post('', [CourseDayController::class, 'create']);
                    Route::put('/{id}', [CourseDayController::class, 'update']);
                    Route::delete('/{id}', [CourseDayController::class, 'delete']);
                    Route::get('/{id}', [CourseDayController::class, 'retrieve']);
                    Route::get('', [CourseDayController::class, 'index']);

                    Route::group([
                        'prefix' => '{course_day_id}/day_exercise'
                
                    ], function ($router) {
                        Route::post('', [DaysHaveExercisesController::class, 'create']);
                        Route::delete('/{id}', [DaysHaveExercisesController::class, 'delete']);
                        Route::get('/{id}', [DaysHaveExercisesController::class, 'retrieve']);
                        Route::get('', [DaysHaveExercisesController::class, 'index']);
                
                    });
            
                });
            });
            Route::group(['prefix' => 'user_muscle'], function ($router) {
                Route::get('/{id}', [UserMuscleController::class, 'retrieve']);
                Route::put('/{id}', [UserMuscleController::class, 'update']);
                Route::get('', [UserMuscleController::class, 'admin_index']);

        
            });
            Route::group([
                'prefix' => 'practices'
        
            ], function ($router) {
                Route::post('', [PracticeController::class, 'create']);
                Route::put('/{id}', [PracticeController::class, 'update']);
                Route::delete('/{id}', [PracticeController::class, 'delete']);
                Route::get('/{id}', [PracticeController::class, 'retrieve']);
                Route::get('', [PracticeController::class, 'admin_index']);
        
            });

            Route::group([
                'prefix' => 'day_practices'
        
            ], function ($router) {
                Route::post('', [DayPracticeController::class, 'create']);
                Route::put('/{id}', [DayPracticeController::class, 'update']);
                Route::delete('/{id}', [DayPracticeController::class, 'delete']);
                Route::get('/{id}', [DayPracticeController::class, 'retrieve']);
                Route::get('', [DayPracticeController::class, 'admin_index']);
        
            });
        
        }
    );

    Route::group(
        ['prefix' => 'website'],
        function ($router) {
            Route::group([
                'prefix' => 'muscles'
            ], function ($router) {
                Route::get('', [MuscleController::class, 'index']);
            });

            Route::group([
                'prefix' => 'exercises'
            ], function ($router) {
                Route::get('', [ExerciseController::class, 'index']);
            });

            Route::group([
                'prefix' => 'courses'
        
            ], function ($router) {
                Route::post('', [CourseController::class, 'create']);
                Route::put('/{id}', [CourseController::class, 'update']);
                Route::delete('/{id}', [CourseController::class, 'delete']);
                Route::get('/{id}', [CourseController::class, 'retrieve']);
                Route::get('', [CourseController::class, 'index']);

                Route::group([
                    'prefix' => '{course_id}/course_day'
            
                ], function ($router) {
                    Route::post('', [CourseDayController::class, 'create']);
                    Route::put('/{id}', [CourseDayController::class, 'update']);
                    Route::delete('/{id}', [CourseDayController::class, 'delete']);
                    Route::get('/{id}', [CourseDayController::class, 'retrieve']);
                    Route::get('', [CourseDayController::class, 'index']);

                    Route::group([
                        'prefix' => '{course_day_id}/day_exercise'
                
                    ], function ($router) {
                        Route::post('', [DaysHaveExercisesController::class, 'create']);
                        Route::delete('/{id}', [DaysHaveExercisesController::class, 'delete']);
                        Route::get('/{id}', [DaysHaveExercisesController::class, 'retrieve']);
                        Route::get('', [DaysHaveExercisesController::class, 'index']);
                       
                    });
            
                });
            
            });

            Route::group(['prefix' => 'user_muscle'], function ($router) {
                Route::get('/{id}', [UserMuscleController::class, 'retrieve']);
                Route::put('/{id}', [UserMuscleController::class, 'update']);
                Route::get('', [UserMuscleController::class, 'index']);
        
            });

             
            Route::group([
                'prefix' => 'practices'
        
            ], function ($router) {
                Route::post('', [PracticeController::class, 'create']);
                Route::put('/{id}', [PracticeController::class, 'update']);
                Route::delete('/{id}', [PracticeController::class, 'delete']);
                Route::get('/{id}', [PracticeController::class, 'retrieve']);
                Route::get('', [PracticeController::class, 'index']);
        
            });

            Route::group([
                'prefix' => 'day_practices'
        
            ], function ($router) {
                Route::post('', [DayPracticeController::class, 'create']);
                Route::put('/{id}', [DayPracticeController::class, 'update']);
                Route::delete('/{id}', [DayPracticeController::class, 'delete']);
                Route::get('/{id}', [DayPracticeController::class, 'retrieve']);
                Route::get('', [DayPracticeController::class, 'index']);
        
            });
        }
    );

   
   


    


   


   


 
});