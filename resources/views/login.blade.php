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
                    <label for="code" class="inputLabels_s">
                        Driver Code:
                    </label><br>
                    <input type="text" class="codeInput_s" placeholder="Enter Driver Code Here...">
                    <label for="code" class="mt-3 inputLabels_s">
                        Driver Name:
                    </label><br>
                    <input type="text" class="codeInput_s" placeholder="Enter Driver Name Here...">
                    <button class="signInBtn_s">
                        SIGN IN
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection