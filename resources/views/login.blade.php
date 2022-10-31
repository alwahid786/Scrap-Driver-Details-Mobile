@extends('layouts.header')
@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- <div class="col-3 loginSideSection_s">

        </div> -->
        <div class="col-12 loginContentSection_s">
            <div class=" contentDiv_s mx-auto">
                <h2 class="headingText_s">Welcome To Scrap It!</h2>
                <div class="logincardDiv">
                    <form action="{{route('loginAPI')}}" method="get" enctype="multipart/form-data">
                        @csrf
                        @error('username')
                        <div class="alert alert-danger alert-dismissible fade show login-email-field" role="alert">
                            {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @enderror
                        @error('driver_name')    
                        <div class="alert alert-danger alert-dismissible fade show login-email-field" role="alert">
                            {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @enderror
                        @if (Session::has('loginError'))
                        <div class="alert alert-danger alert-dismissible fade show login-email-field" role="alert">
                            {{ Session::get('loginError') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <label for="code" class="inputLabels_s">
                            Driver Code:
                        </label><br>
                        <input type="text" class="codeInput_s" name="username" placeholder="Enter Driver Code Here...">
                        <label for="code" class="mt-3 inputLabels_s">
                            Driver Name:
                        </label><br>
                        <input type="text" name="driver_name" class="codeInput_s" placeholder="Enter Driver Name Here...">
                        <input type="hidden" name="method" value="login">
                        <button class="signInBtn_s signInBtn_d" type="submit">
                            SIGN IN
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".loader_s").addClass('d-none');
    });
    $(".signInBtn_d").click(function() {
        $(".loader_s").removeClass('d-none');
    });
</script>
@endsection