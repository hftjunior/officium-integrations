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
use App\Models\Person;
use App\Models\PersonCategory;
use App\Models\StreetType;
use App\Models\State;
use App\Models\City;

class PersonController extends Controller
{

    private $title;
    private $description;
    private $breadcrumb;

    private $scheme;

    public function __construct(Person $scheme)
    {
        $this->title = 'Pessoas';
        $this->description = 'cadastro de pessoas';
        $this->breadcrumb = [
            ['page'  => 'Home', 'url' => route('home')],
            ['page'  => 'Pessoas', 'url' => ''],
            ['page'  => $this->title, 'url' => route('people.index')]
        ];

        $this->scheme = $scheme;
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

        return view('person.people.index', compact('title', 'description','breadcrumb'));
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

        $categories = PersonCategory::orderBy('category')->get();
        $streettypes = StreetType::orderBy('type')->get();
        $states = State::orderBy('state')->get();
        $cities = City::orderBy('city')->get();

        return view('person.people.create', compact('title', 'description','breadcrumb','categories','streettypes','states','cities'));
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
            'name'      => 'Nome',
            'cpfcnjp'   => 'CPF/CNPJ',
            'type'      => 'Tipo',
            'photo'     => 'Foto',
            'notes'     => 'Observações'

        );
        $validation = Validator::make($data,[
            'name'      => 'required|string|max:191',
            'cpfcnpj'   => 'required|string|max:20|unique:people',
            'type'      => 'required|string|max:1',
            'photo'     => 'nullable|image',

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
            $table = $this->scheme->create($data);
            if($data['person_category_id']){
                $table->personCategories()->sync($data['person_category_id']);
            }
            if(isset($data['phone_type'])){
                for ($i=0; $i < count($data['phone_type']) ; $i++) {
                    $table->personPhones()->create([
                        'phone' => $data['phone'][$i],
                        'type'  => $data['phone_type'][$i]
                    ]);
                }
            }
            if(isset($data['email_type'])){
                for ($i=0; $i < count($data['email_type']) ; $i++) {
                    $table->personEmails()->create([
                        'email' => $data['email'][$i],
                        'type'  => $data['email_type'][$i]
                    ]);
                }
            }
            if(isset($data['address_type'])){
                for ($i=0; $i < count($data['address_type']) ; $i++) {
                    $table->personAddresses()->create([
                        'street_type_id'=> $data['street_type_id'][$i],
                        'street'        => $data['street'][$i],
                        'number'        => $data['number'][$i],
                        'complement'    => $data['complement'][$i],
                        'neighborhood'  => $data['neighborhood'][$i],
                        'cep'           => $data['cep'][$i],
                        'state_id'      => $data['state_id'][$i],
                        'city_id'       => $data['city_id'][$i],
                        'type'          => $data['address_type'][$i],
                        'direct'        => $data['direct'][$i]
                    ]);
                }
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
        /** Field photo */
        if(($request->hasFile('photo')) && ($request->file('photo')->isValid())){
            $extension = $request->photo->extension();
            $namefile = "photo_".$table->id.".".$extension;
            $upload = $request->photo->storeAs('people', $namefile);
            if(!$upload){
                alert()->html('<i>Erro</i>','<h5><b>Falha ao fazer upload da Foto.</b><br/>Entre em contato com o suporte.</h5>', 'error')
               ->autoClose(8000);
            }else{
                $register = $this->scheme->find($table->id);
                $register->photo = $namefile;
                $register->save();
            }
        }
        alert()->html('<i>Ok</i>','<h5><b>Registro criado com sucesso.</b></h5>', 'success')
                   ->autoClose(8000)
                   ->toToast();
        return redirect()->route('people.index');
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

        $data = $this->scheme->find($id);
        $categories = PersonCategory::orderBy('category')->get();
        $streettypes = StreetType::orderBy('type')->get();
        $states = State::orderBy('state')->get();
        $cities = City::orderBy('city')->get();
        $personcategories = [];
        foreach ($data->personCategories()->get() as $key => $value) {
            array_push($personcategories, $value['id']);
        }

        return view('person.people.edit', compact('title', 'description','breadcrumb','data','categories','personcategories','streettypes', 'states','cities'));
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
            'name'      => 'Nome',
            'cpfcnjp'   => 'CPF/CNPJ',
            'type'      => 'Tipo',
            'photo'     => 'Foto',
            'notes'     => 'Observações'

        );
        $validation = Validator::make($data,[
            'name'      => 'required|string|max:191',
            'cpfcnpj'   => 'required|string|max:20|unique:people,cpfcnpj,'.$id,
            'type'      => 'required|string|max:1',
            'photo'     => 'nullable|image',

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
            $table = $this->scheme->find($id);
            $table->update($data);
            /** Person Categories */
            if(isset($data['person_category_id'])){
                $table->personCategories()->sync($data['person_category_id']);
            }else{
                DB::table('person_has_categories')->where('person_id','=',$id)->delete();
            }
            /** Person Phones*/
            $person_phones = array();
            if(isset($data['idPhones'])){
                for ($i=0; $i < count($data['idPhones']) ; $i++) {
                    $person_phones[$i] = [
                        'id'    => $data['idPhones'][$i],
                        'phone' => $data['phone'][$i],
                        'type'  => $data['phone_type'][$i]
                    ];
                }
            }
            foreach ($table->personPhones as $key => $value) {
                $content = false;
                foreach($person_phones as $i => $phone){
                    if(intval($value['id'] == intval($phone['id']))){
                        $content = true;
                        break;
                    }else{
                        $content = false;
                    }
                }
                if($content == false){
                    $table->personPhones()->where('id', '=', $value['id'])->delete();
                }
            }
            foreach ($person_phones as $key => $value) {
                if($value['id'] != null){
                    $table->personPhones()->find($value['id'])->update([
                        'phone' => $value['phone'],
                        'type'  => $value['type']
                    ]);
                }else{
                    $table->personPhones()->create([
                        'phone' => $value['phone'],
                        'type'  => $value['type']
                    ]);
                }
            }
            /** Person Emails*/
            $person_emails = array();
            if(isset($data['idEmail'])){
                for ($i=0; $i < count($data['idEmail']) ; $i++) {
                    $person_emails[$i] = [
                        'id'    => $data['idEmail'][$i],
                        'email' => $data['email'][$i],
                        'type'  => $data['email_type'][$i]
                    ];
                }
            }

            foreach ($table->personEmails as $key => $value) {
                $content = false;
                foreach($person_emails as $i => $email){
                    if(intval($value['id'] == intval($email['id']))){
                        $content = true;
                        break;
                    }else{
                        $content = false;
                    }
                }
                if($content == false){
                    $table->personEmails()->where('id', '=', $value['id'])->delete();
                }
            }

            foreach ($person_emails as $key => $value) {
                if($value['id'] != null){
                    $table->personEmails()->find($value['id'])->update([
                        'email' => $value['email'],
                        'type'  => $value['type']
                    ]);
                }else{
                    $table->personEmails()->create([
                        'email' => $value['email'],
                        'type'  => $value['type']
                    ]);
                }
            }

            /** Person Address*/
            $person_addresses = array();

            if(isset($data['idAddress'])){
                for ($i=0; $i < count($data['idAddress']) ; $i++) {
                    $person_addresses[$i] = [
                        'id'                => $data['idAddress'][$i],
                        'street_type_id'    => $data['street_type_id'][$i],
                        'street'            => $data['street'][$i],
                        'number'            => $data['number'][$i],
                        'complement'        => $data['complement'][$i],
                        'neighborhood'      => $data['neighborhood'][$i],
                        'cep'               => $data['cep'][$i],
                        'state_id'          => $data['state_id'][$i],
                        'city_id'           => $data['city_id'][$i],
                        'type'              => $data['address_type'][$i],
                        'direct'            => $data['direct'][$i]
                    ];
                }
            }

            foreach ($table->personAddresses as $key => $value) {
                $content = false;
                foreach($person_addresses as $i => $address){
                    if(intval($value['id'] == intval($address['id']))){
                        $content = true;
                        break;
                    }else{
                        $content = false;
                    }
                }
                if($content == false){
                    $table->personAddresses()->where('id', '=', $value['id'])->delete();
                }
            }

            foreach ($person_addresses as $key => $value) {
                if($value['id'] != null){
                    $table->personAddresses()->find($value['id'])->update([
                        'street_type_id'    => $value['street_type_id'],
                        'street'            => $value['street'],
                        'number'            => $value['number'],
                        'complement'        => $value['complement'],
                        'neighborhood'      => $value['neighborhood'],
                        'cep'               => $value['cep'],
                        'state_id'          => $value['state_id'],
                        'city_id'           => $value['city_id'],
                        'type'              => $value['type'],
                        'direct'            => $value['direct']
                    ]);
                }else{
                    $table->personAddresses()->create([
                        'street_type_id'    => $value['street_type_id'],
                        'street'            => $value['street'],
                        'number'            => $value['number'],
                        'complement'        => $value['complement'],
                        'neighborhood'      => $value['neighborhood'],
                        'cep'               => $value['cep'],
                        'state_id'          => $value['state_id'],
                        'city_id'           => $value['city_id'],
                        'type'              => $value['type'],
                        'direct'            => $value['direct']
                    ]);
                }
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
         /** Field photo */
         if(($request->hasFile('photo')) && ($request->file('photo')->isValid())){
            $extension = $request->photo->extension();
            $namefile = "photo_".$id.".".$extension;
            $upload = $request->photo->storeAs('people', $namefile);
            if(!$upload){
                alert()->html('<i>Erro</i>','<h5><b>Falha ao fazer upload da Foto.</b><br/>Entre em contato com o suporte.</h5>', 'error')
               ->autoClose(8000);
            }else{
                $register = $this->scheme->find($id);
                $register->photo = $namefile;
                $register->save();
            }
        }
        alert()->html('<i>Ok</i>','<h5><b>Registro alterado com sucesso.</b></h5>', 'success')
                   ->autoClose(8000)
                   ->toToast();
        return redirect()->route('people.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::denies('people_delete')){
            alert()->html('<i>Erro</i>',' <h5>O usuário não tem acesso para excluir esse registro.</h5>','error')
               ->autoClose(5000);
            return redirect()->back();
        }
        /** database statment */
        try{
            $table = $this->scheme->find($id);
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
        return redirect()->route('people.index');
    }

    /**
     * Return Grid Data
     * @return Datatables
     */
    public function getGridData()
    {
        $data = $this->scheme->select('*');

        return Datatables::of($data)
                ->addColumn('action', function($item){
                    return '<form action="/person/people/'.$item->id.'" method="post" id="'.$item->id.'">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" id="tk_'.$item->id.'" value="">
                            <a href="/person/people/'.$item->id.'/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                            <button class="btn btn-xs bg-red btn-delete" data-remote="/person/people/' . $item->id . '" data-id="' . $item->id . '"><i class="fa fa-trash"></i></button>
                        </form>';
                })->editColumn('photo', function($data) {
                    return ($data->photo != '') ? '/storage/people/'.$data->photo : '/img/user.png';
                })
                ->make(true);
    }
}