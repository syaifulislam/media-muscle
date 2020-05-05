<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ env("APP_TITLE_PREFIX") }} | User</title>

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
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('component.header')
        @include('component.sidebar')
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card-body">
                                <form action={{ url("user/store") }} method="post">
                                    @csrf
                                    <input type="text" name="id" value="{{ $data ?? '' ? $data['id'] : null }}" style="display: none">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="email">Email Address</label>
                                            <input type="email" class="form-control" name="email" id="email" value="{{ $data ?? '' ? $data['email'] : old('email') }}" {{ $data ?? '' ? 'disabled' : 'required' }}>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="first_name">First Name</label>
                                            <input type="text" class="form-control" name="first_name" id="first_name" value="{{ $data ?? '' ? $data['first_name'] : old('first_name') }}" required>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" name="password" id="password" {{ $data ?? '' ? 'disabled' : 'required' }}>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $data ?? '' ? $data['last_name'] : old('last_name') }}" required>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="confirmPassword">Confirmation Password</label>
                                            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" {{ $data ?? '' ? 'disabled' : 'required' }}>
                                        </div>
                                        <div class="col-2 offset-4">
                                            <button type="submit" class="btn btn-block btn-outline-secondary middle-button">Submit</button>
                                        </div>
                                    </div>
                                </form>
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
</html>
