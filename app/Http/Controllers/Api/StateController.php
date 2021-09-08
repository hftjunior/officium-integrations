<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\State;

class StateController extends Controller
{
    public function index()
    {
        return State::all();
    }


    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return State::findOrFail($id);
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
