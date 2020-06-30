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
                                <form action={{ url("configuration/banner/store") }} method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="text" name="id" value="{{ $data ?? '' ? $data['id'] : null }}" style="display: none">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="name">Banner Name</label>
                                            <input type="text" class="form-control" name="name" id="name" value="{{ $data ?? '' ? $data['name'] : old('name') }}" required>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="exampleInputFile">File input</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input name="image" onchange="viewImage(this)" @if(isset($data)) value="{{$data['url']}}" @endif type="file" class="custom-file-input" id="exampleInputFile" accept="image/jpeg">
                                                    <label class="custom-file-label" for="exampleInputFile">{{ $data ?? '' ? $data['url'] : old('url') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12" style="height: 500px">
                                            <img id="view-image" @if(isset($data)) src="{{env('CLOUDINARY_URL_ACCESS').$data['url']}}" @endif alt="image" style="max-height:100%;max-width:100%;">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control">
                                                <option value="1" @if(isset($data) && $data['status'] == 1) selected @endif>Active</option>
                                                <option value="0" @if(isset($data) && $data['status'] == 0) selected @endif>Inactive</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-6"></div>
                                        <div class="col-2">
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
<script src={{ asset("/plugins/bs-custom-file-input/bs-custom-file-input.min.js") }}></script>
<script src={{ asset("/js/adminlte.min.js") }}></script>
<script>
    $(document).ready(function () {
        bsCustomFileInput.init();
    }); 
    function viewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#view-image').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>
</html>
