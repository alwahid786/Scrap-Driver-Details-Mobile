<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;




class AuthController extends Controller
{
    public function loginAPI(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'driver_name' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->messages())->withInput();
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->get('https://morristown.scrapitsoftware.com:4443/sr/android_login?method=login&username=' . $request->username);
        $convertor = $response->body();
        $loginResponse = json_decode($convertor, true);
        if ($loginResponse['message'] == 'Valid Login') {
            Session::put('driverName', $request->driver_name);
            Session::put('driverCode', $request->username);
            $slipresponse = Http::get('https://morristown.scrapitsoftware.com:4443/sr/get_slip_array?username=' . $request->username);
            $newconvertor = $slipresponse->body();
            $newslipResponse = json_decode($newconvertor, true);
            $slipresponse = explode('{"error":"Valid Login"}', $slipresponse->body())[0];
            $slipresponse = json_decode($slipresponse);
            $slipresponse = $slipresponse->sliprow;
            return view('dashboard', ['data' => $slipresponse]);
        } else {
            Session::flash('loginError', $loginResponse['message']);
            return redirect()->back();
        }
    }

    public function listDetail(Request $request)
    {
        $request->slipnum;
        $response = Http::get('https://morristown.scrapitsoftware.com:4443/sr/get_slip?slipnum=' . $request->slipnum);
        $data = $response->body();
        $dataresponse = json_decode($data);
        $name = Session::get('driverName');
        return view('listing-detail', ['data' => $dataresponse, 'name' => $name]);
    }

    public function startSlip(Request $request)
    {
        $response = Http::get('https://morristown.scrapitsoftware.com:4443/sr/start_slip?slipnum=' . $request->slipnum);
        $data = $response->body();
        $dataresponse = json_decode($data);
        $name = Session::get('driverName');
        return view('listing-detail', ['data' => $dataresponse, 'name' => $name]);
    }

    // Complete Slip 
    public function completeSlip(Request $request)
    {
        $response = Http::get('https://morristown.scrapitsoftware.com:4443/sr/complete_slip?slipnum=' . $request->slipnum . '&driver_name=' . $request->driver_name);
        $data = $response->body();
        $dataresponse = json_decode($data);
        $name = Session::get('driverCode');
        $slipresponse = Http::get('https://morristown.scrapitsoftware.com:4443/sr/get_slip_array?username=' . $name);
        $newconvertor = $slipresponse->body();
        $newslipResponse = json_decode($newconvertor, true);
        $slipresponse = explode('{"error":"Valid Login"}', $slipresponse->body())[0];
        $slipresponse = json_decode($slipresponse);
        $slipresponse = $slipresponse->sliprow;
        return view('dashboard', ['data' => $slipresponse]);
    }

    public function saveNotes(Request $request)
    {
        $response = Http::get('https://morristown.scrapitsoftware.com:4443/sr/change_notes?slipnum=' . $request->slipnum . '&notes=' . $request->notes);
        $data = $response->body();
        $dataresponse = json_decode($data);
        return redirect()->back();
        // return view('listing-detail', ['data' => $dataresponse]);
    }
}
