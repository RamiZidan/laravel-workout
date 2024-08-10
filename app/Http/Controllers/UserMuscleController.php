<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use App\Models\UserMuscle;
use App\Models\User;

class UserMuscleController extends Controller
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
                'level',
                'muscle_id'
            );

            $validator = Validator::make($data, [
                'level' => 'required',
                'muscle_id' => 'required'
            ]);

            if ($validator->fails()) {
                return response($validator->message(), 422);
            }

            $user = $request->auth();
            $user_muscle = UserMuscle::create([
                'user_id' => $user->id,
                'level' => $request->level,
                'muscle_id' => $request->muscle_id
            ]);

            return $this->returnData('user_muscle_id', $user_muscle->id);

        } catch (\Throwable $ex) {


            return response($ex->getMessage(), $ex->getCode());
        }
    }

    public function update(Request $request)
    {
        try {

            $data = $request->only(
                'id',
                'level',

            );

            $validator = Validator::make($data, [
                'id' => 'required',
                'level' => 'required',

            ]);

            if ($validator->fails()) {
                return response($validator->message(), 422);
            }

            $user_muscle = UserMuscle::find($request->id);
            $user_muscle->level = $request->level;
            $user_muscle->save();

            return $this->returnData('user_muscle_id', $user_muscle->id);

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
            $muscle = UserMuscle::find($request->id);
            $muscle->delete();
            return $this->returnSuccessMessage("user muscle has been deleted successfully");
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
            $muscle = UserMuscle::find($request->id);
            return $this->returnData('user_muscle', $muscle);
        } catch (\Throwable $ex) {


            return response($ex->getMessage(), $ex->getCode());
        }
    }

    public function index(Request $request)
    {
        try {

            $user = $request->auth();
            $muscles = UserMuscle::where('user_id', $user->id)->get();
            return $this->returnData('user_muscles', $muscles);
        } catch (\Throwable $ex) {


            return response($ex->getMessage(), $ex->getCode());
        }
    }
}
