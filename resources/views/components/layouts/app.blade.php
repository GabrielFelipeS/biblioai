<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projeto Tópicos Especias I</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('AdminLTE/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('AdminLTE/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body class="hold-transition layout-top-nav ">
    <div class="wrapper">
        <!-- Navbar -->
        <x-layout.top-navbar />
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper bg-gray text-bold">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">BiblioAI</h1>
                        </div><!-- /.col -->
<!--                        <div class="col-sm-6">-->
<!--                             <ol class="breadcrumb float-sm-right">-->
<!--                                 <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>-->
<!--                                 <li class="breadcrumb-item"><a href="{{ route('home') }}">Teste</a></li>-->
<!--                                 <li class="breadcrumb-item"><a href="{{ route('home') }}">Navbar</a></li>-->
<!--                             </ol>-->
<!--                        </div>--> <!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">{{ $slot }}</div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <x-layout.footer />
    </div>
    <!-- ./wrapper -->

    <x-layout.scripts />
</body>
</html>
