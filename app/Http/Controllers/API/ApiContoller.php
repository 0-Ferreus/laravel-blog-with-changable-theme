<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;


class ApiContoller extends Controller
{
    //
    public function index()
    {
        return response()->json([
            'name' => 'Abigail',
            'state' => 'CA',
        ]);
    }

    public function login(Request $request){

        $token = Str::random(50);
        $user = User::where('email',$request->email)->first();
        $user->forceFill([
            'remember_token' => hash('sha256', $token),
        ])->save();

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'token' => $token,
            'data' => $request->all(),
        ]);
    }

    public function categories(Request $request){
        $categories = Category::all();
        return response()->json([
            'status' => 'success',
            'data' => $categories,
        ]);
    }
    
    public function register(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign default role to the user
        $user->assignRole('user');

        // Generate a unique token for the user
        $token = Str::random(50);
        $user->forceFill([
            'remember_token' => hash('sha256', $token),
        ])->save();

        // Return a successful response with the user data and token
        return response()->json([
            'status' => 'success',
            'message' => 'Registered Successfully',
            'user' => $user,
            'token' => $token,
        ]);
    }
}
