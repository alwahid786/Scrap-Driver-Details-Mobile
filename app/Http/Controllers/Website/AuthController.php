<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Stevebauman\Location\Facades\Location;


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

            // Update User Location API Call 
            $ip = $request->ip();
            $currentUserInfo = Location::get($ip);
            $locationApi = Http::get('https://morristown.scrapitsoftware.com:4443/sr/update_location?driver_code=' . $request->username . '&longitude=' . $currentUserInfo->longitude . '&latitude=' . $currentUserInfo->latitude);
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
        $code = Session::get('driverCode');
        $ip = $request->ip();
        $currentUserInfo = Location::get($ip);

        // Update User Location API Call 
        $ip = $request->ip();
        $currentUserInfo = Location::get($ip);
        $locationApi = Http::get('https://morristown.scrapitsoftware.com:4443/sr/update_location?driver_code=' . $code . '&longitude=' . $currentUserInfo->longitude . '&latitude=' . $currentUserInfo->latitude);
        return view('listing-detail', ['data' => $dataresponse, 'name' => $name, 'location' => $currentUserInfo, 'code' => $code]);
    }

    public function startSlip(Request $request)
    {
        $response = Http::get('https://morristown.scrapitsoftware.com:4443/sr/start_slip?slipnum=' . $request->slipnum);
        $data = $response->body();
        $dataresponse = json_decode($data);
        $name = Session::get('driverName');
        $ip = $request->ip();
        $currentUserInfo = Location::get($ip);
        $code = Session::get('driverCode');

        // Update User Location API Call 
        $ip = $request->ip();
        $currentUserInfo = Location::get($ip);
        $locationApi = Http::get('https://morristown.scrapitsoftware.com:4443/sr/update_location?driver_code=' . $code . '&longitude=' . $currentUserInfo->longitude . '&latitude=' . $currentUserInfo->latitude);
        notify()->success('Action performed successfully!');
        return view('listing-detail', ['data' => $dataresponse, 'name' => $name, 'location' => $currentUserInfo, 'code' => $code]);
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
        $code = Session::get('driverCode');

        // Update User Location API Call 
        $ip = $request->ip();
        $currentUserInfo = Location::get($ip);
        $locationApi = Http::get('https://morristown.scrapitsoftware.com:4443/sr/update_location?driver_code=' . $code . '&longitude=' . $currentUserInfo->longitude . '&latitude=' . $currentUserInfo->latitude);
        notify()->success('Action performed successfully!');

        return view('dashboard', ['data' => $slipresponse]);
    }

    public function saveNotes(Request $request)
    {
        $response = Http::get('https://morristown.scrapitsoftware.com:4443/sr/change_notes?slipnum=' . $request->slipnum . '&notes=' . $request->notes);
        $data = $response->body();
        $dataresponse = json_decode($data);
        notify()->success('Action performed successfully!');

        $code = Session::get('driverCode');

        // Update User Location API Call 
        $ip = $request->ip();
        $currentUserInfo = Location::get($ip);
        $locationApi = Http::get('https://morristown.scrapitsoftware.com:4443/sr/update_location?driver_code=' . $code . '&longitude=' . $currentUserInfo->longitude . '&latitude=' . $currentUserInfo->latitude);

        return redirect()->back();
        // return view('listing-detail', ['data' => $dataresponse]);
    }

    public function binRemove(Request $request)
    {
        $response = Http::get('https://morristown.scrapitsoftware.com:4443/sr/add_container_out?slipnum=' . $request->slipnum . '&new_container=' . $request->new_container . '&longitude=' . $request->longitude . '&latitude=' . $request->latitude . '&driver_code=' . $request->driver_code);
        $data = $response->body();
        $dataresponse = json_decode($data);
        notify()->success('Action performed successfully!');

        $code = Session::get('driverCode');

        // Update User Location API Call 
        $ip = $request->ip();
        $currentUserInfo = Location::get($ip);
        $locationApi = Http::get('https://morristown.scrapitsoftware.com:4443/sr/update_location?driver_code=' . $code . '&longitude=' . $currentUserInfo->longitude . '&latitude=' . $currentUserInfo->latitude);

        return redirect()->back();
    }

    public function binPlace(Request $request)
    {
        $response = Http::get('https://morristown.scrapitsoftware.com:4443/sr/add_container_in?slipnum=' . $request->slipnum . '&new_container=' . $request->new_container . '&longitude=' . $request->longitude . '&latitude=' . $request->latitude . '&driver_code=' . $request->driver_code . '&yardcode=' . $request->yardcode);
        $data = $response->body();
        $dataresponse = json_decode($data);
        notify()->success('Action performed successfully!');

        $code = Session::get('driverCode');

        // Update User Location API Call 
        $ip = $request->ip();
        $currentUserInfo = Location::get($ip);
        $locationApi = Http::get('https://morristown.scrapitsoftware.com:4443/sr/update_location?driver_code=' . $code . '&longitude=' . $currentUserInfo->longitude . '&latitude=' . $currentUserInfo->latitude);

        return redirect()->back();
    }
}
