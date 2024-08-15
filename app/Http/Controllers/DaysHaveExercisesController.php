<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use App\Models\Days_Have_Exercises;
use App\Models\Course;
use App\Models\Course_Day;
use Illuminate\Routing\Controllers\HasMiddleware;

class DaysHaveExercisesController extends Controller implements HasMiddleware
{
    use GeneralTrait;

    public static function middleware(): array
    {

        return [
            new Middleware(middleware: 'auth.guard:api', except: ['index']),
        ];

    }


    public function create(Request $request, $course_id, $course_day_id)
    {
        try {
            $course = Course::find($course_id);
            $day = Course_Day::find($course_day_id);

            if (!$day || !$course || $day->course_id != $course_id) {
                return $this->returnError(404, 'Not Found');
            }
            if (!$request->user()->is_admin) {
                if ($request->user()->id != $course->created_by) {
                    return $this->returnError(403, 'Not Allowed to edit this day');
                }
            }

            $data = $request->only(
                'exercise_id',
            );

            $validator = Validator::make($data, [
                'exercise_id' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->returnValidationError(422, $validator);
            }

            $day_exercise = Days_Have_Exercises::create([
                'day_id' => $course_day_id,
                'exercise_id' => $request->exercise_id,
            ]);

            return $this->returnData('day_exercise_id', $day_exercise->id);

        } catch (\Throwable $ex) {


            return $this->returnError(400, $ex->getMessage());
        }
    }


    public function delete(Request $request, $course_id, $course_day_id, $id)
    {
        try {

            $course = Course::find($course_id);
            $day = Course_Day::find($course_day_id);
            $day_has_exercise = Days_Have_Exercises::find($id);

            if ($day_has_exercise->day_id != $course_day_id || $day->course_id != $course_id) {
                return $this->returnError(404, 'Not Found');
            }
            if (!$request->user()->is_admin) {
                if ($request->user()->id != $course->created_by) {
                    return $this->returnError(403, 'Not Allowed to edit this day');
                }
            }
            $day_exercise = Days_Have_Exercises::find($id);
            $day_exercise->delete();
            return $this->returnSuccessMessage("day_exercise has been deleted successfully");
        } catch (\Throwable $ex) {


            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function retrieve(Request $request, $course_id, $course_day_id, $id)
    {
        try {
            $course = Course::find($course_id);
            $day = Course_Day::find($course_day_id);
            $day_has_exercise = Days_Have_Exercises::find($id);

            if ($day_has_exercise->day_id != $course_day_id || $day->course_id != $course_id) {
                return $this->returnError(404, 'Not Found');
            }
            if (!$request->user()->is_admin) {
                if ($request->user()->id != $course->created_by) {
                    return $this->returnError(403, 'Not Allowed to edit this day');
                }
            }
            $day_exercise = Days_Have_Exercises::with(['day', 'exercise'])->find($request->id);
            return $this->returnData('day_exercise', $day_exercise);
        } catch (\Throwable $ex) {


            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function index(Request $request, $course_id, $course_day_id)
    {
        try {
            $course = Course::find($course_id);
            $day = Course_Day::find($course_day_id);

            if (!$course->is_public) {
                if ($day->course_id != $course_id) {
                    return $this->returnError(404, 'Not Found');
                }
                if (!$request->user()->is_admin) {
                    if ($request->user()->id != $course->created_by) {
                        return $this->returnError(403, 'Not Allowed to edit this day');
                    }
                }
            }
            $day_exercises = Days_Have_Exercises::where('day_id', $course_day_id)->with('exercise')->get();
            return $this->returnData('day_exercises', $day_exercises);
        } catch (\Throwable $ex) {


            return $this->returnError(400, $ex->getMessage());
        }
    }
}
