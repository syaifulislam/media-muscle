<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ env("APP_TITLE_PREFIX") }} | Out Of Home</title>

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
    <style>
        #map {
            height: 100%;
        }
    </style>
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
                                                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Out Of Home</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false" onclick="findOutOfHome({{ $data ?? '' ? $data['id'] : 0 }})">Detail</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                                <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                                    <form action={{ url("/services/out-of-home/post") }} method="post">
                                                        @csrf
                                                        <input type="text" name="id" value="{{ $data ?? '' ? $data['id'] : null }}" style="display: none">
                                                        <input type="text" name="longitude" id="longitude" value="{{ $data ?? '' ? $data['longitude'] : null }}" style="display: none">
                                                        <input type="text" name="latitude" id="latitude" value="{{ $data ?? '' ? $data['latitude'] : null }}" style="display: none">
                                                        <div class="row">
                                                            <div class="form-group col-12" style="height: 500px;margin-bottom: 2rem;">
                                                                <label for="name">Maps</label>
                                                                <div id="map"></div>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <label for="name">Name</label>
                                                                <input type="text" class="form-control" name="name" id="name" value="{{ $data ?? '' ? $data['name'] : old('name') }}" required>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <label for="city_id">City</label>
                                                                <select name="city_id" id="city" class="form-control" onchange="city_change()">
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <label for="region">Region</label>
                                                                <select name="region" class="form-control">
                                                                    <option value="National" @if(isset($data) && $data['region'] === 'National') selected @endif>National</option>
                                                                    <option value="Local" @if(isset($data) && $data['region'] === 'Local') selected @endif>Local</option>
                                                                </select>
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
                                                                        <th>Type</th>
                                                                        <th>Duration</th>
                                                                        <th>Period</th>
                                                                        <th>Price</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="body-table-detail">
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
                    <form action={{ url("/services/out-of-home/detail/".$data['id']) }} method="post">
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
                                        <label for="type">Type</label>
                                        <select name="type" id="type-detail" class="form-control" required>
                                            <option value="Static">Static</option>
                                            <option value="LED">LED</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Duration</label>
                                        <select name="duration" id="duration-detail" class="form-control" required>
                                            <option value="15">15 Minutes</option>
                                            <option value="30">30 Minutes</option>
                                            <option value="45">45 Minutes</option>
                                            <option value="60">60 Minutes</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="period">Period</label>
                                        <select name="period" id="period-detail" class="form-control" required>
                                            <option value="1">1 Month</option>
                                            <option value="2">2 Month</option>
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
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GMAPS_API_KEY') }}&callback=initMap&libraries=places"
  type="text/javascript"></script>
<script>
    $(function () {
        $('#period').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            }
        })

        $.ajax({
            type:'GET',
            url:'/whitelist/city',
            success:function(data) {
                let optCity = $('#city')
                for(let row of data.data){
                    optCity.append(`<option value="${row.id}">${row.name}</option>`)
                }
                let dataInit = "{{ $jsInit }}"
                if (dataInit == 1){
                    let dataPassing = {!! json_encode($data ?? '') !!}
                    $(`#city option[value=${dataPassing.city_id}]`).attr('selected','selected')
                }
            }
        });
    })

    var map;
    var marker;
    function initMap() {
        var long = 96.72742664375
        var lat = 4.717033579261101
        var longlat = { lat: lat, lng: long }
        map = new google.maps.Map(document.getElementById("map"), {
            center: longlat,
            zoom: 7
        });
        marker = new google.maps.Marker({
            position: longlat,
            draggable: true,
            map: map,
            title: 'Drag me!'
        });

        let longInit = $('#longitude').val()
        let latInit = $('#latitude').val()
        if (longInit != '' && latInit != ''){
            createMarker(latInit,longInit)
        }

        marker.addListener('dragend', dragMarkerEvent);

    }

    function dragMarkerEvent(event){
        var newLat = event.latLng.lat()
        var newLong = event.latLng.lng()
        setNewLongLat(newLong,newLat)
    }

    function setNewLongLat(longitude, latitude){
        $('#longitude').val(longitude)
        $('#latitude').val(latitude)

    }

    function city_change(){
        let city = $('#city option:selected').html()
        var request = {
            query: city,
            fields: ['name', 'geometry'],
        };
        var service = new google.maps.places.PlacesService(map);
        service.findPlaceFromQuery(request, function(results, status) {
            if (status === google.maps.places.PlacesServiceStatus.OK) {
                createMarker(results[0].geometry.location.lat(),results[0].geometry.location.lng());
            }
        });
    }

    function createMarker(lat,lng) {
        marker.setPosition( new google.maps.LatLng( lat,lng ) );
        map.setCenter({lat: parseFloat(lat), lng: parseFloat(lng)}); 
        setNewLongLat(lng,lat)
    }

    function findOutOfHome(id){
        $('.detail-data').show();
        if (id !== 0) {
            $.ajax({
                type:'GET',
                url:'/services/out-of-home/detail/'+id,
                success:function(data) {
                    $('#body-table-detail').empty()
                    for(let row of data.data.data){
                        $('#body-table-detail').append('<tr>')
                        $('#body-table-detail').append(`<td>${row.type}</td>`)
                        $('#body-table-detail').append(`<td>${row.duration}</td>`)
                        $('#body-table-detail').append(`<td>${row.period} Month</td>`)
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
                url:'/services/out-of-home/detail-ooh/'+detail_id,
                success:function(data) {
                    $('#detail_id').val(data.data.id)
                    $('#type-detail').val(data.data.type)
                    $('#period-detail').val(data.data.period)
                    $('#duration-detail').val(data.data.duration)
                    $('#price').val(data.data.price)
                    $('#modal-xl').modal('show');
                }
            });
    }

    function modalCreate(){
        $('#detail_id').val(null)
        $('#type-detail').val(null)
        $('#duration-detail').val(null)
        $('#period-detail').val(null)
        $('#price').val(null)
    }
</script>
</html>
