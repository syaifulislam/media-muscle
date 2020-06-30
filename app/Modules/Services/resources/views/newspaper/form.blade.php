<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ env("APP_TITLE_PREFIX") }} | Newspaper</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href={{ asset("favicon.ico") }} type="image/x-icon">
    <link rel="icon" href={{ asset("favicon.ico") }} type="image/x-icon">
    <link rel="stylesheet" href={{ asset("/plugins/fontawesome-free/css/all.min.css") }}>
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href={{ asset("/plugins/icheck-bootstrap/icheck-bootstrap.min.css") }}>
    <link rel="stylesheet" href={{ asset("/plugins/daterangepicker/daterangepicker.css") }}>
    <link rel="stylesheet" href={{ asset("/css/adminlte.min.css") }}>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href={{ asset("plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css") }}>
    <link rel="stylesheet" href={{ asset("plugins/jqvmap/jqvmap.min.css") }}>
    <link rel="stylesheet" href={{ asset("plugins/overlayScrollbars/css/OverlayScrollbars.min.css") }}>
    <link rel="stylesheet" href={{ asset("plugins/select2/css/select2.min.css") }}>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <?php
        $jsInit = 0;
        if(session('data')){
            $data = session('data');
            $jsInit = 1;
        }
        if (isset($data)){
            $jsInit = 1;
        }
    ?>
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
                                    <div class="card card-primary card-tabs" style="width: 100%">
                                        <div class="card-header p-0 pt-1" style="background-color: #4b545c">
                                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Newspaper</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false" onclick="findNewspaper({{ $data ?? '' ? $data['id'] : 0 }})">Detail</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                                <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                                    <form action={{ url("/services/newspaper/post") }} method="post">
                                                        @csrf
                                                        <input type="text" name="id" value="{{ $data ?? '' ? $data['id'] : null }}" style="display: none">
                                                        <div class="row">
                                                            <div class="form-group col-6">
                                                                <label for="name">Newspaper Name</label>
                                                                <input type="text" class="form-control" name="name" id="name" value="{{ $data ?? '' ? $data['name'] : old('name') }}" required>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <label for="status">Status</label>
                                                                <select name="status" class="form-control">
                                                                    <option value="1" @if(isset($data) && $data['status'] == 1) selected @endif>Active</option>
                                                                    <option value="0" @if(isset($data) && $data['status'] == 0) selected @endif>Inactive</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-2">
                                                                <button type="submit" class="btn btn-block btn-outline-secondary middle-button">
                                                                    @if (isset($data))
                                                                        Update
                                                                    @else
                                                                        Submit
                                                                    @endif
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile">
                                                    <div class="overlay-wrapper">
                                                        <div class="overlay dark detail-data"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Loading...</div></div>
                                                        <div class="col-sm-2 offset-sm-10">
                                                            @if (isset($data))
                                                                <button type="button" class="btn btn-block btn-outline-secondary btn" data-toggle="modal" data-target="#modal-xl" onclick="modalCreate()"><i class="fas fa-plus"></i> Create Detail</button>    
                                                            @endif
                                                        </div>
                                                        <br>
                                                        <div class="col-sm-12" style="overflow-x: auto;">
                                                            <table id="datatable" class="table table-bordered table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Size</th>
                                                                        <th>Period</th>
                                                                        <th>Position</th>
                                                                        <th>Price</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="body-table-detail">
                                                                    {{-- body --}}
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('component.footer')
    </div>
    {{-- modals --}}
    @if (isset($data))
        <div class="modal fade" id="modal-xl">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form action={{ url("/services/newspaper/detail/".$data['id']) }} method="post">
                        @csrf
                        <input type="text" name="id" id="detail_id" style="display: none">
                        <div class="modal-header">
                            <h4 class="modal-title">Initiate Detail</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="size">Size</label>
                                        <select name="size" id="size-detail" class="form-control" required>
                                            <option value="Half Page">Half Page</option>
                                            <option value="Quarter Page">Quarter Page</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Period</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" name="period" id="period" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="position">Position</label>
                                        <select name="position" id="position-detail" class="form-control" required>
                                            <option value="Premium">Premium</option>
                                            <option value="Run On Point">Run On Point</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="price">Price</label>
                                        <input type="number" class="form-control" name="price" placeholder="nominal" id="price" required>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</body>
<script src={{ asset("/plugins/jquery/jquery.min.js") }}></script>
<script src={{ asset("/plugins/bootstrap/js/bootstrap.bundle.min.js") }}></script>
<script src={{ asset("/plugins/moment/moment.min.js") }}></script>
<script src={{ asset("/plugins/select2/js/select2.full.min.js") }}></script>
<script src={{ asset("/plugins/daterangepicker/daterangepicker.js") }}></script>
<script src={{ asset("/js/adminlte.min.js") }}></script>
<script>
    $(function () {
        $('#period').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            }
        })

    })

    function findNewspaper(id){
        $('.detail-data').show();
        if (id !== 0) {
            $.ajax({
                type:'GET',
                url:'/services/newspaper/detail/'+id,
                success:function(data) {
                    $('#body-table-detail').empty()
                    for(let row of data.data.data){
                        $('#body-table-detail').append('<tr>')
                        $('#body-table-detail').append(`<td>${row.size}</td>`)
                        $('#body-table-detail').append(`<td>${row.period_start} - ${row.period_end}</td>`)
                        $('#body-table-detail').append(`<td>${row.position}</td>`)
                        $('#body-table-detail').append(`<td>${row.price}</td>`)
                        $('#body-table-detail').append(`<td><button type="button" class="btn btn-block btn-default btn-sm" onclick="findDetail(${row.id})"><a href="#" class="text-muted"><i class="fas fa-eye"></i> View</a></button></td>`)
                        $('#body-table-detail').append('</tr>')
                    }
                    $('.detail-data').hide();
                }
            });
        } else {
            $('.detail-data').hide();
        }
    }

    function findDetail(detail_id){
        $.ajax({
                type:'GET',
                url:'/services/newspaper/detail-newspaper/'+detail_id,
                success:function(data) {
                    $('#detail_id').val(data.data.id)
                    $('#size-detail').val(data.data.size)
                    $('#position-detail').val(data.data.position)
                    $('#period').val(`${data.data.period_start} - ${data.data.period_end}`)
                    $('#price').val(data.data.price)
                    $('#modal-xl').modal('show');
                }
            });
    }

    function modalCreate(){
        $('#detail_id').val(null)
        $('#size-detail').val(null)
        $('#position-detail').val(null)
        $('#period').val(null)
        $('#price').val(null)
    }
</script>
</html>
