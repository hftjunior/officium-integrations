@extends('adminlte::page')

@section('js')
    <script src="/js/person/people.js"></script>
    <script>
        $(document).ready(function(){
            $('input[data-mask=cep]').inputmask({'mask':'99999-999'});
            $('#addFieldPhone').click(function(e){
                e.preventDefault();
                var index = $(".phones").length;
                $('<div class="row phones">'+
                    '<div class="col-sm-1 text-center">'+
                        '<button type="button" class="btn btn-danger btn-xs" id="removeFieldPhone"><i class="fa fa-minus-circle"></i></button>'+
                    '</div>'+
                    '<div class="col-sm-3">'+
                            '<input type="hidden" id="idPhones['+index+']" name="idPhones[]" value="">'+
                            '<div class="form-group">'+
                                '<select name="phone_type[]" id="phone_type['+index+']" class="form-control input-sm" onchange="javascript:maskInput(this);" data-name="phone_type" data-index="'+index+'">'+
                                    '<option value=""></option>'+
                                    '<option value="C">Corporativo</option>'+
                                    '<option value="R">Residencial</option>'+
                                    '<option value="CC">Celular Corporativo</option>'+
                                    '<option value="CP">Celular Pessoal</option>'+
                                '</select>'+
                            '</div>'+
                        '</div>'+
                    '<div class="col-sm-8">'+
                        '<div class="form-group">'+
                            '<input type="text" name="phone[]" id="phone['+index+']" class="form-control input-sm" data-mask="phone'+index+'">'+
                        '</div>'+
                    '</div>'+
                '</div>').appendTo('#phones');
                index ++;
                return false;
            });
            $(document).on('click', '#removeFieldPhone', function(e){
                e.preventDefault();
                $(this).parents(".phones").remove();
                return false;
            });
            /* Add fields emails*/
            $('#addFieldEmail').click(function(e){
                e.preventDefault();
                var index = $(".emails").length;
                $('<div class="row emails">'+
                        '<input type="hidden" id="idEmail['+index+']" name="idEmail[]" value="">'+
                        '<div class="col-sm-1 text-center">'+
                            '<button type="button" class="btn btn-danger btn-xs" id="removeFieldEmail"><i class="fa fa-minus-circle"></i></button>'+
                        '</div>'+
                        '<div class="col-sm-3">'+
                                '<div class="form-group">'+
                                    '<select name="email_type[]" id="email_type['+index+']" class="form-control input-sm">'+
                                        '<option value=""></option>'+
                                        '<option value="C">Corporativo</option>'+
                                        '<option value="P">Pessoal</option>'+
                                    '</select>'+
                                '</div>'+
                            '</div>'+
                        '<div class="col-sm-8">'+
                            '<div class="form-group">'+
                                '<input type="email" name="email[]" id="email['+index+']" class="form-control input-sm">'+
                            '</div>'+
                        '</div>'+
                    '</div>').appendTo('#emails');
                index ++;
                return false;
            });
            $(document).on('click', '#removeFieldEmail', function(e){
                e.preventDefault();
                $(this).parents(".emails").remove();
                return false;
            });
            /* Add fields emails*/
            $('#addFieldAddress').click(function(e){
                e.preventDefault();
                var index = $(".addresses").length;
                $( '<div class="addresses">'+
                    '<div class="row">'+
                        '<div class="col-sm-1 pull-right">'+
                            '<button type="button" class="btn btn-danger btn-xs" id="removeFieldAddress"><i class="fa fa-minus-circle"></i>&nbsp;Remover</button>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<input type="hidden" id="idAddress['+index+']" name="idAddress[]" value="">'+
                        '<div class="col-sm-2">'+
                            '<div class="form-group">'+
                                '<label for="direct[]">Correspondência:</label><br/>'+
                                '<select name="direct[]" id="direct['+index+']" class="form-control input-sm">'+
                                    '<option value="N" selected>Não</option>'+
                                    '<option value="S">Sim</option>'+
                                '</select>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-6">'+
                            '<div class="form-group">'+
                                '<label for="address_type[]">Tipo:</label>'+
                                '<select name="address_type[]" id="address_type['+index+']" class="form-control input-sm">'+
                                    '<option value=""></option>'+
                                    '<option value="C">Corporativo</option>'+
                                    '<option value="R">Residencial</option>'+
                                '</select>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-6">'+
                            '<div class="form-group">'+
                                '<label for="cep[]">CEP:</label>'+
                                '<input type="text" name="cep[]" id="cep['+index+']" class="form-control input-sm" data-mask="cep">'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-2">'+
                                '<div class="form-group">'+
                                    '<label for="street_type_id[]">Tipo Logr.:</label>'+
                                    '<select name="street_type_id[]" id="street_type_id['+index+']" class="form-control input-sm">'+
                                        '<option value=""></option>'+
                                        '@foreach ($streettypes as $item)'+
                                        '<option value="{{$item->id}}">{{$item->type}}</option>'+
                                        '@endforeach'+
                                    '</select>'+
                                '</div>'+
                            '</div>'+
                        '<div class="col-sm-10">'+
                            '<div class="form-group">'+
                                '<label for="street[]">Logradouro:</label>'+
                                '<input type="text" name="street[]" id="street['+index+']" class="form-control input-sm">'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-2">'+
                            '<div class="form-group">'+
                                '<label for="number[]">Numero:</label>'+
                                '<input type="text" name="number[]" id="number['+index+']" class="form-control input-sm">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-2">'+
                            '<div class="form-group">'+
                                '<label for="complement[]">Complemento:</label>'+
                                '<input type="text" name="complement[]" id="complement['+index+']" class="form-control input-sm">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-8">'+
                            '<div class="form-group">'+
                                '<label for="neighborhood[]">Bairro:</label>'+
                                '<input type="text" name="neighborhood[]" id="neighborhood['+index+']" class="form-control input-sm">'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-sm-6">'+
                            '<div class="form-group">'+
                                '<label for="state_id['+index+']">Estado:</label>'+
                                '<select name="state_id[]" id="state_id['+index+']" class="form-control input-sm">'+
                                    '<option value=""></option>'+
                                    '@foreach ($states as $item)'+
                                    '<option value="{{$item->id}}">{{$item->state}}</option>'+
                                    '@endforeach'+
                                '</select>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-6">'+
                            '<div class="form-group">'+
                                '<label for="city_id['+index+']">Cidade:</label>'+
                                '<select name="city_id[]" id="city_id['+index+']" class="form-control input-sm">'+
                                    '<option value=""></option>'+
                                    '@foreach ($cities as $item)'+
                                    '<option value="{{$item->id}}">{{$item->city}}</option>'+
                                    '@endforeach'+
                                '</select>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                   '</div><hr/>' ).appendTo('#addresses');
                index ++;
                $('input[data-mask=cep]').inputmask({'mask':'99999-999'});
                $('input[data-mask=direct]').iCheck({
                    checkboxClass: 'icheckbox_line-green',
                    radioClass: 'iradio_line-green',
                    insert: '<div class="icheck_line-icon"></div> Correspondência'
                });
                return false;
            });
            $(document).on('click', '#removeFieldAddress', function(e){
                e.preventDefault();
                $(this).parents(".addresses").remove();
                return false;
            });
        });
    </script>
@stop

@section('title', 'Officium')

@section('content_header')
    <h1>{{$title}}
        <small>{{$description}}</small>
    </h1>
    @include('layout.breadcrumb')
@stop

@section('content')
    <div class="box box-success">
        <div class="box-header">
            <a href="/person/people" class="btn btn-xs btn-app pull-right"><i class="fa fa-arrow-circle-o-left fa-xs"></i>Retornar</a>
        </div>
        <div class="box-body">
            {!! Form::open(['route' => ['people.update', $data->id], 'method' => 'put', 'role' => 'form', 'id' => 'formEdition', 'enctype' => 'multipart/form-data']) !!}
            <input type="hidden" name="id" id="id" value="{{$data->id}}">
            <div class="row">
                <div class="col-sm-4 text-center">
                    <div class="box-profile">
                        @if ($data->photo)
                        <img class="profile-user-img img-responsive img-circle" src="/storage/people/{{$data->photo}}" alt="Foto">
                        @else
                        <img class="profile-user-img img-responsive img-circle" src="/img/user.png" alt="Foto">
                        @endif
                    </div>
                    <div class="form-group">
                        <i class="fa fa-camera upload-button"></i>
                        <input type="file" name="photo" id="avatar" style="display: none;" accept="image/*" />
                        <small>Tamanho máximo do arquivo 500kb</small>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="nav-tabs-custom tab-success">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab-1" data-toggle="tab">Dados</a></li>
                            <li><a href="#tab-2" data-toggle="tab">Telefones</a></a></li>
                            <li><a href="#tab-3" data-toggle="tab">E-mails</a></a></li>
                            <li><a href="#tab-4" data-toggle="tab">Endereços</a></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-1">
                                <div class="form-group">
                                    <label for="name">Nome:</label>
                                    <input type="text" name="name" id="name" value="{{$data->name}}" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="type">Tipo de Pessoa:</label><br/>
                                            <label><input type="radio" name="type" id="type0" value="F" {{($data->type == "F")? "checked" : ""}}>&nbsp;Física</label>
                                            <label><input type="radio" name="type" id="type1" value="J" {{($data->type == "J")? "checked" : ""}}>&nbsp;Jurídica</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label for="cpfcnpj">CPF/CNPJ:</label>
                                            <input type="text" name="cpfcnpj" id="cpfcnpj" value="{{$data->cpfcnpj}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="person_category_id">Categorias:</label>
                                    <select multiple id="person_categories" name="person_category_id[]" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                        @foreach ($categories as $item)
                                        <option value="{{$item->id}}"
                                            @if ($personcategories != null)
                                                {{(in_array($item->id, $personcategories)) ? "selected" : ""}}
                                            @endif
                                        >{{$item->category}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-2">
                                <div id="phones">
                                    <div class="row">
                                        <div class="col-sm-1 text-center"><label>Ações</label></div>
                                        <div class="col-sm-3 text-center"><label>Tipo</label></div>
                                        <div class="col-sm-8 text-center"><label>Telefone</label></div>
                                    </div>
                                    @foreach ($data->personPhones as $key => $item)
                                    <div class="row phones">
                                        <input type="hidden" id="idPhones[{{$key}}]" name="idPhones[]" value="{{$item->id}}">
                                        <div class="col-sm-1 text-center">
                                            <button type="button" class="btn btn-danger btn-xs" id="removeFieldPhone"><i class="fa fa-minus-circle"></i></button>
                                        </div>
                                        <div class="col-sm-3">
                                                <div class="form-group">
                                                    <select name="phone_type[]" id="phone_type[{{$key}}]" class="form-control input-sm" onchange="javascript:maskInput(this);" data-name="phone_type" data-index="0">
                                                        <option value=""></option>
                                                        <option value="C" {{($item->type == "C")? "selected" : ""}}>Corporativo</option>
                                                        <option value="R" {{($item->type == "R")? "selected" : ""}}>Residencial</option>
                                                        <option value="CC" {{($item->type == "CC")? "selected" : ""}}>Celular Corporativo</option>
                                                        <option value="CP" {{($item->type == "CP")? "selected" : ""}}>Celular Pessoal</option>
                                                    </select>
                                                </div>
                                            </div>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <input type="text" name="phone[]" id="phone[{{$key}}]" value="{{$item->phone}}" class="form-control input-sm" data-mask="phone0">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-success btn-xs" id="addFieldPhone"><i class="fa fa-plus-circle"></i>&nbsp;Adicionar</button>
                            </div>
                            <div class="tab-pane" id="tab-3">
                                <div id="emails">
                                    <div class="row">
                                        <div class="col-sm-1 text-center"><label>Ações</label></div>
                                        <div class="col-sm-3 text-center"><label>Tipo</label></div>
                                        <div class="col-sm-8 text-center"><label>E-mail</label></div>
                                    </div>
                                    @foreach ($data->personEmails as $key => $item)
                                    <div class="row emails">
                                        <input type="hidden" id="idEmail[{{$key}}]" name="idEmail[]" value="{{$item->id}}">
                                        <div class="col-sm-1 text-center">
                                            <button type="button" class="btn btn-danger btn-xs" id="removeFieldEmail"><i class="fa fa-minus-circle"></i></button>
                                        </div>
                                        <div class="col-sm-3">
                                                <div class="form-group">
                                                    <select name="email_type[]" id="email_type[{{$key}}]" class="form-control input-sm">
                                                        <option value=""></option>
                                                        <option value="C" {{($item->type == "C")? "selected" : ""}}>Corporativo</option>
                                                        <option value="P" {{($item->type == "P")? "selected" : ""}}>Pessoal</option>
                                                    </select>
                                                </div>
                                            </div>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <input type="email" name="email[]" id="email[{{$key}}]" value="{{$item->email}}" class="form-control input-sm">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-success btn-xs" id="addFieldEmail"><i class="fa fa-plus-circle"></i>&nbsp;Adicionar</button>
                            </div>
                            <div class="tab-pane" id="tab-4">
                                <div id="addresses">
                                    @foreach ($data->personAddresses as $key => $item)
                                    <div class="addresses">
                                        <div class="row">
                                            <div class="col-sm-1 pull-right">
                                                <button type="button" class="btn btn-danger btn-xs" id="removeFieldAddress"><i class="fa fa-minus-circle"></i>&nbsp;Remover</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <input type="hidden" id="idAddress[{{$key}}]" name="idAddress[]" value="{{$item->id}}">
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="direct[]">Correspondência:</label><br/>
                                                    <select name="direct[]" id="direct[{{$key}}]" class="form-control input-sm">
                                                        <option value="N" {{($item->direct == "N")? "selected" : ""}}>Não</option>
                                                        <option value="S" {{($item->direct == "S")? "selected" : ""}}>Sim</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="address_type[]">Tipo:</label>
                                                    <select name="address_type[]" id="address_type[{{$key}}]" class="form-control input-sm">
                                                        <option value=""></option>
                                                        <option value="C" {{($item->type == "C")? "selected" : ""}}>Corporativo</option>
                                                        <option value="R" {{($item->type == "R")? "selected" : ""}}>Residencial</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="cep[]">CEP:</label>
                                                    <input type="text" name="cep[]" id="cep[{{$key}}]" value="{{$item->cep}}" class="form-control input-sm" data-mask="cep">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label for="street_type_id[]">Tipo Logr.:</label>
                                                        <select name="street_type_id[]" id="street_type_id[{{$key}}]" class="form-control input-sm">
                                                            <option value=""></option>
                                                            @foreach ($streettypes as $street)
                                                            <option value="{{$street->id}}" {{($item->street_type_id == $street->id)? "selected" : ""}}>{{$street->type}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            <div class="col-sm-10">
                                                <div class="form-group">
                                                    <label for="street[]">Logradouro:</label>
                                                    <input type="text" name="street[]" id="street[{{$key}}]" value="{{$item->street}}" class="form-control input-sm">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="number[]">Numero:</label>
                                                    <input type="text" name="number[]" id="number[{{$key}}]" value="{{$item->number}}" class="form-control input-sm">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="complement[]">Complemento:</label>
                                                    <input type="text" name="complement[]" id="complement[{{$key}}]" value="{{$item->complement}}" class="form-control input-sm">
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label for="neighborhood[]">Bairro:</label>
                                                    <input type="text" name="neighborhood[]" id="neighborhood[{{$key}}]" value="{{$item->neighborhood}}" class="form-control input-sm">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="state_id[0]">Estado:</label>
                                                    <select name="state_id[]" id="state_id[{{$key}}]" class="form-control input-sm">
                                                        <option value=""></option>
                                                        @foreach ($states as $state)
                                                        <option value="{{$state->id}}" {{($item->state_id == $state->id)? "selected" : ""}}>{{$state->state}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="city_id[0]">Cidade:</label>
                                                    <select name="city_id[]" id="city_id[{{$key}}]" class="form-control input-sm">
                                                        <option value=""></option>
                                                        @foreach ($cities as $city)
                                                        <option value="{{$city->id}}" {{($item->city_id == $city->id)? "selected" : ""}}>{{$city->city}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-success btn-xs" id="addFieldAddress"><i class="fa fa-plus-circle"></i>&nbsp;Adicionar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="notes">Observações:</label>
                        <textarea name="notes" id="notes" class="form-control">{{$data->notes}}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            @can('users_update')
            <button form="formEdition" class="btn btn-success">Salvar</button>
            @endcan
        </div>
        {!! Form::close() !!}
    </div>
@stop
