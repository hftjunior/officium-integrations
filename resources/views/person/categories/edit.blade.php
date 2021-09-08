@extends('adminlte::page')

@section('js')
    <script src="/js/person/categories.js"></script>
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
            <a href="/person/person_categories" class="btn btn-xs btn-app pull-right"><i class="fa fa-arrow-circle-o-left fa-xs"></i>Retornar</a>
        </div>
        <div class="box-body">
            {!! Form::open(['route' => ['person_categories.update', $data->id], 'method' => 'put', 'role' => 'form', 'id' => 'formEdition']) !!}
            <input type="hidden" name="id" id="id" value="{{$data->id}}">
            <div class="form-group">
                <label for="category">Categoria:</label>
                <input type="text" name="category" id="category" value="{{$data->category}}" class="form-control">
            </div>            
        </div>
        <div class="box-footer">
            @can('person_categories_update')
            <button form="formEdition" class="btn btn-success">Salvar</button>
            @endcan
        </div>
        {!! Form::close() !!}
    </div>
@stop
