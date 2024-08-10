<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use App\Models\Exercise;

class ExerciseController extends Controller
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
                'image',
                'set_count',
                'times',
                'level',
                'muscle_id'

            );

            $validator = Validator::make($data, [
                'name' => 'required',
                'image' => 'required',
                'set_count' => 'required',
                'times' => 'required',
                'level' => 'required',
                'muscle_id' => 'required'

            ]);

            if ($validator->fails()) {
                return response($validator->message(), 422);
            }
            $filename = $request->file('image')->store('posts', 'public');

            $exercise = Exercise::create([
                'name' => $request->name,
                'set_count' => $request->set_count,
                'times' => $request->times,
                'level' => $request->level,
                'muscle_id'  => $request->muscle_id,
                'image' => $filename,
            ]);

            return $this->returnData('exercise_id', $exercise->id);

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
                'image',
                'set_count',
                'times',
                'level',
                'muscle_id'

            );

            $validator = Validator::make($data, [
                'id'=>'required',
                'name' => 'required',
                'image' => 'required',
                'set_count' => 'required',
                'times' => 'required',
                'level' => 'required',
                'muscle_id' => 'required'

            ]);

            if ($validator->fails()) {
                return response($validator->message(), 422);
            }
            $filename = $request->file('image')->store('posts', 'public');


            $exercise = Exercise::find($request->id);
            $exercise->name = $request->name;
            $exercise->set_count = $request->set_count;
            $exercise->times = $request->times;
            $exercise->level = $request->level;
            $exercise->muscle_id = $request->muscle_id;
            $exercise->image = $filename;

            $exercise->save();

            return $this->returnData('exercise_id', $exercise->id);

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
            $exercise = Exercise::find($request->id);
            $exercise->delete();
            return $this->returnSuccessMessage("exercise has been deleted successfully");
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
            $exercise = Exercise::find($request->id);
            return $this->returnData('exercise', $exercise);
        } catch (\Throwable $ex) {


            return response($ex->getMessage(), $ex->getCode());
        }
    }

    public function index(Request $request)
    {
        try {
            $exercises = Exercise::get();
            return $this->returnData('exercises', $exercises);
        } catch (\Throwable $ex) {


            return response($ex->getMessage(), $ex->getCode());
        }
    }
}
