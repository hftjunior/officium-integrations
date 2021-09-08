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
            {!! Form::open(['route' => ['groups.update', $group->id], 'method' => 'put', 'role' => 'form', 'id' => 'formEdition']) !!}
            <input type="hidden" name="id" id="id" value="{{$group->id}}">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" name="name" id="name" value="{{$group->name}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="slug">Slug:</label>
                <input type="text" name="slug" id="slug" value="{{$group->slug}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="description">Descrição:</label>
                <textarea name="description" id="description" class="form-control">{{$group->description}}</textarea>
            </div>
            <div class="form-group">
                <label for="description">Permissões</label>
                <select multiple id="group-permissions" name="permissions[]" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                    @foreach ($permissions as $item)
                    <option value="{{$item->slug}}"
                        @if ($editpermissions != null)
                            {{(in_array($item->slug, $editpermissions)) ? "selected" : ""}}
                        @endif
                    >{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="box-footer">
            @can('groups_update')
            <button form="formEdition" class="btn btn-success">Salvar</button>
            @endcan
        </div>
        {!! Form::close() !!}
    </div>
@stop
