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
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="first_name">First Name</label>
                                        <input type="text" class="form-control" id="first_name" value="John" disabled>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="email">Email Address</label>
                                        <input type="email" class="form-control" id="email" value="testing@gmail.com" disabled>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" value="Doe" disabled>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="phone_code">Phone Number</label>
                                        <input type="text" class="form-control" id="phone_code" value="+62856325197" disabled>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="nationality">Nationality</label>
                                        <input type="text" class="form-control" id="nationality" value="Indonesia" disabled>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="dob">Date of Birth</label>
                                        <input type="text" class="form-control" id="dob" value="August 17, 1985" disabled>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="id_card">ID Card</label>
                                        <input type="text" class="form-control" id="id_card" value="3312456851484" disabled>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="npwp">NPWP</label>
                                        <input type="text" class="form-control" id="npwp" value="3312456851484" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr style="border: 1px solid grey;">
                    <div class="row">
                        <form action={{ url("/member/personal/123") }} method="post" class="col-12">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label>Status</label>
                                        <select name="status" id="status" class="custom-select">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-3 offset-5">
                                        <button type="submit" class="btn btn-block btn-primary btn-sm">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
