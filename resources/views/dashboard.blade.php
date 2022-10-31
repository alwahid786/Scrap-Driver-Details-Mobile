@extends('layouts.header')
@section('content')
<style>
    #toast-container>div {
        opacity: 1;
        background-color: #1D3E75;
    }

    .toast-progress {
        background-color: white;
        bottom: 0;
        -ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=40);
        filter: alpha(opacity=40);
        height: 4px;
        left: 0;
        opacity: .7;
        position: absolute;
    }

    .goBackDiv_s {
        position: absolute;
        top: 50%;
        left: 4%;
        transform: translateX(0%) translateY(-50%);
    }

    .goBackBtn_s {
        background-color: white;
        padding: 6px 10px;
        color: #1d3e75;
        font-weight: 600;
        border-radius: 15px;
    }
</style>

<!-- Navbar section  -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12 px-0">
            <div class="navbar_s">
                <div class="navText_s text-center">
                    ScrapIt Dispatch
                </div>
                <div class="goBackDiv_s">
                    <button class="goBackBtn_s">Go Back
                        <i class="fa-solid fa-chevrons-left ml-2" style="color: #1D3E75; font-weight: 600;"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-md container-fluid">
    <x:notify-messages />

    <div class="row">
        <div class="col-12 mt-3">
            <h3 style="color: #1D3E75; font-weight: 600;">All Slips</h3>
        </div>
        <div class="col-12 mt-3 py-3">
            @if (isset($data) && !empty($data))
            <table id="example" class="table table-hover" style="width:100%">
                <thead class="tHead_s">
                    <tr>
                        <th>ID</th>
                        <th>Size</th>
                        <th>Date</th>
                        <th>Supplier Name</th>
                        <th>Supplier Address</th>
                        <th>Supplier City</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $slip)
                    <tr>
                        <td>{{$slip->slip_number}}</td>
                        <td>{{$slip->container_type}}</td>
                        <td>{{$slip->slip_date}}</td>
                        <td>{{$slip->supplier_name}}</td>
                        <td>{{$slip->supplier_address}}</td>
                        <td>{{$slip->supplier_city}}</td>
                        <td class="text-center">
                            <?php $id = '/' . $slip->slip_number ?>
                            <a href="javascript:void(0)" style="background-color: #1d3e75; border-radius: 8px; color:white; text-decoration:none;" class=" px-3 py-1 py-sm-2 px-sm-4 viewData_d">View</a>
                        </td>
                        <form class="listDetailForm_d" action="{{route('listDetail')}}" method="get" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="slipnum" value="{{$slip->slip_number}}">
                        </form>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="text-center">
                <h2 class="text-danger"><strong>No Slips Available</strong></h2>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
    width = $(window).width();
    if (width < 600) {
        $('#example').addClass('table-responsive');
    } else {
        $('#example').removeClass('table-responsive');
    }

    $(".viewData_d").click(function() {
        $('.listDetailForm_d').submit();
    });
</script>
<script>
    $(document).ready(function() {
        $(".loader_s").addClass('d-none');
    });
    $(".viewData_d").click(function() {
        $(".loader_s").removeClass('d-none');
    });
</script>
<script>
    @if(Session::has('message'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.success("{{ session('message') }}");
    @endif

    @if(Session::has('error'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.error("{{ session('error') }}");
    @endif

    @if(Session::has('info'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.info("{{ session('info') }}");
    @endif

    @if(Session::has('warning'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.warning("{{ session('warning') }}");
    @endif
</script>
@endsection