<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title_prefix', config('adminlte.title_prefix', ''))
@yield('title', config('adminlte.title', 'Ativa'))
@yield('title_postfix', config('adminlte.title_postfix', ''))</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/Ionicons/css/ionicons.min.css') }}">

    @if(config('adminlte.plugins.select2'))
        <!-- Select2 -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css">
    @endif

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}">

    @if(config('adminlte.plugins.datatables'))
        <!-- DataTables with bootstrap 3 style -->
        <link rel="stylesheet" href="{{ asset('vendor/datatables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/datatables/autofill/css/autoFill.bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/datatables/buttons/css/buttons.bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/datatables/colreorder/css/colReorder.bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/datatables/fixedcolumns/css/fixedColumns.bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/datatables/fixedheader/css/fixedHeader.bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/datatables/keytable/css/keyTable.bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/datatables/responsive/css/responsive.bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/datatables/rowgroup/css/rowGroup.bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/datatables/rowreorder/css/rowReorder.bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/datatables/scroller/css/scroller.bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/datatables/select/css/select.bootstrap.min.css') }}">
    @endif
    @if(config('adminlte.plugins.inputmask'))
        <!-- Imputmask -->
        <link rel="stylesheet" href="{{ asset('vendor/inputmask/css/inputmask.css') }}">
    @endif

    @yield('adminlte_css')

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
@if (Auth::check())
<body class="hold-transition @yield('body_class')" data-user-id="{{Auth::user()->id}}">
@else
<body class="hold-transition @yield('body_class')">
@endif

@yield('body')
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
@include('sweetalert::alert')

@if(config('adminlte.plugins.select2'))
    <!-- Select2 -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
@endif

@if(config('adminlte.plugins.datatables'))
    <!-- DataTables with bootstrap 3 renderer -->
    <script src="{{ asset('vendor/datatables/datatables.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/autofill/js/dataTables.autoFill.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/buttons/js/buttons.colVis.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{ asset('vendor/datatables/jszip/jszip.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/colreorder/js/dataTables.colReorder.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/fixedcolumns/js/dataTables.fixedColumns.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/rowgroup/js/dataTables.rowGroup.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/rowreorder/js/dataTables.rowReorder.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/scroller/js/dataTables.scroller.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/select/js/dataTables.select.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.19/dataRender/datetime.js"></script>
@endif

@if(config('adminlte.plugins.chartjs'))
    <!-- ChartJS -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
@endif

@if(config('adminlte.plugins.inputmask'))
    <!-- Inputmask -->
    <script src="{{ asset('vendor/inputmask/dist/jquery.inputmask.bundle.js')}}"></script>    
@endif

@yield('adminlte_js')
</body>
</html>
