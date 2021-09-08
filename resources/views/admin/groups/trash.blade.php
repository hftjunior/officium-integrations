@extends('adminlte::page')

@section('js')
    <script src="/js/admin/groups_trash.js"></script>
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
            <a href="/admin/groups" class="btn btn-xs btn-app pull-right"><i class="fa fa-arrow-circle-o-left fa-xs"></i>Retornar</a>
        </div>
        <div class="box-body">
            <div>
                <table id="trashgridlist" class="stripe row-border order-column compact" style="width:100%">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Nome</th>
                            <th>Slug</th>
                            <th>Removido em</th>
                            <th>Alerado em</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop
