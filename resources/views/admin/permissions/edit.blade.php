@extends('adminlte::page')

@section('js')
    <script src="/js/admin/permissions.js"></script>
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
            <a href="/admin/permissions" class="btn btn-xs btn-app pull-right"><i class="fa fa-arrow-circle-o-left fa-xs"></i>Retornar</a>
        </div>
        <div class="box-body">
            {!! Form::open(['route' => ['permissions.update', $permission->id], 'method' => 'put', 'role' => 'form', 'id' => 'formEdition']) !!}
            <input type="hidden" name="id" id="id" value="{{$permission->id}}">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" name="name" id="name" value="{{$permission->name}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="slug">Slug:</label>
                <input type="text" name="slug" id="slug" value="{{$permission->slug}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="description">Descrição:</label>
                <textarea name="description" id="description" class="form-control">{{$permission->description}}</textarea>
            </div>
        </div>
        <div class="box-footer">
            @can('permissions_update')
            <button form="formEdition" class="btn btn-success">Salvar</button>
            @endcan
        </div>
        {!! Form::close() !!}
    </div>
@stop
