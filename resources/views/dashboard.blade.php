@extends('layouts.header')
@section('content')
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
<div class="container">
    <div class="row">
        <div class="col-12 mt-3">
            <h3>All Listings</h3>
        </div>
        <div class="col-12 mt-3 py-3">
            <table id="example" class="table table-hover" style="width:100%">
                <thead class="tHead_s">
                    <tr>
                        <th>ID</th>
                        <th>Size</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>0225</td>
                        <td>43 yard container</td>
                        <td>27/Dec, 2022</td>
                        <td>Willington park, 4 Avenue</td>
                        <td class="text-center">
                            <a href="{{url('/listing/detail')}}" class="actionBtn_s">View</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>
@endsection