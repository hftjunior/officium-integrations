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
    <div class="box">
        <div class="box-header">
            @can('users_restore')
            <a href="/admin/users_trash" class="btn btn-xs btn-app  pull-right"><i class="fa fa-trash-o fa-xs"></i>Lixeira</a>
            @endcan
            @can('users_store')
            <a href="/admin/users/create" class="btn btn-xs btn-app pull-right"><i class="fa fa-file-o fa-xs"></i>Novo</a>
            @endcan
        </div>
        <div class="box-body">
            <div>
                <table id="gridlist" class="stripe row-border order-column compact" style="width:100%">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Criado em</th>
                            <th>Alerado em</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop
