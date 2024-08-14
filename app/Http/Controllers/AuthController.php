<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Muscle;
use App\Models\UserMuscle;
use stdClass;

class AuthController extends Controller implements HasMiddleware
{


    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    use GeneralTrait;
    public static function middleware(): array
    {

        return [
            new Middleware(middleware: 'auth.guard:api', except: ['login', 'register']),
        ];

    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login()
    {
        $credentials = request(['email', 'password']);


        $token = Auth::guard('api')->attempt($credentials);
        if (!$token) {
            return $this->returnError(401, 'Invalid credentials');
        }

        return $this->respondWithToken($token);

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        try{
            $user = auth()->user();
            $user = User::with(['muscles'=>function($q){$q->select('id', 'user_id', 'muscle_id', 'level')->with('muscle');}])->find($user->id);

        return $this->returnData('date', $user);
    }catch(\Throwable $ex){
        return $this->returnError(400, $ex->getMessage());
    }
}

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            auth()->logout();

            return $this->returnSuccessMessage("Logged Out Successfully");
        } catch (\Throwable $ex) {

            return $this->returnError(400, $ex->getMessage());
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }


    public function change_password(Request $request)
    {

        try {
            $data = $request->only('old_password', 'new_password', 'new_password_confirmation');
            $validator = Validator::make($data, [
                'old_password' => 'required|current_password:api',
                'new_password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            if ($validator->fails()) {
                return $this->returnValidationError(422, $validator);
            }

            $user = $request->user();
            $user->password = $request->new_password;
            $user->save();

            return $this->returnSuccessMessage("Password Changed Successfully");

        } catch (\Throwable $ex) {
            return $this->returnError(400, $ex->getMessage());
        }


    }

    public function register(Request $request)
    {
        try {

            $data = $request->only(
                'name',
                'email',
                'password',
                'image',
                'blank_duration',
                'tall',
                'weight',
                'age',
                'gender'
            );

            $validator = Validator::make($data, [
                'name' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required',
                'blank_duration' => 'required',
                'tall' => 'required',
                'weight' => 'required',
                'age' => 'required',
                'gender' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->returnValidationError(422, $validator);
            }


            if ($request->hasFile('image')) {
                $filename = $request->file('image')->store('posts', 'public');
            } else {
                $filename = "profiles/DEFAULT.png";
            }
            $bmi = $request->weight / ($request->tall * $request->tall);
            $password = bcrypt($request->password);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
                'blank_duration' => $request->blank_duration,
                'tall' => $request->tall,
                'weight' => $request->weight,
                'age' => $request->age,
                'gender' => $request->gender,
                'bmi' => $bmi,
                'image' => $filename,
            ]);

            $muscles = Muscle::all();
            $obj = new stdClass();
            $obj->user_id = $user->id;
            foreach ($muscles as $muscle) {

                $user_muscle = UserMuscle::create([
                    "user_id" => $user->id,
                    "level" => 1,
                    "muscle_id" => $muscle->id
                ]);
                $obj->muscles_ids[] = $user_muscle->id;
            }
            $credentials = request(['email', 'password']);


            $token = Auth::guard('api')->attempt($credentials);
           
    
            return $this->respondWithToken($token);
    

        } catch (\Throwable $ex) {
            return $this->returnError(400, $ex->getMessage());
        }
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->returnData("data", [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'is_admin' => auth()->user()->is_admin,
        ]);
    }
}