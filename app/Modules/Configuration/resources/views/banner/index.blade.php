<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ env("APP_TITLE_PREFIX") }} | Banner</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href={{ asset("favicon.ico") }} type="image/x-icon">
    <link rel="icon" href={{ asset("favicon.ico") }} type="image/x-icon">
    <link rel="stylesheet" href={{ asset("/plugins/fontawesome-free/css/all.min.css") }}>
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href={{ asset("/plugins/icheck-bootstrap/icheck-bootstrap.min.css") }}>
    <link rel="stylesheet" href={{ asset("/css/adminlte.min.css") }}>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href={{ asset("plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css") }}>
    <link rel="stylesheet" href={{ asset("plugins/jqvmap/jqvmap.min.css") }}>
    <link rel="stylesheet" href={{ asset("plugins/overlayScrollbars/css/OverlayScrollbars.min.css") }}>
    <link rel="stylesheet" href={{ asset("/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}>
    <link rel="stylesheet" href={{ asset("/plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('sweetalert::alert')
        @include('component.header')
        @include('component.sidebar')
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Banner</h1>
                        </div>
                        <div class="col-sm-2 offset-4">
                            <form action={{ url("configuration/banner/form") }} method="get">
                                <button type="submit" class="btn btn-block btn-outline-secondary btn"><i class="fas fa-plus"></i> Create Banner</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="dataTables_wrapper dt-bootstrap4">
                                    <div class="row">
                                        <div class="col-sm-12" style="overflow-x: auto;">
                                            <table id="datatable" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Status</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data as $item)
                                                        <tr>
                                                            <td>{{ $item['name'] }}</td>
                                                            <td>{{$item['status'] === 1 ? 'Active' : 'Inactive'}}</td>
                                                                <td>
                                                                    <button type="button" class="btn btn-block btn-default btn-sm"><a href={{ url("/configuration/banner/form/".$item['id']) }} class="text-muted"><i class="fas fa-eye"></i> View</a></button>
                                                                </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    {{-- @include('component.pagination') --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('component.footer')
    </div>
</body>
<script src={{ asset("/plugins/jquery/jquery.min.js") }}></script>
<script src={{ asset("/plugins/bootstrap/js/bootstrap.bundle.min.js") }}></script>
<script src={{ asset("/js/adminlte.min.js") }}></script>
<script src={{ asset("/plugins/datatables/jquery.dataTables.min.js") }}></script>
<script src={{ asset("/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") }}></script>
<script src={{ asset("/plugins/datatables-responsive/js/dataTables.responsive.min.js") }}></script>
<script src={{ asset("/plugins/datatables-responsive/js/responsive.bootstrap4.min.js") }}></script>
</html>
