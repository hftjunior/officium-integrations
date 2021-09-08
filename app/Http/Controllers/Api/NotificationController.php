<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\UserGroup;
use Response;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notification::all();
        return Response::json($notifications);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        try{
            $notification = Notification::create($data);
        }catch(Illuminate\Database\QueryException $e){
            return array(["message" => "Falha ao criar o registro", "status:" => "404"]);
        }
        return $notification;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_groups = UserGroup::where('login', '=', $id)->get();
        foreach($user_groups as $key => $groups){
            $grp[] = $groups['group_id'];
        }
        //return $grp;
        $notification = Notification::whereNull('read_at')->whereIn('notifiable_id', $grp)->get();
        if($notification){
            return $notification;
        }else{
            return array(["message" => "Registro não encontrado", "status:" => "404"]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = array("read_at" => date('Y-m-d H:i:s'));
        $notification = Notification::find($id);
        if($notification){
            try{
                $notification->update($data);
            }catch(Illuminate\Database\QueryException $e){
                return Response::json(array(["message" => "Falha ao atualizar o registro", "status:" => "404"]));
            }
        }else{
            return Response::json(array(["message" => "Registro não encontrado", "status:" => "404"]));
        }
        return Response::json($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notification = Notification::find($id);
        if($notification){
            try{
                $notification->delete();
            }catch(Illuminate\Database\QueryException $e){
                return "Falha ao apagar o registro.";
            }
            return array(["message" => "Registro apagado", "status:" => "200"]);
        }else{
            return array(["message" => "Registro não encontrado", "status:" => "404"]);
        }

    }
}
