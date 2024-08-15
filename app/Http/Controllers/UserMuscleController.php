<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use App\Models\UserMuscle;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserMuscleController extends Controller implements HasMiddleware
{

    use GeneralTrait;

    public static function middleware(): array
    {

        return [
            new Middleware(middleware: 'auth.guard:api', except: []),
        ];

    }


    public function update(Request $request, $id)
    {
        try {
            $muscle = UserMuscle::find($id);
            if (!$muscle) {
                return $this->returnError(404, "Not Found");
            }
            if (!$request->user()->is_admin) {
                if ($request->user()->id != $muscle->user_id) {
                    return $this->returnError(400, "Not allowed to edit this muscle");
                }
            }
            $data = $request->only(
                'level',

            );

            $validator = Validator::make($data, [
                'level' => 'required',

            ]);

            if ($validator->fails()) {
                return $this->returnValidationError(422, $validator);
            }

            $user_muscle = UserMuscle::find($request->id);
            $user_muscle->level = $request->level;
            $user_muscle->save();

            return $this->returnData('user_muscle_id', $user_muscle->id);

        } catch (\Throwable $ex) {
            return $this->returnError(400, $ex->getMessage());
        }
    }


    public function retrieve(Request $requbest, $id)
    {
        try {

            $muscle = UserMuscle::find($id);
            return $this->returnData('user_muscle', $muscle);
        } catch (\Throwable $ex) {


            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function index(Request $request)
    {
        try {

            $user = $request->user();
            $muscles = UserMuscle::with(['muscle'])->where('user_id', $user->id)->get();
            return $this->returnData('user_muscles', $muscles);
        } catch (\Throwable $ex) {


            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function admin_index(Request $request, $user_id)
    {
        try {

            
            $muscles = UserMuscle::where('user_id', $user_id)->with(['muscle'])->get();
            return $this->returnData('user_muscles', $muscles);
        } catch (\Throwable $ex) {


            return $this->returnError(400, $ex->getMessage());
        }
    }
}
