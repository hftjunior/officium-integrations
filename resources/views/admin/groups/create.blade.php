@extends('adminlte::page')

@section('js')
    <script src="/js/admin/groups.js"></script>
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
            <a href="/admin/groups" class="btn btn-xs btn-app pull-right"><i class="fa fa-arrow-circle-o-left fa-xs"></i>Retornar</a>
        </div>
        <div class="box-body">
            {!! Form::open(['route' => 'groups.store', 'role' => 'form', 'id' => 'formCreated']) !!}
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
            <div class="form-group">
                <label for="description">Permissões</label>
                <select multiple id="group-permissions" name="permissions[]" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                    @foreach ($permissions as $item)
                    <option value="{{$item->id}}"
                        @if (old('permissions') != null)
                            {{(in_array($item->id, old('permissions'))) ? "selected" : ""}}
                        @endif
                    >{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="box-footer">
            @can('groups_store')
            <button form="formCreated" class="btn btn-success">Inserir</button>
            @endcan
        </div>
        {!! Form::close() !!}
    </div>
@stop
