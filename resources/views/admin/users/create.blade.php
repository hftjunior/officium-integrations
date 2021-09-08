@extends('adminlte::page')

@section('js')
    <script src="/js/admin/users.js"></script>
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
            <a href="/admin/users" class="btn btn-xs btn-app pull-right"><i class="fa fa-arrow-circle-o-left fa-xs"></i>Retornar</a>
        </div>
        <div class="box-body">
            {!! Form::open(['route' => 'users.store', 'role' => 'form', 'id' => 'formCreated']) !!}
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" name="name" id="name" value="{{old('name')}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" value="{{old('email')}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirme a Senha:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>
            <div class="form-group">
                <label for="description">Grupos de acesso:</label>
                <select multiple id="user-groups" name="groups[]" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                    @foreach ($groups as $item)
                    <option value="{{$item->id}}"
                        @if (old('groups') != null)
                            {{(in_array($item->id, old('groups'))) ? "selected" : ""}}
                        @endif
                    >{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="box-footer">
            @can('users_store')
            <button form="formCreated" class="btn btn-success">Inserir</button>
            @endcan
        </div>
        {!! Form::close() !!}
    </div>
@stop
