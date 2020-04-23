<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Train;
use App\Helpers\Functions;

class TrainUserController extends Controller
{
    public function index(Request $request)
    {
    
        try {

            $patient_id = Functions::getUserId();
            $page = (!empty($request->query()['page'])) ? $request->page : 1;

            $data = ['response' => Train::where('patient_id', $patient_id)
            ->offset($page-1)
            ->limit(10)
            ->leftJoin('users', 'users.id', '=', 'train.therapist_id')
            ->leftJoin('type_train', 'type_train.id', '=', 'train.typetrain_id')
            ->get(['train.*', 'users.name as therapist_name', 'users.person as therapist_person',
            'users.email as therapist_email', 'users.phone as therapist_phone', 'users.photo as therapist_photo', 
            'users.address as therapist_address', 'users.dt_nasc as therapist_dt_nasc', 
            'type_train.name as type_train_name'])];

            return response()->json($data, 200);

        } catch (\Throwable $th) {

            return response()->json($th, 500);

        }
    }
}
