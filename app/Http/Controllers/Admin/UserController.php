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
use App\Notifications\StatusLiked;
use App\User;
use Junges\ACL\Http\Models\Group;

class UserController extends Controller
{
    private $title;
    private $description;
    private $breadcrumb;

    private $users;

    public function __construct(User $users){
        $this->title = 'Usuários';
        $this->description = 'cadastro de usuários';
        $this->breadcrumb = [
            ['page'  => 'Home', 'url' => route('home')],
            ['page'  => 'Administração', 'url' => ''],
            ['page'  => $this->title, 'url' => route('users.index')]
        ];

        $this->users = $users;
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
        $users = $this->users;

        return view('admin.users.index', compact('title', 'description','breadcrumb'));
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

        $groups = Group::orderBy('name')->get();

        return view('admin.users.create', compact('title', 'description','breadcrumb', 'groups'));
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
            'email'                 => 'E-mail',
            'password'              => 'Senha',
            'password_confirmation' => 'Confirmãção de senha'
        );
        $validation = Validator::make($data,[
            'name'                  => 'required|string|max:191',
            'email'                 => 'required|string|max:191|unique:users,email',
            'password'              => 'required|string|max:191',
            'password_confirmation' => 'required|string|max:191|same:password'
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
        // field password
        $data['password'] = bcrypt($data['password']);

        // field role
        if((isset($data['groups'])) && (in_array(1, $data['groups']))){
            $data['role'] = 'admin';
        }else{
            $data['role'] = 'user';
        }
        
        /** database statment */
        try{
            $user = User::create($data);            
            if(isset($data['groups'])){
                $user->groups()->sync($data['groups']);
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
        return redirect()->route('users.index');
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

        $user = $this->users->find($id);
        $groups = Group::orderBy('name')->get();
        $editgroups=[];
        foreach($user->groups as $key => $value){
            array_push($editgroups, $value['id']);
        }

        return view('admin.users.edit', compact('title', 'description','breadcrumb','user','groups','editgroups'));
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
            'email'                 => 'E-mail',
            'password'              => 'Senha',
            'password_confirmation' => 'Confirmãção de senha'
        );
        $validation = Validator::make($data,[
            'name'                  => 'required|string|max:191',
            'email'                 => 'required|string|max:191|unique:users,email,'.$data['id'],
            'password'              => 'nullable|string|max:191'
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
        // field password
        if((isset($data['password'])) && ($data['password'] <> null)){
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }

        // field role
        if((isset($data['groups'])) && (in_array(1, $data['groups']))){
            $data['role'] = 'admin';
        }else{
            $data['role'] = 'user';
        }

        /** database statment */
        try{
            $user = $this->users->find($id);
            $user->update($data);
            if(isset($data['groups'])){
                $user->groups()->sync($data['groups']);
            }else{
                DB::table('user_has_groups')->where('user_id','=',$id)->delete();
            }
            $user->notify(new StatusLiked($request->user()->name));
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
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::denies('users_trash')){
            alert()->html('<i>Erro</i>',' <h5>O usuário não tem acesso para mover esse registro para a lixeira.</h5>','error')
               ->autoClose(5000);
            return redirect()->back();
        }
        /** database statment */
        try{
            $user = $this->users->find($id);
            $user->delete();
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
        return redirect()->route('users.index');
    }

    /**
     * Return Grid Data
     * @return Datatables
     */
    public function getGridData()
    {
        $data = (Auth::user()->hasGroup('admin')) ? $this->users->select('*') : $this->users->select('*')->where('role', '<>', 'admin');

        return Datatables::of($data)
                ->addColumn('action', function($item){
                    return '<form action="/admin/users/'.$item->id.'" method="post" id="'.$item->id.'">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" id="tk_'.$item->id.'" value="">
                            <a href="/admin/users/'.$item->id.'/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                            <button class="btn btn-xs bg-orange btn-delete" data-remote="/admin/users/' . $item->id . '" data-id="' . $item->id . '"><i class="glyphicon glyphicon-retweet"></i></button>
                        </form>';
                })
                ->editColumn('status', function($data) {
                    return ($data->status == 'A') ? 'Ativo' : 'Inativo';
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

        return view('admin.users.trash', compact('title', 'description','breadcrumb'));
    }

    /**
     * Return Grid Data Trash
     * @return Datatables
     */
    public function getGridDataTrash()
    {
        $data = $this->users->onlyTrashed('*')->get();

        return Datatables::of($data)
                ->addColumn('action', function($item){
                    return '<form action="/admin/users_force_delete/'.$item->id.'" method="post" id="'.$item->id.'">
                            <input type="hidden" name="_token" id="tk_'.$item->id.'" value="">
                            <a href="/admin/users_restore/'.$item->id.'" class="btn btn-xs btn-primary"><i class="fa fa-refresh"></i></a>
                            <button class="btn btn-xs bg-red btn-delete" data-remote="/admin/users_force_delete/' . $item->id . '" data-id="' . $item->id . '"><i class="fa fa-trash"></i></button>
                        </form>';
                })
                ->editColumn('status', function($data) {
                    return ($data->status == 'A') ? 'Ativo' : 'Inativo';
                })
                ->make(true);
    }

    /**
    * Restoring a delete registry with soft deleted
    */
    public function restore($id)
    {
        if(Gate::denies('users_restore')){
            alert()->html('<i>Erro</i>',' <h5>O usuário não tem acesso para restaurar esse registro.</h5>','error')
               ->autoClose(5000);
            return redirect()->back();
        }
        /** database statment */
        try{
            $user = $this->users->withTrashed()->where('id', $id)->restore();
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
        return redirect()->route('users.trash');
    }

    /**
    * Remove the registry permanently
    */
    public function forceDelete($id)
    {
        if(Gate::denies('users_delete')){
            alert()->html('<i>Erro</i>',' <h5>O usuário não tem acesso para excluir permanentemente esse registro.</h5>','error')
               ->autoClose(5000);
            return redirect()->back();
        }
        /** database statment */
        try{
            $user = $this->users->withTrashed()->where('id', $id)->forceDelete();
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
        return redirect()->route('users.trash');
    }

}
