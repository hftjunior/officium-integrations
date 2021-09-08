<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Validator;
use Alert;
use DB;
use Gate;
use Auth;
use Junges\ACL\Http\Models\Group;
use Junges\ACL\Http\Models\Permission;

class GroupController extends Controller
{
    private $title;
    private $description;
    private $breadcrumb;

    private $groups;

    public function __construct(Group $groups){
        $this->title = 'Grupos de Acesso';
        $this->description = 'cadastro de grupos de acesso';
        $this->breadcrumb = [
            ['page'  => 'Home', 'url' => route('home')],
            ['page'  => 'Administração', 'url' => ''],
            ['page'  => $this->title, 'url' => route('groups.index')]
        ];

        $this->groups = $groups;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->title;
        $description = $this->description;
        $breadcrumb = $this->breadcrumb;

        return view('admin.groups.index', compact('title', 'description','breadcrumb'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $description = $this->description;
        $breadcrumb = $this->breadcrumb;

        $permissions = Permission::orderBy('name')->get();

        return view('admin.groups.create', compact('title', 'description','breadcrumb','permissions'));
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
        /** validation */
        $attributes = array(
            'name'                  => 'Nome',
            'slug'                  => 'Slug',
            'description'           => 'Descrição'
        );
        $validation = Validator::make($data,[
            'name'                  => 'required|string|max:191',
            'slug'                  => 'required|string|max:191|unique:groups,slug',
            'description'           => 'nullable|string'
        ]);
        $validation->setAttributeNames($attributes);
        if($validation->fails()){
            $error = $validation->messages();
            $message = "";
            foreach($error->messages() as $key => $value){
                $message .= $value[0]."<br/>";
            }
            alert()->html('<i>Erro</i>',' <h5>Problema no preenchimento de campo(s) do formulário.</h5> <small><b>'.$message.'</b></small>','error');
            return redirect()->back()->withInput();
        }

        /** database statment */
        try{
            $group = Group::create($data);
            if(isset($data['permissions'])){
                $group->syncPermissions($data['permissions']);
            }
        } catch (\Illuminate\Database\QueryException $e){
            alert()->html('<i>Erro</i>',' <h5>Problema ao criar o registro.</h5> <small><b>'.$e->errorInfo[2].'</b></small>','error')
               ->autoClose(8000);
            return redirect()->back();
        } catch (PDOException $e){
            alert()->html('<i>Erro</i>','<h5><b>Falha ao acessar o banco de dados.</b><br/>Código: '.$e->errorInfo[0].'<br/>Mensagem: '.$e->errorInfo[2].'</h5>', 'error')
               ->autoClose(8000);
            return redirect()->back();
        }
        alert()->html('<i>Ok</i>','<h5><b>Registro criado com sucesso.</b></h5>', 'success')
                   ->autoClose(8000)
                   ->toToast();
        return redirect()->route('groups.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = $this->title;
        $description = $this->description;
        $breadcrumb = $this->breadcrumb;

        $group = $this->groups->find($id);
        $permissions = Permission::orderBy('name')->get();
        $editpermissions = [];
        foreach ($group->permissions as $key => $value) {
            array_push($editpermissions, $value['slug']);
        }

        return view('admin.groups.edit', compact('title', 'description','breadcrumb','group','permissions','editpermissions'));
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
        $data = $request->all();
        /** validation */
        $attributes = array(
            'name'                  => 'Nome',
            'slug'                  => 'Slug',
            'description'           => 'Descrição'
        );
        $validation = Validator::make($data,[
            'name'                  => 'required|string|max:191',
            'slug'                  => 'required|string|max:191|unique:groups,slug,'.$data['id'],
            'description'           => 'nullable|string'
        ]);
        $validation->setAttributeNames($attributes);
        if($validation->fails()){
            $error = $validation->messages();
            $message = "";
            foreach($error->messages() as $key => $value){
                $message .= $value[0]."<br/>";
            }
            alert()->html('<i>Erro</i>',' <h5>Problema no preenchimento de campo(s) do formulário.</h5> <small><b>'.$message.'</b></small>','error');
            return redirect()->back()->withInput();
        }
        //dd($data);
        /** database statment */
        try{
            $group = Group::find($id);
            $group->update($data);
            if(isset($data['permissions'])){
                $group->syncPermissions($data['permissions']);
            }else{
                DB::table('group_has_permissions')->where('group_id','=',$id)->delete();
            }
        } catch (\Illuminate\Database\QueryException $e){
            alert()->html('<i>Erro</i>',' <h5>Problema ao alterar o registro.</h5> <small><b>'.$e->errorInfo[2].'</b></small>','error')
               ->autoClose(8000);
            return redirect()->back();
        } catch (PDOException $e){
            alert()->html('<i>Erro</i>','<h5><b>Falha ao acessar o banco de dados.</b><br/>Código: '.$e->errorInfo[0].'<br/>Mensagem: '.$e->errorInfo[2].'</h5>', 'error')
               ->autoClose(8000);
            return redirect()->back();
        }
        alert()->html('<i>Ok</i>','<h5><b>Registro alterado com sucesso.</b></h5>', 'success')
                   ->autoClose(8000)
                   ->toToast();
        return redirect()->route('groups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::denies('groups_delete')){
            alert()->html('<i>Erro</i>',' <h5>O usuário não tem acesso para excluir registros.</h5>','error')
               ->autoClose(5000);
            return redirect()->back();
        }
        /** database statment */
        try{
            $group = $this->groups->find($id);
            $group->delete();
        } catch (\Illuminate\Database\QueryException $e){
            alert()->html('<i>Erro</i>',' <h5>Problema ao mover o registro para a lixeira.</h5> <small><b>'.$e->errorInfo[2].'</b></small>','error')
               ->autoClose(8000);
            return redirect()->back();
        } catch (PDOException $e){
            alert()->html('<i>Erro</i>','<h5><b>Falha ao acessar o banco de dados.</b><br/>Código: '.$e->errorInfo[0].'<br/>Mensagem: '.$e->errorInfo[2].'</h5>', 'error')
               ->autoClose(8000);
            return redirect()->back();
        }
        alert()->html('<i>Ok</i>','<h5><b>Registro movido com sucesso para a lixeira.</b></h5>', 'success')
                   ->autoClose(8000)
                   ->toToast();
        return redirect()->back();
    }

    /**
     * Return Grid Data
     * @return Datatables
     */
    public function getGridData()
    {
        $data = (Auth::user()->hasGroup('admin')) ? $this->groups->select('*') : $this->groups->select('*')->where('slug','<>','admin');        

        return Datatables::of($data)
                ->addColumn('action', function($item){
                    return '<form action="/admin/groups/'.$item->id.'" method="post" id="'.$item->id.'">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" id="tk_'.$item->id.'" value="">
                            <a href="/admin/groups/'.$item->id.'/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                            <button class="btn btn-xs bg-orange btn-delete" data-remote="/admin/groups/' . $item->id . '" data-id="' . $item->id . '"><i class="glyphicon glyphicon-retweet"></i></button>
                        </form>';
                })
                ->make(true);
    }

    /**
     * Show the grid for restore the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $title = $this->title;
        $description = $this->description;
        $breadcrumb = $this->breadcrumb;

        return view('admin.groups.trash', compact('title', 'description','breadcrumb'));
    }

    /**
     * Return Grid Data Trash
     * @return Datatables
     */
    public function getGridDataTrash()
    {
        $data = $this->groups->onlyTrashed('*')->get();

        return Datatables::of($data)
                ->addColumn('action', function($item){
                    return '<form action="/admin/groups_force_delete/'.$item->id.'" method="post" id="'.$item->id.'">
                            <input type="hidden" name="_token" id="tk_'.$item->id.'" value="">
                            <a href="/admin/groups_restore/'.$item->id.'" class="btn btn-xs btn-primary"><i class="fa fa-refresh"></i></a>
                            <button class="btn btn-xs bg-red btn-delete" data-remote="/admin/groups_force_delete/' . $item->id . '" data-id="' . $item->id . '"><i class="fa fa-trash"></i></button>
                        </form>';
                })
                ->make(true);
    }

    /**
    * Restoring a delete registry with soft deleted
    */
    public function restore($id)
    {
        if(Gate::denies('groups_restore')){
            alert()->html('<i>Erro</i>',' <h5>O usuário não tem acesso para restaurar esse registro.</h5>','error')
               ->autoClose(5000);
            return redirect()->back();
        }
        /** database statment */
        try{
            $group = $this->groups->withTrashed()->where('id', $id)->restore();
        } catch (\Illuminate\Database\QueryException $e){
            alert()->html('<i>Erro</i>',' <h5>Problema ao restaurar o registro.</h5> <small><b>'.$e->errorInfo[2].'</b></small>','error')
               ->autoClose(8000);
            return redirect()->back();
        } catch (PDOException $e){
            alert()->html('<i>Erro</i>','<h5><b>Falha ao acessar o banco de dados.</b><br/>Código: '.$e->errorInfo[0].'<br/>Mensagem: '.$e->errorInfo[2].'</h5>', 'error')
               ->autoClose(8000);
            return redirect()->back();
        }
        alert()->html('<i>Ok</i>','<h5><b>Registro restaurado com sucesso.</b></h5>', 'success')
                   ->autoClose(8000)
                   ->toToast();
        return redirect()->route('groups.trash');
    }

    /**
    * Remove the registry permanently
    */
    public function forceDelete($id)
    {
        if(Gate::denies('groups_delete')){
            alert()->html('<i>Erro</i>',' <h5>O usuário não tem acesso para excluir permanentemente esse registro.</h5>','error')
               ->autoClose(5000);
            return redirect()->back();
        }
        /** database statment */
        try{
            $group = $this->groups->withTrashed()->where('id', $id)->forceDelete();
        } catch (\Illuminate\Database\QueryException $e){
            alert()->html('<i>Erro</i>',' <h5>Problema ao excluir o registro.</h5> <small><b>'.$e->errorInfo[2].'</b></small>','error')
               ->autoClose(8000);
            return redirect()->back();
        } catch (PDOException $e){
            alert()->html('<i>Erro</i>','<h5><b>Falha ao acessar o banco de dados.</b><br/>Código: '.$e->errorInfo[0].'<br/>Mensagem: '.$e->errorInfo[2].'</h5>', 'error')
               ->autoClose(8000);
            return redirect()->back();
        }
        alert()->html('<i>Ok</i>','<h5><b>Registro excluído permanentemente com sucesso.</b></h5>', 'success')
                   ->autoClose(8000)
                   ->toToast();
        return redirect()->route('groups.trash');
    }
}
