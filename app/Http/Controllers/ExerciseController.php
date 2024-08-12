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
            new Middleware(middleware: 'auth:api', except: ['index']),
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
                return $this->returnValidationError(422, $validator);
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


            return $this->returnError(400, $ex->getMessage());

        }
    }

    public function update(Request $request, $id)
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
                'set_count' => 'required',
                'times' => 'required',
                'level' => 'required',
                'muscle_id' => 'required'

            ]);

            if ($validator->fails()) {
                return $this->returnValidationError(422, $validator);
            }
            $exercise = Exercise::find($id);
            $exercise->name = $request->name;
            $exercise->set_count = $request->set_count;
            $exercise->times = $request->times;
            $exercise->level = $request->level;
            $exercise->muscle_id = $request->muscle_id;

            if($request->hasFile('image')){
                $filename = $request->file('image')->store('posts', 'public');
                $exercise->image = $filename;

            }

            $exercise->save();

            return $this->returnData('exercise_id', $exercise->id);

        } catch (\Throwable $ex) {
            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $exercise = Exercise::find($id);
            $exercise->delete();
            return $this->returnSuccessMessage("exercise has been deleted successfully");
        } catch (\Throwable $ex) {
            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function retrieve(Request $request, $id)
    {
        try{
            $exercise = Exercise::find($id);
            return $this->returnData('exercise', $exercise);
        } catch (\Throwable $ex) {
            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function index(Request $request)
    {
        try {
            $exercises = Exercise::get();
            return $this->returnData('exercises', $exercises);
        } catch (\Throwable $ex) {
            return $this->returnError(400, $ex->getMessage());
        }
    }
}
