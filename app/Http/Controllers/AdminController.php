<?php

namespace App\Http\Controllers;

use App\Application;
use App\Page;
use App\Setting;
use App\Toppics;
use App\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $seting_country = Setting::where('name', 'default_country')->first()->value;
        $country = isset($_COOKIE['country']) ? $_COOKIE['country'] : $seting_country;
        $totallang = Translation::count('id');
        $totalapp = Application::count('id');
        $totaltoppic = Toppics::count('id');
        $totalpage = Page::count('id');
        $apps = DB::table("applications")
            ->select("applications.*",
                DB::raw("(SELECT apps_info.title FROM apps_info
                                WHERE apps_info.appid = applications.appid AND apps_info.country='" . $country . "') as stitle"))
            ->orderBy('id', 'desc')->limit(18)->get();
        //$apps = Application::orderBy('id', 'desc')->limit(18)->get();
        return view('admin.admin', compact('totalapp', 'totallang', 'apps', 'totaltoppic', 'totalpage'));
    }
}
