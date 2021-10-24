<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'user_name' => 'required|string|min:4|max:20',
            'password' => 'required|string|min:8|max:10'
        ]);

        $user = User::create([
            'user_name' => $fields['user_name'],
            'password' => bcrypt($fields['password']),
            'pin' => random_int(100000, 999999)
        ]);

        return response(['user' => $user, 'message' => 'Successfully created']);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'user_name' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check user_name
        $user = User::where('user_name', $fields['user_name'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        if ($user->confirmed == 0) {
            return response([
                'message' => 'You need to confirm your registration. Please check your email to confirm.'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function confirm(Request $request) {

        $fields = $request->validate([
            'user_name' => 'required|string',
            'password' => 'required|string',
            'pin' => 'required|integer'
        ]);

        // Check user_name
        $user = User::where('user_name', $fields['user_name'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $confirmed = \DB::table('users')
              ->where('pin', $fields['pin'])
              ->update(['confirmed' => 1]);

        if ($confirmed==0) {
            return response([
                'message' => 'Wrong Pin'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);

    }

    public function update(Request $request) {

        $request->validate([
            'user_name' => 'required|string',
            'password' => 'required|string',
        ]);
        //
        try {
            $user = User::findOrFail($request->id);

            $user->name = $request->input('name');
            $user->user_name = $request->input('user_name');
            $user->email = $request->input('email');
            $user->user_role = $request->input('user_role');

            if ($request->input('avatar')) {
                $image = $request->input('avatar');
                $imageInfo = explode(";base64,", $image);
                $imgExt = str_replace('data:image/', '', $imageInfo[0]);
                $image = str_replace(' ', '+', $imageInfo[1]);
                $imageName = "article-" . time() . "." . $imgExt;
                Storage::disk('uploads')->put($imageName, base64_decode($image));
                $user->avatar = $imageName;
            }

            if ($user->save()) {
                return ($user);
            }
        } catch (\Exception $e) {
            return \response()->json([
                'status' => 'error',
                'data'   => $e->getMessage()
            ]);
        }
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
