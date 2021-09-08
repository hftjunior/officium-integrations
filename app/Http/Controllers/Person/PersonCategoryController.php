<?php

namespace App\Http\Controllers\Person;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Validator;
use Alert;
use DB;
use Gate;
use Auth;

use App\User;
use App\Models\PersonCategory;

class PersonCategoryController extends Controller
{
    private $title;
    private $description;
    private $breadcrumb;

    private $categories;

    public function __construct(PersonCategory $categories){
        $this->title = 'Categorias';
        $this->description = 'cadastro de categorias de pessoas';
        $this->breadcrumb = [
            ['page'  => 'Home', 'url' => route('home')],
            ['page'  => 'Pessoas', 'url' => ''],
            ['page'  => $this->title, 'url' => route('person_categories.index')]
        ];

        $this->categories = $categories;
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

        return view('person.categories.index', compact('title', 'description','breadcrumb'));   
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

        return view('person.categories.create', compact('title', 'description','breadcrumb'));
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
            'category' => 'Categoria'
        );
        $validation = Validator::make($data,[
            'category'  => 'required|string|max:191'
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
            $category = $this->categories->create($data);            
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
        return redirect()->route('person_categories.index');
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

        $data = $this->categories->find($id);
        
        return view('person.categories.edit', compact('title', 'description','breadcrumb','data'));
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
            'category'  => 'Categoria'
        );
        $validation = Validator::make($data,[
            'category'  => 'required|string|max:191'
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
            $table = $this->categories->find($id);
            $table->update($data);            
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
        return redirect()->route('person_categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::denies('person_categories_delete')){
            alert()->html('<i>Erro</i>',' <h5>O usuário não tem acesso para mover esse registro para a lixeira.</h5>','error')
               ->autoClose(5000);
            return redirect()->back();
        }
        /** database statment */
        try{
            $table = $this->categories->find($id);
            $table->delete();
        } catch (\Illuminate\Database\QueryException $e){
            alert()->html('<i>Erro</i>',' <h5>Problema ao excluir o registro.</h5> <small><b>'.$e->errorInfo[2].'</b></small>','error')
               ->autoClose(8000);
            return redirect()->back();
        } catch (PDOException $e){
            alert()->html('<i>Erro</i>','<h5><b>Falha ao acessar o banco de dados.</b><br/>Código: '.$e->errorInfo[0].'<br/>Mensagem: '.$e->errorInfo[2].'</h5>', 'error')
               ->autoClose(8000);
            return redirect()->back();
        }
        alert()->html('<i>Ok</i>','<h5><b>Registro excluído com sucesso.</b></h5>', 'success')
                   ->autoClose(8000)
                   ->toToast();
        return redirect()->route('person_categories.index');
    }

    /**
     * Return Grid Data
     * @return Datatables
     */
    public function getGridData()
    {
        $data = $this->categories->select('*');

        return Datatables::of($data)
                ->addColumn('action', function($item){
                    return '<form action="/person/person_categories/'.$item->id.'" method="post" id="'.$item->id.'">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" id="tk_'.$item->id.'" value="">
                            <a href="/person/person_categories/'.$item->id.'/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                            <button class="btn btn-xs bg-red btn-delete" data-remote="/person/person_categories/' . $item->id . '" data-id="' . $item->id . '"><i class="fa fa-trash"></i></button>
                        </form>';
                })              
                ->make(true);
    }
}
