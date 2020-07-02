<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ env("APP_TITLE_PREFIX") }} | Order Details</title>

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
                                    <div class="col-md-12">
                                        <h3>Data Member</h3>
                                        <div class="row">
                                            <div class="col-2">Name</div>
                                            <div class="col-10">: {{$data->client->name}}</div>
                                            <div class="col-2">Phone Number</div>
                                            <div class="col-10">: +{{$data->client->phone_code}}{{$data->client->phone_number}}</div>
                                            <div class="col-2">Member Type</div>
                                            <div class="col-10">: {{$data->client->isPersonal == 1 ? "Personal" : "Company"}}</div>
                                            <div class="col-2">NPWP</div>
                                            <div class="col-10">: {{$data->client->npwp}}</div>
                                            <div class="col-2">Email</div>
                                            <div class="col-10">: {{$data->client->email}}</div>
                                        </div>
                                    </div>
                                    <hr style="border: 1px solid black;width: 100%;">
                                    <div class="col-md-12">
                                        <h3>Data Order</h3>
                                        <div class="row">
                                            <div class="col-2">Invoice Number</div>
                                            <div class="col-10">: {{$data->invoice_number}}</div>
                                            <div class="col-2">Total Price</div>
                                            <div class="col-10">: {{$data->total_price}}</div>
                                            <div class="col-2">Status</div>
                                            <div class="col-10">: {{$data->status}}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding-top:20px">
                                        <div class="card">
                                            <div class="card-body table-responsive p-0">
                                                <table class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Item Name</th>
                                                            <th>Price</th>
                                                            <th>Period Start</th>
                                                            <th>Period End</th>
                                                            <th>Product</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($data->order_detail as $item)
                                                            <tr>
                                                                <td>{{$item->item_name}}</td>
                                                                <td>{{$item->price}}</td>
                                                                <td>{{$item->period_start != null ? $item->period_start : "-"}}</td>
                                                                <td>{{$item->period_end != null ? $item->period_end : "-"}}</td>
                                                                @if ($item->television_detail_id)
                                                                    <td>Television</td>
                                                                @elseif($item->radio_detail_id)
                                                                    <td>Radio</td>
                                                                @elseif($item->newspaper_detail_id)
                                                                    <td>Newspaper</td>
                                                                @else
                                                                    <td>Out Of Home</td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="border: 1px solid black;width: 100%;">
                                    <div class="col-md-12">
                                        <form action={{url('/order/'.$data->id)}} method="post">
                                            @csrf
                                            <div class="form-group col-2">
                                                <label>Status</label>
                                                <select name="status" id="status" class="custom-select" @if($data['status'] == 'Completed') disabled @endif>
                                                    <option value="On Progress" @if(isset($data) && $data['status'] == 'On Progress') selected @endif>On Progress</option>
                                                    <option value="Completed" @if(isset($data) && $data['status'] == 'Completed') selected @endif>Completed</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-1">
                                                <button type="submit" class="btn btn-block btn-outline-secondary middle-button" @if($data['status'] == 'Completed') disabled @endif>Update</button>
                                            </div>
                                        </form>
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
</body>
<script src={{ asset("/plugins/jquery/jquery.min.js") }}></script>
<script src={{ asset("/plugins/bootstrap/js/bootstrap.bundle.min.js") }}></script>
<script src={{ asset("/js/adminlte.min.js") }}></script>
</html>
