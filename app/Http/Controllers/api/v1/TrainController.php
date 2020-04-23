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
                ->leftJoin('type_train', 'type_train.id', '=', 'train.typetrain_id')
                ->get(['train.*', 'users.name as patient_name', 'users.person as patient_person',
                'users.email as patient_email', 'users.phone as patient_phone', 'users.photo as patient_photo', 
                'users.address as patient_address', 'users.dt_nasc as patient_dt_nasc', 
                'type_train.name as type_train_name'])];

            }else{

                //$query = Train::where('therapist_id', $therapist_id)
                //->offset($page-1)
                //->limit(10)
                //->leftJoin('users', 'users.id', '=', 'train.patient_id')
                //->leftJoin('type_train', 'type_train.id', '=', 'train.typetrain_id')
                //->toSql();

                //echo $query;

                $data = ['response' => Train::where('therapist_id', $therapist_id)
                ->offset($page-1)
                ->limit(10)
                ->leftJoin('users', 'users.id', '=', 'train.patient_id')
                ->leftJoin('type_train', 'type_train.id', '=', 'train.typetrain_id')
                ->get(['train.*', 'users.name as patient_name', 'users.person as patient_person',
                'users.email as patient_email', 'users.phone as patient_phone', 'users.photo as patient_photo', 
                'users.address as patient_address', 'users.dt_nasc as patient_dt_nasc', 
                'type_train.name as type_train_name'])];
            }

            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }

    public function show($id)
    {
        try {

            $data = ['response' => Train::findOrFail($id)
            ->leftJoin('users', 'users.id', '=', 'train.patient_id')
            ->leftJoin('type_train', 'type_train.id', '=', 'train.typetrain_id')
            ->get(['train.*', 'users.name as patient_name', 'users.person as patient_person',
            'users.email as patient_email', 'users.phone as patient_phone', 'users.photo as patient_photo', 
            'users.address as patient_address', 'users.dt_nasc as patient_dt_nasc', 
            'type_train.name as type_train_name'])];
            return response()->json($data, 200);

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
            'typetrain_id' => 'required',
            'days_week' => 'required',
            'dt_start' => 'required',
            'dt_end' => 'required',
        ]);

        try {

            $trainData = $request->all();
            $trainData['therapist_id'] = Functions::getUserId();
            $data = ['response' => Train::create($trainData)];
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
            'typetrain_id' => 'required',
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
