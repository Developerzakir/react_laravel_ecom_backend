<?php

namespace App\Http\Controllers\Admin;

use App\Models\Size;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::orderBy('name','ASC')->get();
        return response()->json([
            'status' =>200,
            'data'=>$sizes
        ],200);

    } //End method

    public function store(Request $request)
    {


    } //End method

    public function show($id)
    {

    } //End method

    public function update($id, Request $request)
    {

    } //End method

    public function destroy($id)
    {

    } //End method
}
