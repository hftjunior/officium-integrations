@extends('adminlte::page')

@section('js')
    <script src="/js/person/people.js"></script>
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
            @can('people_store')
            <a href="/person/people/create" class="btn btn-xs btn-app pull-right"><i class="fa fa-file-o fa-xs"></i>Novo</a>
            @endcan
        </div>
        <div class="box-body">
            <div>
                <table id="gridlist" class="stripe row-border order-column compact" style="width:100%">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Foto</th>
                            <th>Nome</th>
                            <th>CPF/CNPJ</th>
                            <th>Tipo</th>
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
