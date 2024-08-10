<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use App\Models\Practice;

class PracticeController extends Controller
{
    //
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
  /*   public static function middleware(): array
    {
       
        return [
            new Middleware(middleware: 'auth:api', except: ['register']),
        ];
    } */
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
                'exercise_id',
                'course_id',
                'duration',
                'feed_back',

            );

            $validator = Validator::make($data, [
                'exercise_id' => 'required',
                'course_id' => 'required',
                'duration' => 'required',
                'feed_back' => 'required',
            
            ]);

            if ($validator->fails()) {
                return response($validator->message(), 422);
            }
            $user = $request->auth();
            $practice = Practice::create([
                'user_id' => $request->$user->id,
                'exercise_id' => $request->exercise_id,
                'course_id' => $request->course_id,
                'duration' => $request->duration,
                'feed_back' => $request->feed_back,
                
            ]);

            return $this->returnData('practice_id', $practice->id);

        } catch (\Throwable $ex) {


            return response($ex->getMessage(), $ex->getCode());
        }
    }

    public function update(Request $request)
    {
        try {
            $data = $request->only(
                'exercise_id',
                'course_id',
                'duration',
                'feed_back',

            );

            $validator = Validator::make($data, [
                'exercise_id' => 'required',
                'course_id' => 'required',
                'duration' => 'required',
                'feed_back' => 'required',
            
            ]);

            if ($validator->fails()) {
                return response($validator->message(), 422);
            }

            $practice = Practice::find($request->id);
            $practice->exercise_id = $request->exercise_id;
            $practice->course_id = $request->course_id;
            $practice->duration = $request->duration;
            $practice->feed_back = $request->feed_back;
          
            $practice->save();

            return $this->returnData('practice_id', $practice->id);

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
            $practice = Practice::find($request->id);
            $practice->delete();
            return $this->returnSuccessMessage("practice has been deleted successfully");
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
            $practice = Practice::find($request->id);
            return $this->returnData('practice', $practice);
        } catch (\Throwable $ex) {


            return response($ex->getMessage(), $ex->getCode());
        }
    }

    public function index(Request $request)
    {
        try {
            $user = $request->auth();
            $practice = Practice::where('user_id', $user->id)->get();
            return $this->returnData('practice', $practice);
        } catch (\Throwable $ex) {


            return response($ex->getMessage(), $ex->getCode());
        }
    }
}
