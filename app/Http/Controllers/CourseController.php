<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use App\Models\Course;

class CourseController extends Controller
{
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
                'duration',
                'is_public',

            );

            $validator = Validator::make($data, [
                'name' => 'required',
                'duration' => 'required',
            ]);

            if ($validator->fails()) {
                return response($validator->message(), 422);
            }

            $user = $request->auth();
            $course = Course::create([
                'name' => $request->name,
                'duration' => $request->duration,
                'created_by' => $user->id,
                'is_public' => $request->is_public
            ]);

            return $this->returnData('course_id', $course->id);

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
                'duration',

            );

            $validator = Validator::make($data, [
                'id' => 'required',
                'name' => 'required',
                'duration' => 'required',
            ]);

            if ($validator->fails()) {
                return response($validator->message(), 422);
            }


            $course = Course::find($request->id);
            $course->name = $request->name;
            $course->duration = $request->duration;
            $course->save();

            return $this->returnData('course_id', $course->id);

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
            $course = Course::find($request->id);
            $course->delete();
            return $this->returnSuccessMessage("course has been deleted successfully");
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
            $course = Course::find($request->id);
            return $this->returnData('course', $course);
        } catch (\Throwable $ex) {


            return response($ex->getMessage(), $ex->getCode());
        }
    }

    public function index(Request $request)
    {
        try {

            $user = $request->auth();
            $courses = Course::where('created_by', $user->id)->orwhere('is_public', true)->get();
            return $this->returnData('courses', $courses);
        } catch (\Throwable $ex) {


            return response($ex->getMessage(), $ex->getCode());
        }
    }

}
