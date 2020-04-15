<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(Request $request)
    {
        try {
            $page = ($request->page) ? 1 : $request->page;
            $data = ['response' => User::offset($page-1)->limit(10)->get()];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }

    public function show($id)
    {
        try {
            $data = ['response' => User::findOrFail($id)];
            response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }

    public function store(Request $request)
    {
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
            $data = ['response' => $user];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $userData = $request->all();
            $user = User::findOrFail($id);
            $data = ['response' => $user->update($userData)];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }

    public function delete($id){
        try {
            $user = User::findOrFail($id);
            $data = ['response' => $user->delete()];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }
}
