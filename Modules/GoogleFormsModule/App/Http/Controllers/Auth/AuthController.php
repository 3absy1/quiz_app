<?php

namespace Modules\GoogleFormsModule\App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\GoogleFormsModule\App\resources\Auth\ShowAdminResource;


class AuthController extends Controller
{


    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255|min:3',
            'email'    => 'required|email|unique:users,email|max:255',
            'password' => 'required|confirmed|max:15|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all()
            ], 422);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);


        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message'  => new ShowAdminResource($user),
            'token'   => $token
        ], 200);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email|max:255',
            'password' => 'required|max:15|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all()
            ], 422);
        }

        $credential = $request->only(['email', 'password']);

        if (!Auth::attempt($credential)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $user =  Auth::user();

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'success'  =>  true,
            'message'  => new ShowAdminResource($user),
            'token'    => $token
        ], 200);
    }

    public function logout()
    {
        if (Auth::check()) {

            Auth::user()->tokens()->delete();
        }

        return response()->json(
            [
                'success' => true,
                'message' => 'Successfully logged out'
            ],
            200
        );
    }

    public function showAdmin()
    {
        return response()->json([
            'success' => true,
            'message' => new ShowAdminResource(Auth::user())
        ], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255|min:3',
            'email'    => ['required', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            'password' => 'nullable|confirmed|max:15|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all()
            ], 422);
        }

        $user = Auth::user();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return response()->json([
            'success' => true,
            'message' => new ShowAdminResource($user)
        ], 200);
    }
}
