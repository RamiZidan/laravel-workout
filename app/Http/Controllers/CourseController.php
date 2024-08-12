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
            new Middleware(middleware: 'auth:api', except: ['index']),
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

            $user = $request->user();
            $course = Course::create([
                'name' => $request->name,
                'duration' => $request->duration,
                'created_by' => $user->id,
                'left_days' => $request->duration

            ]);
            $user = $request->user();
            if ($user->is_admin) {
                $course->is_public = $request->is_public;
                $course->save();
            }

            return $this->returnData('course_id', $course->id);

        } catch (\Throwable $ex) {


            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $course = Course::find($id);
            $user = $request->user();
            if (!$user->is_admin) {
                if ($course->created_by != $user->id) {
                    return $this->returnError(404, "Course Not Found");
                }
            }
            $course->update($request->only('name', 'duration'));
            if ($user->is_admin) {
                $course->update($request->only('is_public'));
            }


            return $this->returnData('course_id', $course->id);

        } catch (\Throwable $ex) {
            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $course = Course::find($id);
            $user = $request->user();
            if (!$user->is_admin) {
                if ($course->created_by != $user->id) {
                    return $this->returnError(404, "Course Not Found");
                }
            }
            $course->delete();
            return $this->returnSuccessMessage("course has been deleted successfully");
        } catch (\Throwable $ex) {


            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function retrieve(Request $request, $id)
    {
        try {
            $course = Course::find($id);
            $user = $request->user();
            if (!$user->is_admin) {
                if ($course->created_by != $user->id && !$course->is_public) {
                    return $this->returnError(404, "Course Not Found");
                }
            }
            return $this->returnData('course', $course);
        } catch (\Throwable $ex) {


            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function index(Request $request)
    {
        try {

            $user = $request->user();
            if ($user) {
                $courses = Course::where('created_by', $user->id)->orwhere('is_public', true)->get();
            } else {
                $courses = Course::where('is_public', true)->get();
            }
            return $this->returnData('courses', $courses);
        } catch (\Throwable $ex) {
            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function admin_index(Request $request)
    {
        try {
            $courses = Course::get();
            return $this->returnData('courses', $courses);
        } catch (\Throwable $ex) {
            return $this->returnError(400, $ex->getMessage());
        }
    }

}
