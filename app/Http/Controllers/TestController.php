<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        return view('test');
    }

    public function submit(Request $request)
    {
        //   dd($request->all());
    return response()->json([
        'message' => 'Form submitted successfully!',
        'data' =>[
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
        ],
    ]);

    //  return response()->json([
    //     "status" => true,
    //     "message" => "Data Received Successfully"
    // ]);
    
    }
}
