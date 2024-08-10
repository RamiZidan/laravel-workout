<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use App\Models\Days_Have_Exercises;

class DaysHaveExercisesController extends Controller
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
                'exercise_id',
            );

            $validator = Validator::make($data, [
                'day_id' => 'required',
                'exercise_id' => 'required'
            ]);

            if ($validator->fails()) {
                return response($validator->message(), 422);
            }

            $day_exercise = Days_Have_Exercises::create([
                'day_id' => $request->day_id,
                'exercise_id' => $request->exercise_id,
            ]);

            return $this->returnData('day_exercise_id', $day_exercise->id);

        } catch (\Throwable $ex) {


            return response($ex->getMessage(), $ex->getCode());
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
            $day_exercise = Days_Have_Exercises::find($request->id);
            $day_exercise->delete();
            return $this->returnSuccessMessage("day_exercise has been deleted successfully");
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
            $day_exercise = Days_Have_Exercises::find($request->id)->with(['day', 'exercise']);
            return $this->returnData('day_exercise', $day_exercise);
        } catch (\Throwable $ex) {


            return response($ex->getMessage(), $ex->getCode());
        }
    }

    public function index(Request $request)
    {
        try {
            $data = $request->only(
                'day_id',

            );

            $validator = Validator::make($data, [
                'day_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response($validator->message(), 422);
            }
            $day_exercises = Days_Have_Exercises::where('day_id', $request->day_id)->with(['day', 'exercise'])->get();
            return $this->returnData('day_exercises', $day_exercises);
        } catch (\Throwable $ex) {


            return response($ex->getMessage(), $ex->getCode());
        }
    }
}
