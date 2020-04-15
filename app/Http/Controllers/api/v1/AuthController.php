<?php

namespace App\Http\Controllers\Api\v1;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'login' => 'required|string|max:255|unique:users',
            'role' => 'required',
            'cpf_cnpj' => 'required|string|max:20|unique:users',
            'person' => 'required',
            'dt_nasc' => 'required',
            'sex' => 'required|max:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'login'    => $request->login,
                'role'     => $request->role,
                'cpf_cnpj' => $request->cpf_cnpj,
                'person'   => $request->person,
                'crfa'     => $request->crfa,
                'address'  => $request->address,
                'phone'    => $request->phone,
                'photo'    => $request->photo,
                'dt_nasc'  => $request->dt_nasc,
                'sex'      => $request->sex
            ]);
            $token = JWTAuth::fromUser($user);
            return response()->json(compact('user', 'token'), 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }

    }

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));

    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['response' => 'logout'], 200);
            
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }

    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }
}
