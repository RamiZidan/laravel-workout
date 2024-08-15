<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use App\Models\Practice;
use App\Models\Days_Have_Exercises;
use App\Models\Course;
use App\Models\Course_Day;
use App\Models\Exercise;
use App\Models\UserMuscle;
use Illuminate\Routing\Controllers\HasMiddleware;

class PracticeController extends Controller implements HasMiddleware
{
    //
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    /*   public static function middleware(): array
      {
         
          return [
              new Middleware(middleware: 'auth:api', except: ['register']),
          ];
      } */
    use GeneralTrait;

    public static function middleware(): array
    {

        return [
            new Middleware(middleware: 'auth.guard:api', except: []),
        ];

    }


    public function create(Request $request)
    {
        try {

            $data = $request->only(
                'day_exercise_id',
                'duration',
                'feed_back',

            );

            $validator = Validator::make($data, [
                'day_exercise_id' => 'required',
                'duration' => 'required',
                'feed_back' => 'required|integer|min:1|max:5',

            ]);

            if ($validator->fails()) {
                return $this->returnValidationError(422, $validator);
            }
            $user = $request->user();
            $day_exercise = Days_Have_Exercises::find($request->day_exercise_id);
            $day = Course_Day::find($day_exercise->day_id);
            $exercise = Exercise::find($day_exercise->exercise_id);
            if ($day->course_id != $user->course_id) {
                return $this->returnError(403, "You Didn't Start This Course");
            }
            
            $practice = Practice::create([
                'user_id' => $user->id,
                'exercise_id' => $day_exercise->exercise_id,
                'day_id' => $day_exercise->day_id,
                'duration' => $request->duration,
                'feed_back' => $request->feed_back,
            ]);
            switch ($request->feed_back) {
                case (1):
                    $new_exercise = Exercise::where('muscle_id', $exercise->muscle_id)->where('level', $exercise->level + 1)->first();
                    if ($new_exercise) {
                        $day_exercise->exercise_id = $new_exercise->id;
                        $user_muscle = UserMuscle::where('user_id', $user->id)->where('muscle_id', $exercise->muscle_id)->first();
                        $user_muscle->level = $new_exercise->level;
                        $day_exercise->save();
                        $user_muscle->save();
                    }
                    break;
                case (2):
                    $old_practice = Practice::where('user_id', $user->id)->where('exercise_id', $day_exercise->exercise_id)->where('day_id', $day_exercise->id)->where('feed_back', 2)->get();
                    if ($old_practice && count($old_practice) > 3) {
                        $new_exercise = Exercise::where('muscle_id', $exercise->muscle_id)->where('level', $exercise->level + 1)->first();
                        if ($new_exercise) {
                            $day_exercise->exercise_id = $new_exercise->id;
                            $user_muscle = UserMuscle::where('user_id', $user->id)->where('muscle_id', $exercise->muscle_id)->first();
                            $user_muscle->level = $new_exercise->level;
                            $day_exercise->save();
                            $user_muscle->save();
                        }
                    } else {
                        $user_muscle = UserMuscle::where('user_id', $user->id)->where('muscle_id', $exercise->muscle_id)->first();
                        $user_muscle->level = $exercise->level;
                        $user_muscle->save();
                    }
                    break;
                case (3):
                    $old_practice = Practice::where('user_id', $user->id)->where('exercise_id', $day_exercise->exercise_id)->where('day_id', $day_exercise->id)->where('feed_back', 3)->get();
                    if ($practice && count($old_practice) > 7) {
                        $new_exercise = Exercise::where('muscle_id', $exercise->muscle_id)->where('level', $exercise->level - 1)->first();
                        if ($new_exercise) {
                            $day_exercise->exercise_id = $new_exercise->id;
                            $user_muscle = UserMuscle::where('user_id', $user->id)->where('muscle_id', $exercise->muscle_id)->first();
                            $user_muscle->level = $new_exercise->level;
                            $day_exercise->save();
                            $user_muscle->save();
                        }
                    } else {
                        $user_muscle = UserMuscle::where('user_id', $user->id)->where('muscle_id', $exercise->muscle_id)->first();
                        $user_muscle->level = $exercise->level;
                        $user_muscle->save();
                    }
                    break;
                case (4):
                    $old_practice = Practice::where('user_id', $user->id)->where('exercise_id', $day_exercise->exercise_id)->where('day_id', $day_exercise->id)->where('feed_back', 4)->get();
                    if ($old_practice && count($old_practice) > 3) {
                        $new_exercise = Exercise::where('muscle_id', $exercise->muscle_id)->where('level', $exercise->level - 1)->first();
                        if ($new_exercise) {
                            $day_exercise->exercise_id = $new_exercise->id;
                            $user_muscle = UserMuscle::where('user_id', $user->id)->where('muscle_id', $exercise->muscle_id)->first();
                            $user_muscle->level = $new_exercise->level;
                            $day_exercise->save();
                            $user_muscle->save();
                        }
                    } else {
                        $user_muscle = UserMuscle::where('user_id', $user->id)->where('muscle_id', $exercise->muscle_id)->first();
                        $user_muscle->level = $exercise->level;
                        $user_muscle->save();
                    }
                    break;
                case (5):
                    $new_exercise = Exercise::where('muscle_id', $exercise->muscle_id)->where('level', $exercise->level - 1)->first();
                    if ($new_exercise) {
                        $day_exercise->exercise_id = $new_exercise->id;
                        $user_muscle = UserMuscle::where('user_id', $user->id)->where('muscle_id', $exercise->muscle_id)->first();
                        $user_muscle->level = $new_exercise->level;
                        $day_exercise->save();
                        $user_muscle->save();
                    }
                    break;
            }


            return $this->returnData('practice_id', $practice->id);

        } catch (\Throwable $ex) {


            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->only(

                'duration',

            );

            $validator = Validator::make($data, [

                'duration' => 'required',

            ]);

            if ($validator->fails()) {
                return $this->returnValidationError(422, $validator);
            }
            $practice = Practice::find($id);
            $user = $request->user();
            if (!$user->is_admin) {
                if ($practice->user_id != $user->id) {
                    return $this->returnError(403, "This is Not Your Practice");

                }
            }

            $practice->duration = $request->duration;

            $practice->save();
            return $this->returnData('practice_id', $practice->id);

        } catch (\Throwable $ex) {
            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $practice = Practice::find($id);
            $user = $request->user();
            if (!$user->is_admin) {
                if ($practice->user_id != $user->id) {
                    return $this->returnError(403, "This is Not Your Practice");

                }
            }
            $practice->delete();
            return $this->returnSuccessMessage("practice has been deleted successfully");
        } catch (\Throwable $ex) {


            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function retrieve(Request $request, $id)
    {
        try {
            $practice = Practice::find($id);
            $user = $request->user();
            if (!$user->is_admin) {
                if ($practice->user_id != $user->id) {
                    return $this->returnError(403, "This is Not Your Practice");

                }
            }
            return $this->returnData('practice', $practice);
        } catch (\Throwable $ex) {

            return $this->returnError(400, $ex->getMessage());

        }
    }

    public function index(Request $request)
    {
        try {
            $user = $request->user();
            if($user->is_admin){
                try {
                    $practice = Practice::get();
                    return $this->returnData('practice', $practice);
                } catch (\Throwable $ex) {
        
        
                    return $this->returnError(400, $ex->getMessage());
                }
            }
            else{
                $practice = Practice::where('user_id', $user->id)->get();
                return $this->returnData('practice', $practice);
            }
        } catch (\Throwable $ex) {

            return $this->returnError(400, $ex->getMessage());

        }
    }

    public function admin_index(Request $request)
    {
        try {
            $practice = Practice::get();
            return $this->returnData('practice', $practice);
        } catch (\Throwable $ex) {


            return $this->returnError(400, $ex->getMessage());
        }
    }
}
