<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use App\Models\Muscle;
use App\Models\User;
use App\Models\UserMuscle;
class MuscleController extends Controller
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
                'name',
                'image',
            );

            $validator = Validator::make($data, [
                'name' => 'required|unique:muscles',
                'image' => 'required',
                ]);

            if ($validator->fails()) {
            
                return $this->returnValidationError(422, $validator);
            }

            $filename = $request->file('image')->store('posts', 'public');
            
            $muscle = Muscle::create([
                'name' => $request->name,
                'image' => $filename,
            ]);

            $users = User::get();
            foreach($users as $user){
                UserMuscle::create(['user_id'=>$user->id, 'level'=>1, 'muscle_id'=>$muscle->id]);
            }

            return $this->returnData('muscle_id', $muscle->id);
          
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
            );

            $validator = Validator::make($data, [
                'name' => 'required|unique:muscles',
                    ]);

            if ($validator->fails()) {
                return $this->returnValidationError(422, $validator);
            }
            $muscle= Muscle::find( $request->id );
            $muscle->name = $request->name;
            if($request->hasFile('image')){
                $filename = $request->file('Image_URl')->store('posts', 'public');
                $muscle->image = $filename;

            }

          
            $muscle->save();

            return $this->returnData('muscle_id', $muscle->id);
          
        } catch (\Throwable $ex) {
            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function delete(Request $request, $id){
        try {

            $muscle= Muscle::find( $id );
            $muscle->delete();
            return $this->returnSuccessMessage("muscle has been deleted successfully");
        } catch (\Throwable $ex) {
            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function retrieve(Request $request, $id){
        try {
            $muscle= Muscle::find( $id );
            if($muscle){
            return $this->returnData('muscle', $muscle);}
            else{
                return $this->returnError(404, 'Not Found');
            }
        } catch (\Throwable $ex) {
       
      
            return $this->returnError(400, $ex->getMessage());
        }
    }

    public function index(Request $request){
        try {

          $muscles = Muscle::select('id', 'name', 'image')->get();
          return $this->returnData('muscles', $muscles);
        } catch (\Throwable $ex) {
       
      
            return $this->returnError(400, $ex->getMessage());
        }
    }
}
