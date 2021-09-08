<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;

class CityController extends Controller
{
    public function index()
    {
        return City::with('state')->get();
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return City::with('state')->where('id', $id)->get();
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
