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
            {!! Form::open(['route' => 'permissions.store', 'role' => 'form', 'id' => 'formCreated']) !!}
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" name="name" id="name" value="{{old('name')}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="slug">Slug:</label>
                <input type="text" name="slug" id="slug" value="{{old('slug')}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="description">Descrição:</label>
                <textarea name="description" id="description" class="form-control">{{old('description')}}</textarea>
            </div>
        </div>
        <div class="box-footer">
            @can('permission_store')
            <button form="formCreated" class="btn btn-success">Inserir</button>
            @endcan
        </div>
        {!! Form::close() !!}
    </div>
@stop
