<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Muscle;
use App\Models\UserMuscle;
use stdClass;

class UserController extends Controller
{
    //
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public static function middleware(): array
    {

        return [
            new Middleware(middleware: 'auth:api'),
        ];
    }
    use GeneralTrait;
    

    public function update(Request $request)
    {
        try {

            $data = $request->only(
                'name',
                'image',
                'blank_duration',
                'tall',
                'weight',
                'age',
                'gender'
            );
            $validator = Validator::make($data, [
                'name' => 'required',
                'blank_duration' => 'required',
                'tall' => 'required',
                'weight' => 'required',
                'age' => 'required',
                'gender' => 'required',
            ]);
            if ($validator->fails()) {

                return $this->returnError(422, $validator->messages());
            }
            if ($request->hasFile('image')) {
                $filename = $request->file('Image_URl')->store('posts', 'public');
            } else {
                $filename = "profiles/DEFAULT.png";
            }
            $user = $request->user();
            $bmi = $request->weight / ($request->tall * $request->tall);
            $user->update([
                'name' => $request->name,
                'blank_duration' => $request->blank_duration,
                'tall' => $request->tall,
                'weight' => $request->weight,
                'age' => $request->age,
                'gender' => $request->gender,
                'bmi' => $bmi,
                'image' => $filename,
            ]);

            return $this->returnData('user_id', $user->id);
        } catch (\Throwable $ex) {
            return $this->returnError(400, $ex->getMessage());
        }
    }

   
}
