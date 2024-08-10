<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use App\Models\Day_Practice;

class DayPracticeController extends Controller
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
                'day_id',
                'course_id',

            );

            $validator = Validator::make($data, [
                'day_id' => 'required',
                'course_id' => 'required',
            
            ]);

            if ($validator->fails()) {
                return response($validator->message(), 422);
            }
            $user = $request->auth();
            $day_practice = Day_Practice::create([
                'user_id' => $request->$user->id,
                'day_id' => $request->exercise_id,
                'course_id' => $request->course_id,
                
            ]);

            return $this->returnData('day_practice_id', $day_practice->id);

        } catch (\Throwable $ex) {


            return response($ex->getMessage(), $ex->getCode());
        }
    }

    public function update(Request $request)
    {
        try {
            $data = $request->only(
                'day_id',
                'course_id',

            );

            $validator = Validator::make($data, [
                'day_id' => 'required',
                'course_id' => 'required',
            
            ]);

            if ($validator->fails()) {
                return response($validator->message(), 422);
            }

            $day_practice = Day_Practice::find($request->id);
            $day_practice->day_id = $request->day_id;
            $day_practice->course_id = $request->course_id;
            
          
            $day_practice->save();

            return $this->returnData('day_practice_id', $day_practice->id);

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
            $day_practice = Day_Practice::find($request->id);
            $day_practice->delete();
            return $this->returnSuccessMessage("day_practice has been deleted successfully");
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
            $day_practice = Day_Practice::find($request->id);
            return $this->returnData('day_practice', $day_practice);
        } catch (\Throwable $ex) {


            return response($ex->getMessage(), $ex->getCode());
        }
    }

    public function index(Request $request)
    {
        try {
            $user = $request->auth();
            $day_practice = Day_Practice::where('user_id', $user->id)->get();
            return $this->returnData('day_practice', $day_practice);
        } catch (\Throwable $ex) {


            return response($ex->getMessage(), $ex->getCode());
        }
    }
}
