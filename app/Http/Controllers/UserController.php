<?php

namespace App\Http\Controllers;

use App\Models\Course_Day;
use App\Models\Days_Have_Exercises;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Muscle;
use App\Models\UserMuscle;
use stdClass;
use App\Models\Course;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserController extends Controller implements HasMiddleware
{
    //
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public static function middleware(): array
    {

        return [
            new Middleware(middleware: 'auth.guard:api'),
        ];
    }
    use GeneralTrait;


    public function update(Request $request)
    {
        try {

            $user = $request->user();
            
            $bmi = $request->weight / ($request->tall * $request->tall);
            if ($request->course_id) {
                if($user->course_id){
                    $old_course = Course::find($user->course_id);
                    $old_course->left_days = $old_course->duration;
                    $old_course->save();
                }
                $course = Course::find($request->course_id);
                if (!$course->is_public && $course->created_by != $request->user()->id) {
                    return $this->returnError(403, 'Not allowed to join this course');
                }
                if ($course->is_public) {
                    $new_course = Course::create(['name' => $course->name, 'duration' => $course->duration, 'is_public' => false, 'created_by' => $user->id, 'left_days' => $course->left_days]);
                    $days = Course_Day::where('course_id', $course->id)->get();
                    foreach ($days as $day) {
                        $new_day = Course_Day::create(['name' => $day->name, 'course_id' => $new_course->id]);
                        $exercises = Days_Have_Exercises::where('course_day_id', $day->id)->get();
                        foreach ($exercises as $exercise) {
                            Days_Have_Exercises::create(['day_id' => $new_day->id, 'exercise_id' => $exercise->exercise_id]);
                        }
                    }
                    $request->course_id = $new_course->id;
                }
            }
            $user->update($request->only('name', 'level', 'blank_duration', 'tall', 'weight', 'age', 'bmi', 'gender', 'image', 'course_id'));
            if ($request->hasFile('image')) {
                $filename = $request->file('Image_URl')->store('posts', 'public');

                $user->image = $filename;
            }
       
            $bmi = $user->weight / ($user->tall * $user->tall);
            $user->bmi = $bmi;
            $user->save();


            return $this->returnData('user_id', $user->id);
        } catch (\Throwable $ex) {
            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function index(Request $request){
        try{
            $people = User::all();
            return $this->returnData('users', $people);
        }catch(\Throwable $ex){
            return $this->returnError(400, $ex->getMessage());
        }
    }


}
