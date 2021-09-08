<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Response;
use App\Http\Controllers\Controller;
use App\Models\Objects;

class ObjectController extends Controller
{
    public function index()
    {
        $objects = Objects::with('owner', 'status', 'type',
                             'manufacture', 'model', 'traction',
                             'fuel', 'responsible')->get();
        $response = ["success" => ["cod" => "", "txt" => "", "fields" => $objects ]];
        return Response::json($response);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return Objects::with('owner', 'status', 'type',
                             'manufacture', 'model', 'traction',
                             'fuel', 'responsible')
                        ->where('code', $id)->get();
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
