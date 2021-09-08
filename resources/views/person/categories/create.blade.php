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
            {!! Form::open(['route' => 'person_categories.store', 'role' => 'form', 'id' => 'formCreated']) !!}
            <div class="form-group">
                <label for="category">Categoria:</label>
                <input type="text" name="category" id="category" value="{{old('category')}}" class="form-control">
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
