<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Train;
use App\Helpers\Functions;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        try {
            $page = ($request->page) ? $request->page : 1;
            $therapist_id = Functions::getUserId();
            $data = ['response' => Train::where('therapist_id', $therapist_id)
            ->offset($page-1)
            ->limit(10)
            ->groupBy(['patient_id', 'users.id'])
            ->leftJoin('users', 'users.id', '=', 'train.patient_id')
            ->get(['users.id as patient_id', 'users.name as patient_name', 'users.person as patient_person',
            'users.email as patient_email', 'users.phone as patient_phone', 'users.photo as patient_photo', 
            'users.address as patient_address', 'users.dt_nasc as patient_dt_nasc'])];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 500);
        }
    }
}
