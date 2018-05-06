<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Log;
use Illuminate\Support\Facades\Validator;

class LogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Log::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'query' => 'required'
        ]);

        if($validator->fails()){
            return response($validator->errors(), 400);
        }

        $log = Log::create([
            'user_id' => $request->user_id,
            'query'=> $request->query
        ]);

        if(!$log){
            return response(["message", "Failed to save log."], 400);
        }

        return response($log, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Log  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Log $log)
    {   
        return response($log, 200);
    }
}
