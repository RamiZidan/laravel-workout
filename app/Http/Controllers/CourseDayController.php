<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use App\Models\Course_Day;

class CourseDayController extends Controller
{
    //
 
    use GeneralTrait;
    public static function middleware(): array
    {
        
        return [
            new Middleware(middleware: 'auth:api'),
        ];
           
    }

    public function create(Request $request)
    {
        try {

            $data = $request->only(
                'name',
                'course_id',

            );

            $validator = Validator::make($data, [
                'course_id' => 'required',
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return response($validator->message(), 422);
            }

            
            $course_day = Course_Day::create([
                'name' => $request->name,
                'course_id' => $request->course_id,
            ]);

            return $this->returnData('course_day_id', $course_day->id);

        } catch (\Throwable $ex) {


            return response($ex->getMessage(), $ex->getCode());
        }
    }

    public function update(Request $request)
    {
        try {

            $data = $request->only(
                'id',
                'name',
            );

            $validator = Validator::make($data, [
                'id' => 'required',
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return response($validator->message(), 422);
            }


            $course_day = Course_Day::find($request->id);
            $course_day->name = $request->name;
            $course_day->save();

            return $this->returnData('course_day_id', $course_day->id);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {

            $data = $request->only(
                'id',

            );

            $validator = Validator::make($data, [
                'id' => 'required',
            ]);

            if ($validator->fails()) {
                return response($validator->message(), 422);
            }
            $course_day = Course_Day::find($request->id);
            $course_day->delete();
            return $this->returnSuccessMessage("course_day has been deleted successfully");
        } catch (\Throwable $ex) {


            return response($ex->getMessage(), $ex->getCode());
        }
    }

    public function retrieve(Request $request)
    {
        try {
            $data = $request->only(
                'id',

            );

            $validator = Validator::make($data, [
                'id' => 'required',
            ]);

            if ($validator->fails()) {
                return response($validator->message(), 422);
            }
            $course_day = Course_Day::find($request->id);
            return $this->returnData('course_day', $course_day);
        } catch (\Throwable $ex) {


            return response($ex->getMessage(), $ex->getCode());
        }
    }

    public function index(Request $request)
    {
        try {

            $data = $request->only(
                'course_id',

            );

            $validator = Validator::make($data, [
                'course_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response($validator->message(), 422);
            }
            $course_days = Course_Day::where('course_id', $request->course_id)->get();
            return $this->returnData('course_days', $course_days);
        } catch (\Throwable $ex) {


            return response($ex->getMessage(), $ex->getCode());
        }
    }

}
