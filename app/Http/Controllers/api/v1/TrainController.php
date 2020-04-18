<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Train;
use App\Helpers\Functions;

class TrainController extends Controller
{
    public function index(Request $request)
    {
    
        try {

            $therapist_id = Functions::getUserId();
            $page = (!empty($request->query()['page'])) ? $request->page : 1;
            $patient_id = (!empty($request->query()['patient_id'])) ? $request->patient_id : null;

            if(!empty($patient_id)){

                $data = ['response' => Train::whereColumn([
                    ['therapist_id', '=', $therapist_id],
                    ['patient_id', '=', $patient_id],
                ])
                ->offset($page-1)
                ->limit(10)
                ->leftJoin('users', 'users.id', '=', 'train.patient_id')
                ->get()];

            }else{

                $data = ['response' => Train::where('therapist_id', $therapist_id)
                ->offset($page-1)
                ->limit(10)
                ->leftJoin('users', 'users.id', '=', 'train.patient_id')
                ->get()];

            }

            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }

    public function show($id)
    {
        try {
            $data = ['response' => Train::findOrFail($id)->leftJoin('users', 'users.id', '=', 'train.patient_id')];
            response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'qtd_per_day' => 'required',
            'qtd_movement' => 'required',
            'days_week' => 'required',
            'dt_start' => 'required',
            'dt_end' => 'required',
        ]);

        try {
            $typeTrainData = $request->all();
            $data = ['response' => Train::create([                
                'name'          => $request->name,
                'qtd_per_day'   => $request->qtd_per_day,
                'qtd_movement'  => $request->qtd_movement,
                'days_week'     => $request->days_week,
                'dt_start'      => $request->dt_start,
                'dt_end'        => $request->dt_end,
                'therapist_id'  => Functions::getUserId(),
                'patient_id'    => $request->patient_id,
            ])];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'qtd_per_day' => 'required',
            'qtd_movement' => 'required',
            'days_week' => 'required',
            'dt_start' => 'required',
            'dt_end' => 'required'        
        ]);

        try {
            $trainData = $request->all();
            $train = Train::findOrFail($id);
            $data = ['response' => $train->update($trainData)];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }

    public function delete($id){
        try {
            $train = Train::findOrFail($id);
            $data = ['response' => $train->delete()];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }
}
