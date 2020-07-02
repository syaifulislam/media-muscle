<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ env("APP_TITLE_PREFIX") }} | Member Personal</title>

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
        @include('component.header')
        @include('component.sidebar')
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Member Personal</h1>
                        </div>
                        <div class="col-sm-6">
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
                                                        <th>Fullname</th>
                                                        <th>Email</th>
                                                        <th>Phone Number</th>
                                                        <th>Nationality</th>
                                                        <th>DOB</th>
                                                        <th>ID Card Number</th>
                                                        <th>Status</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (isset($data))
                                                        @foreach ($data as $item)
                                                            <tr>
                                                                <td>{{$item->name}}</td>
                                                                <td>{{$item->email}}</td>
                                                                <td>{{$item->phone_code}}{{$item->phone_number}}</td>
                                                                <td>{{$item->nationality}}</td>
                                                                <td>{{$item->date_of_birth}}</td>
                                                                <td>{{$item->ktp}}</td>
                                                                <td>{{$item->status === 1 ? 'Active' : 'Inactive'}}</td>
                                                                <td>
                                                                    <button type="button" class="btn btn-block btn-default btn-sm"><a href={{ url("member/personal/".$item->id) }} class="text-muted"><i class="fas fa-eye"></i> View</a></button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    {{ $data->links('component.pagination') }}
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
