@extends('layouts.header')
@section('content')
<style>
    .companyname_s {
        text-decoration: underline #1d3e75;
        color: #1d3e75;
    }

    @media only screen and (max-width: 600px) {
        .companyname_s {
            text-decoration: underline #1d3e75;
            color: #1d3e75;
            font-size: 23px;
        }

        .sizeDiv_s {
            width: 85%;
        }

        .token_s {
            font-size: 15px;
        }

        .binBtnsDiv_s {
            width: 85%;
        }

        .sizeDiv2_s {
            width: 85%;
        }

        .notesDiv_s {
            width: 85%;
        }


    }

    @media only screen and (max-width: 500px) {
        .sizeText_s {
            font-size: 20px !important;
        }

        .secondDiv_s {
            font-size: 20px !important;
            width: 70% !important;
        }

        .firstDiv_s {
            width: 30% !important;
        }

        .sizeDiv_s {
            padding: 20px;
        }


    }

    @media only screen and (max-width: 400px) {
        .companyname_s {
            text-decoration: underline #1d3e75;
            color: #1d3e75;
            font-size: 20px;
        }

        .sizeDiv_s {
            width: 95%;
        }

        .binBtnsDiv_s {
            width: 95%;
        }

        .sizeDiv2_s {
            width: 95%;
        }

        .notesDiv_s {
            width: 95%;
        }

        .width_s {
            width: 70% !important;
        }
    }

    .width_s {
        width: 50%;
    }
</style>
<!-- Navbar section  -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12 px-0">
            <div class="navbar_s text-center">
                <span class="navText_s ">
                    ScrapIt Dispatch
                </span>
            </div>
        </div>
    </div>
</div>
<div class="container-md container-fluid">
    <div class="row pt-4">
        <div class="col-sm-9 col-12">
            <h3 class="companyname_s">
                {{$data->supplier_name}},
                {{$data->supplier_address}},
                {{$data->supplier_city}}.
            </h3>
        </div>
        <div class="col-sm-3 col-12 text-sm-right">
            <h4 class="token_s">
                {{$data->slip_number}}
            </h4>
        </div>
    </div>
    <div class="row py-3">
        <div class="mx-auto sizeDiv_s mt-3">
            <div class="d-flex divBorder_s">
                <div class="firstDiv_s">
                    <strong class="sizeText_s">Size:</strong>
                </div>
                <div class="secondDiv_s">
                    <span class="sizeText_s"> {{$data->container_type}}
                    </span>
                </div>
            </div>
            <div class="d-flex mt-3">
                <div class="firstDiv_s">
                    <strong class="sizeText_s">Notes:</strong>
                </div>
                <div class="secondDiv_s">
                    <span class="sizeText_s"> {{$data->notes}}
                    </span>
                </div>
            </div>
            <button class="startBtn_s mt-4 btn" data-toggle="modal" data-target="#exampleModal">
                START
            </button>
            <div class="mt-5">
                <input type="text" class="inputContNum_s inputContNum_d text-center" placeholder="Container Number">
                <button class="startBtn_s mt-4" data-toggle="modal" data-target="#exampleModal" disabled>
                    SCAN BARCODE
                </button>
            </div>
        </div>
        <div class="mx-auto binBtnsDiv_s d-flex justify-content-around mt-4">
            <button class="binBtns_s mr-1" data-toggle="modal" data-target="#binRemoveModal">
                Bin Removed
            </button>
            <button class="binBtns_s ml-1" data-toggle="modal" data-target="#binPlaceModal">
                Bin Placed
            </button>
        </div>
    </div>
    <div class="row pb-5">
        <div class="sizeDiv2_s mx-auto mt-5 ">
            <div class="d-flex align-items-center justify-content-around py-2 bg_blue_s">
                <div class="heading_s ">
                    Removed
                </div>
                <div class="heading_s">
                    Placed
                </div>
            </div>
            <div class="d-flex contentDiv_s">
                @foreach($data->container_out_row as $removed)
                <div class="w-50 div1_s text-center py-2">
                    {{$removed}}
                </div>
                @endforeach
                @foreach($data->container_in_row as $placed)
                <div class="w-50 text-center py-2">
                    {{$placed}}
                </div>
                @endforeach

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 ">
            <div class=" mx-auto width_s">
                <button class="slipbtn_s" data-toggle="modal" data-target="#slipCompleteModal">
                    SLIP COMPLETE
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="notesDiv_s mx-auto mt-5">
            <textarea name="" id="" class="textarea_s textarea_d" rows="5" placeholder="{{$data->notes}}"></textarea>
            <div class="w-50 mx-auto my-2">
                <button class="slipbtn_s slipbtn_d" data-toggle="modal" data-target="#saveNotesModal">
                    SAVE NOTES
                </button>
            </div>
        </div>
    </div>
    <div class="row py-5">
        <div class="col-12 mt-5">
            <h2 class="binDetail_s">Bin Details:</h2>
            <div class="binDetailDiv_s">
                <span>{{$data->bin_types}}</span>
            </div>
        </div>
    </div>
</div>

<!--Start Slip Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modalContent_s">
            <div class="h3">
                Confirm Start Slip {{$data->slip_number}} ?
            </div>
            <div class="d-flex mt-3">
                <button class="modalNoBtn_s" class="close" data-dismiss="modal" aria-label="Close">
                    No
                </button>
                <form action="{{route('startSlip')}}" method="get" enctype="multipart/form-data" style="width:50%">
                    @csrf
                    <input type="hidden" name="slipnum" value="{{$data->slip_number}}">
                    <button class="modalYesBtn_s w-100" type="submit">
                        Yes
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Bin remove Modal -->
<div class="modal fade" id="binRemoveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modalContent_s">
            <div class="h3">
                Confirm Bin remove. Are you sure ?
            </div>
            <div class="d-flex mt-3">
                <button class="modalNoBtn_s" class="close" data-dismiss="modal" aria-label="Close">
                    No
                </button>
                <form action="{{route('binRemove')}}" method="get" enctype="multipart/form-data" style="width:50%">
                    @csrf
                    <input type="hidden" name="slipnum" value="{{$data->slip_number}}">
                    <input type="hidden" class="container_d" name="new_container" value="">
                    <input type="hidden" name="longitude" value="-87.6298">
                    {{--<!-- <input type="hidden" name="longitude" value="{{$location->longitude}}"> -->--}}
                    <input type="hidden" name="latitude" value="41.8781">
                    {{--<!-- <input type="hidden" name="latitude" value="{{$location->latitude}}"> -->--}}
                    <input type="hidden" name="driver_code" value="{{$code}}">
                    <input type="hidden" name="yardcode" value="{{$data->slip_number}}">
                    <button class="modalYesBtn_s w-100" type="submit">
                        Yes
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Bin Place Modal -->
<div class="modal fade" id="binPlaceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modalContent_s">
            <div class="h3">
                Confirm Bin Place. Are you sure ?
            </div>
            <div class="d-flex mt-3">
                <button class="modalNoBtn_s" class="close" data-dismiss="modal" aria-label="Close">
                    No
                </button>
                <form action="{{route('binPlace')}}" method="get" enctype="multipart/form-data" style="width:50%">
                    @csrf
                    <input type="hidden" name="slipnum" value="{{$data->slip_number}}">
                    <input type="hidden" class="container_d" name="new_container" value="">
                    <input type="hidden" name="longitude" value="-87.6298">
                    {{--<!-- <input type="hidden" name="longitude" value="{{$location->longitude}}"> -->--}}
                    <input type="hidden" name="latitude" value="41.8781">
                    {{--<!-- <input type="hidden" name="latitude" value="{{$location->latitude}}"> -->--}}
                    <input type="hidden" name="driver_code" value="{{$code}}">
                    <input type="hidden" name="yardcode" value="{{$data->slip_number}}">
                    <button class="modalYesBtn_s w-100" type="submit">
                        Yes
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Slip Complete Modal -->
<div class="modal fade" id="slipCompleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modalContent_s">
            <div class="h3">
                Confirm Slip Complete. Are you sure ?
            </div>
            <div class="d-flex mt-3">
                <button class="modalNoBtn_s" class="close" data-dismiss="modal" aria-label="Close">
                    No
                </button>
                <form action="{{route('completeSlip')}}" method="get" enctype="multipart/form-data" style="width:50%">
                    @csrf
                    <input type="hidden" name="slipnum" value="{{$data->slip_number}}">
                    <input type="hidden" class="driverName_d" name="driver_name" value="{{$name}}">
                    <button class="modalYesBtn_s w-100" type="submit">
                        Yes
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Save Notes Modal -->
<div class="modal fade" id="saveNotesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modalContent_s">
            <div class="h3">
                Confirm Save Notes. Are you sure ?
            </div>
            <div class="d-flex mt-3">
                <button class="modalNoBtn_s" class="close" data-dismiss="modal" aria-label="Close">
                    No
                </button>
                <form action="{{route('saveNotes')}}" method="get" enctype="multipart/form-data" style="width:50%">
                    @csrf
                    <input type="hidden" name="slipnum" value="{{$data->slip_number}}">
                    <input type="hidden" class="notes_d" name="notes">
                    <button class="modalYesBtn_s w-100" type="submit">
                        Yes
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('.slipbtn_d').click(function() {
        let text = $('.textarea_d').val();
        $('.notes_d').val(text);
    })

    $(".inputContNum_d").on('keyup', function() {
        $(".container_d").val($(this).val());
    })

    let driverName = localStorage.getItem('driverName');
    $(".driverName_d").val(driverName);
</script>
@endsection