<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\TypeTrain;
use JWTAuth;
use App\Helpers\Functions;

class TypeTrainController extends Controller
{
    public function index(Request $request)
    {
        Functions::getUserId();
        try {
            $data = ['response' => TypeTrain::get()];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }

    public function show($id)
    {
        try {
            $data = ['response' => TypeTrain::findOrFail($id)];
            response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        try {
            $typeTrainData = $request->all();
            $data = ['response' => TypeTrain::create($typeTrainData)];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        try {
            $typeTrainData = $request->all();
            $typeTrain = TypeTrain::findOrFail($id);
            $data = ['response' => $typeTrain->update($typeTrainData)];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }

    public function delete($id){
        try {
            $typeTrain = TypeTrain::findOrFail($id);
            $data = ['response' => $typeTrain->delete()];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }
}
