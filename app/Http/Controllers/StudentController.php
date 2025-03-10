<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{    

    public function getUser(Request $request)
    {

        if ($request->has('term')) {
            $email = $request->term;
            $data = \DB::table('users')
                ->where('tenant_organization', auth()->user()->organization)
                ->where('email', 'LIKE', '%'.$email.'%')
                ->selectRaw('user_id, email, user_name')
                ->get();
        }else{
            $data = \DB::table('users')
                ->where('tenant_organization', auth()->user()->organization)
                ->selectRaw('user_id, email, user_name')
                ->offset(0)->limit(10)
                ->get();
        }        

        return response()->json($data);
    }

}
