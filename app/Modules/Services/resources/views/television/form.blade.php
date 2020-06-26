<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ env("APP_TITLE_PREFIX") }} | Television</title>

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
                                                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Television</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false" onclick="findTelevision({{ $data ?? '' ? $data['id'] : 0 }})">Detail</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                                <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                                    <form action={{ url("/services/television/post") }} method="post">
                                                        @csrf
                                                        <input type="text" name="id" value="{{ $data ?? '' ? $data['id'] : null }}" style="display: none">
                                                        <div class="row">
                                                            <div class="form-group col-6">
                                                                <label for="name">Broadcaster Name</label>
                                                                <input type="text" class="form-control" name="name" id="name" value="{{ $data ?? '' ? $data['name'] : old('name') }}" required>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <label for="region">Region</label>
                                                                <select name="region" class="form-control">
                                                                    <option value="National" @if(isset($data) && $data['region'] === 'National') selected @endif>National</option>
                                                                    <option value="Local" @if(isset($data) && $data['region'] === 'Local') selected @endif>Local</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <label for="period">Period</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="far fa-calendar-alt"></i>
                                                                        </span>
                                                                    </div>
                                                                    <input type="text" name="period" value="{{ $data ?? '' ? $data['period'] : old('period') }}" class="form-control float-right" id="period">
                                                                </div>
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
                                                                        <th>Program Name</th>
                                                                        <th>Date</th>
                                                                        <th>Time Start</th>
                                                                        <th>Time End</th>
                                                                        <th>Time</th>
                                                                        <th>Duration</th>
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
                    <form action={{ url("/services/television/detail/".$data['id']) }} method="post">
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
                                        <label for="program_name">Program Name</label>
                                        <input type="text" class="form-control" name="program_name" id="program_name" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="time">Time</label>
                                        <select name="time" id="time-detail" class="form-control" required>
                                            <option value="Prime">Prime</option>
                                            <option value="Non Prime">Non Prime</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="date">Time</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="date" value="" class="form-control float-right" id="date_program" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Time Start</label>
                                        <select name="time_start" id="time_start" class="form-control" style="width: 100%;" required>
                                            @include('component.opt_time')
                                        </select>
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Time End</label>
                                        <select name="time_end" id="time_end" class="form-control" style="width: 100%;" required>
                                            @include('component.opt_time')
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="duration">Duration</label>
                                        <select name="duration" id="duration" class="form-control" required>
                                            <option value="15">15 Minutes</option>
                                            <option value="30">30 Minutes</option>
                                            <option value="45">45 Minutes</option>
                                            <option value="60">60 Minutes</option>
                                        </select>
                                    </div>
                                    {{-- <div class="form-group col-6">
                                        <label for="position">Position</label>
                                        <select name="position" class="form-control" id="position" onchange="changePos()">
                                            <option value="Premium">Premium</option>
                                            <option value="Run On Point">Run On Point</option>
                                        </select>
                                    </div> --}}
                                    <div class="form-group col-3">
                                        <label for="premium_price">Premium Price</label>
                                        <input type="number" class="form-control" name="premium_price" placeholder="nominal" id="premium_price" required>
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="run_price">Run On Point Price</label>
                                        <input type="number" class="form-control" name="run_price" placeholder="nominal" id="run_price" required>
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

    function findTelevision(id){
        let dataInit = "{{ $jsInit }}"
        if (dataInit == 1){
            let dataPassing = {!! json_encode($data ?? '') !!}
            $('#date_program').daterangepicker({
                minDate: dataPassing.p_start,
                maxDate: dataPassing.p_end,
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            })
        }
        $('.detail-data').show();
        if (id !== 0) {
            $.ajax({
                type:'GET',
                url:'/services/television/detail/'+id,
                success:function(data) {
                    $('#body-table-detail').empty()
                    for(let row of data.data.data){
                        $('#body-table-detail').append('<tr>')
                        $('#body-table-detail').append(`<td>${row.program_name}</td>`)
                        $('#body-table-detail').append(`<td>${row.date}</td>`)
                        $('#body-table-detail').append(`<td>${row.time_start}</td>`)
                        $('#body-table-detail').append(`<td>${row.time_end}</td>`)
                        $('#body-table-detail').append(`<td>${row.time}</td>`)
                        $('#body-table-detail').append(`<td>${row.duration}</td>`)
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
                url:'/services/television/detail-television/'+detail_id,
                success:function(data) {
                    $('#program_name').val(data.data.program_name)
                    $('#detail_id').val(data.data.id)
                    $('#time-detail').val(data.data.time)
                    $('#time_start').val(data.data.time_start)
                    $('#time_end').val(data.data.time_end)
                    $('#duration').val(data.data.duration)
                    $('#date_program').val(data.data.date)
                    $('#premium_price').val(data.data.premium_price)
                    $('#run_price').val(data.data.run_price)
                    $('#modal-xl').modal('show');
                }
            });
    }

    function modalCreate(){
        $('#program_name').val(null)
        $('#detail_id').val(null)
        $('#time-detail').val(null)
        $('#time_start').val(null)
        $('#time_end').val(null)
        $('#duration').val(null)
        $('#date_program').val(null)
        $('#premium_price').val(null)
        $('#run_price').val(null)
    }
</script>
</html>
