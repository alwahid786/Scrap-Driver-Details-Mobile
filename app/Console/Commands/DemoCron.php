<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;



class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        info("Cron Job running at " . now());

        /*------------------------------------------
        --------------------------------------------
        Write Your Logic Here....
        I am getting users and create new users if not exist....
        --------------------------------------------
        --------------------------------------------*/
        $code = Session::get('driverCode');

        // Update User Location API Call 
        $ip = \Request::ip();
        $currentUserInfo = Location::get($ip);
        $locationApi = Http::get('https://morristown.scrapitsoftware.com:4443/sr/update_location?driver_code=' . $code . '&longitude=' . $currentUserInfo->longitude . '&latitude=' . $currentUserInfo->latitude);
        return true;
    }
}
