<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use App\Models\Course_Day;
use App\Models\Course;
use Illuminate\Routing\Controllers\HasMiddleware;

class CourseDayController extends Controller implements HasMiddleware
{
    //

    use GeneralTrait;
    public static function middleware(): array
    {

        return [
            new Middleware(middleware: 'auth.guard:api', except: ['index']),
        ];

    }

    public function create(Request $request, $course_id)
    {
        try {

            $course = Course::find($course_id);
            if (!$request->user()->is_admin) {
                if ($request->user()->id != $course->created_by) {
                    return $this->returnError(403, 'Not Allowed to edit this course');
                }
            }
            $data = $request->only(
                'name',
            );

            $validator = Validator::make($data, [
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->returnValidationError(422, $validator);
            }


            $course_day = Course_Day::create([
                'name' => $request->name,
                'course_id' => $course_id,
            ]);

            return $this->returnData('course_day_id', $course_day->id);

        } catch (\Throwable $ex) {


            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function update(Request $request, $course_id, $id)
    {
        try {
            $course = Course::find($course_id);
            $day = Course_Day::find($id);
            if ($day->course_id != $course_id) {
                return $this->returnError(404, 'Not Found');
            }
            if (!$request->user()->is_admin) {
                if ($request->user()->id != $course->created_by) {
                    return $this->returnError(403, 'Not Allowed to edit this day');
                }
            }

            $data = $request->only(
                'name',
            );

            $validator = Validator::make($data, [
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->returnValidationError(422, $validator);
            }


            $course_day = Course_Day::find($id);
            $course_day->name = $request->name;
            $course_day->save();

            return $this->returnData('course_day_id', $course_day->id);

        } catch (\Throwable $ex) {
            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function delete(Request $request, $course_id, $id)
    {
        try {
            $course = Course::find($course_id);
            $day = Course_Day::find($id);
            if ($day->course_id != $course_id) {
                return $this->returnError(404, 'Not Found');
            }
            if (!$request->user()->is_admin) {
                if ($request->user()->id != $course->created_by) {
                    return $this->returnError(403, 'Not Allowed to edit this day');
                }
            }

            $course_day = Course_Day::find($id);
            $course_day->delete();
            return $this->returnSuccessMessage('course has been deleted successfully');
        } catch (\Throwable $ex) {


            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function retrieve(Request $request, $course_id, $id)
    {
        try {
            $course = Course::find($course_id);
            $day = Course_Day::find($id);
            if ($day->course_id != $course_id) {
                return $this->returnError(404, 'Not Found');
            }
            if (!$request->user()->is_admin) {
                if ($request->user()->id != $course->created_by && !$course->is_public) {
                    return $this->returnError(403, 'Not Allowed to edit this day');
                }
            }

            $course_day = Course_Day::with([
                'exercises' => function ($q) {
                    $q->with(['exercise']);
                }
            ])->find($id);
            if(count($course_day->exercises)> 0){
                $course_day->first_exercise = $course_day->exercises[0]->id;
            }
            else{
                $course_day->first_exercise = null;

            }
            return $this->returnData('course_day', $course_day);
        } catch (\Throwable $ex) {


            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function index(Request $request, $course_id)
    {
        try {
            $course = Course::find($course_id);

            if (!$request->user()->is_admin) {
                if ($request->user()->id != $course->created_by && !$course->is_public) {
                    return $this->returnError(403, 'Not Allowed to edit this day');
                }
            }
            $course_days = Course_Day::where('course_id', $course_id)->with('exercises')->get();
            foreach($course_days as $course_day){
                if(count($course_day->exercises)> 0){
                    $course_day->first_exercise = $course_day->exercises[0]->id;
                }
                else{
                    $course_day->first_exercise = null;

                }
                unset($course_day->exercises);

            }
            return $this->returnData('course_days', $course_days);


        } catch (\Throwable $ex) {
            return $this->returnError(400, $ex->getMessage());
        }
    }

}
