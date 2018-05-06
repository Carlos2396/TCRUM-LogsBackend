<?php

namespace App\Http\Controllers\API;

use App\Models\Count;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Count::all(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $count = Count::find($id);

        if($count){
            return response($count, 200);
        }
        else{
            return response(["error" => ["Summary not found."]], 404);
        }
    }
}
