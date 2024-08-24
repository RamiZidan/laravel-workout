<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use App\Models\Day_Practice;
use App\Models\Course;
use App\Models\Course_Day;
use Illuminate\Routing\Controllers\HasMiddleware;

class DayPracticeController extends Controller implements HasMiddleware
{
    use GeneralTrait;

    public static function middleware(): array
    {

        return [
            new Middleware(middleware: 'auth.guard:api'),
        ];

    }

    public function create(Request $request)
    {
        try {

            $data = $request->only(
                'day_id',

            );

            $validator = Validator::make($data, [
                'day_id' => 'required',

            ]);

            if ($validator->fails()) {
                return $this->returnValidationError(
                    422,
                    $validator
                );
            }
            $user = $request->user();
            $course_day = Course_Day::find($request->day_id);
            if($user->course_id != $course_day->course_id){
                return $this->returnError(403, "This is not Your Course");
            }
            $course = Course::find($course_day->course_id);
            $day_practice = Day_Practice::create([
                'user_id' => $user->id,
                'day_id' => $request->day_id,

            ]);
            $day_practices = Day_Practice::where('user_id', $day_practice->user_id)->whereDate('created_at', '=', $day_practice->created_at)->get();
            if (count($day_practices) == 1) {
               
                $course->left_days -= 1;
                $course->save();
            }

            return $this->returnData('day_practice_id', $day_practice->id);

        } catch (\Throwable $ex) {


            return $this->returnError(400, $ex->getMessage());
        }
    }



    public function delete(Request $request, $id)
    {
        try {


            $day_practice = Day_Practice::find($request->id);

            if (!$request->user()->is_admin) {
                if ($request->user()->id != $day_practice->user_id) {
                    return $this->returnError(403, 'This is not your practice');
                }
            }
            $day_practice->delete();
            return $this->returnSuccessMessage("day_practice has been deleted successfully");
        } catch (\Throwable $ex) {


            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function retrieve(Request $request, $id)
    {
        try {
            $day_practice = Day_Practice::find($request->id);

            if (!$request->user()->is_admin) {
                if ($request->user()->id != $day_practice->user_id) {
                    return $this->returnError(403, 'This is not your practice');
                }
            }
            return $this->returnData('day_practice', $day_practice);
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
                    $day_practice = Day_Practice::get();
                    return $this->returnData('day_practice', $day_practice);
                } catch (\Throwable $ex) {
                    return $this->returnError(400, $ex->getMessage());
                }
            }
            else{
                $day_practice = Day_Practice::where('user_id', $user->id)->get();
                return $this->returnData('day_practice', $day_practice);
            }
        } catch (\Throwable $ex) {
            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function admin_index(Request $request)
    {
        try {
            $day_practice = Day_Practice::get();
            return $this->returnData('day_practice', $day_practice);
        } catch (\Throwable $ex) {
            return $this->returnError(400, $ex->getMessage());
        }
    }
}
