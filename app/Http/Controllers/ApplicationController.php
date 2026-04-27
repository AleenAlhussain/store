<?php

namespace App\Http\Controllers;

use Auth;
use App;
use App\Application;
use App\AppsInfo;
use App\Setting;
use App\Category;
use Demowebtv\GPlay\GPlayApps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    private $country;
    private $lang;
    private $cate_time;
    private $cate;
    private $screenshot_save;

    /** Create a new controller instance. */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $seting_country = Setting::where('name', 'default_country')->first()->value;
        $seting_lang = Setting::where('name', 'default_language')->first()->value;
        $this->country = isset($_COOKIE['country']) ? $_COOKIE['country'] : $seting_country;
        $this->lang = isset($_COOKIE['lang']) ? $_COOKIE['lang'] : $seting_lang;
        $this->cate_time = env('APP_CAHCE_TIME');
        // List of categories
        $categories = DB::table('categories')->orderBy('sort', 'ASC')->get();
        $this->cate = DB::table('categories')->pluck('id', 'slug');
        $this->screenshot_save = Setting::where('name', 'screenshot_save')->first();
        // Pass data to views
        View::share(['categories' => $categories]);
    }

    /**  Display a listing of the resource. */
    public function index()
    {
        // List of latest applications
        $apps = Application::orderBy('id', 'desc')->paginate(60);
//        $apps = DB::table("applications")
//            ->select("applications.*",
//                DB::raw("(SELECT apps_info.title FROM apps_info
//                                WHERE apps_info.appid = applications.appid AND apps_info.country='" . $this->country . "') as stitle"))
//            ->orderBy('id', 'desc')->paginate(60);
        // Return view
        //dd($apps);
        return view('apps.index', compact('apps'));
    }

    public function playstore()
    {
        return view('apps.playstore');
    }

    public function get_ajax_data(Request $request)
    {
        if ($request->ajax()) {

            if ($request->text !== '') {
//                $apps = DB::table("applications")
//                    ->select("applications.*",
//                        DB::raw("(SELECT apps_info.title FROM apps_info
//                                WHERE apps_info.appid = applications.appid AND apps_info.country='" . $this->country . "') as stitle"))
//                    ->where('applications.title', 'LIKE', "%$request->text%")
//                    ->orderBy('id', 'desc')->paginate(60);
                $apps = Application::where('title', 'LIKE', "%$request->text%")->orwhere('appid', '=', "$request->text")->orderBy('id', 'desc')->paginate(60);
            } else {
//                $apps = DB::table("applications")
//                    ->select("applications.*",
//                        DB::raw("(SELECT apps_info.title FROM apps_info
//                                WHERE apps_info.appid = applications.appid AND apps_info.country='" . $this->country . "') as stitle"))
//                    ->orderBy('id', 'desc')->paginate(60);
                $apps = Application::orderBy('id', 'desc')->paginate(60);
            }

            return view('apps.data', compact('apps'))->render();
        }
    }

    public function get_data_toppic(Request $request)
    {
        if ($request->ajax()) {
            if ($request->text !== '') {
                $apps = Application::where('title', 'LIKE', "%$request->text%")->orderBy('id', 'desc')->paginate(10);
            } else {
                $apps = [];
            }

            return view('apps.toppic', compact('apps'))->render();
        }
    }

    public function get_app_info(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->appid;
            //$content = Cache::remember('admin_get_info_' . $id . '_' . $this->country . '_' . $this->lang, $this->cate_time, function () use ($id) {
            $gplay = new GPlayApps();
            $gplay
                ->setDefaultLocale($this->lang)
                ->setDefaultCountry($this->country);
            if ($gplay->existsApp($id)) {
                $app = $gplay->getAppInfo($id);
                $app = json_decode(json_encode($app), true);
                $app['description'] = nl2br(e($app['description']));
                $app['score'] = round($app['score'], 1);
                $content['status'] = true;
                $content['data'] = $app;
            } else {
                $content['status'] = false;
            }
            return $content;
        }
        // });
        // return $content;
    }

    /**  Show the form for creating a new resource. */
    public function create()
    {
        // Return view
        return view('apps.create');
    }

    /**  Store a newly created resource in storage. */
    public function store(Request $request)
    {
        if (Auth::user()->email == 'demo@iapk.site') {
            return redirect()->back()->with("error", 'Demo acount only view.');
        }
        DB::beginTransaction();
        $this->validate($request, [
            'title' => 'required|max:255',
            'appid' => 'required|max:255',
            'description' => 'required',
            'category' => 'required',
            'developer' => 'required'
        ]);

        $app = new Application;
        $appdata = new AppsInfo;
        if ($app->where('appid', '=', $request->appid)->exists()) {
            return back()->with('error', 'App ' . $request->title . ' already exists. Please check again!');
        }
        try {
            // Check if the picture has been uploaded
            if ($request->hasFile('cover')) {
                $image = $request->file('cover');
                $filename = $request->appid . '.' . $image->extension();
                $location = public_path('images/' . $filename);
                Image::make($image)->resize(200, 200)->save($location);
                $app->cover = $filename;
            } else {
                $path = $request->get('cover');
                $filename = $request->appid . '.png';
                Image::make($path)->resize(200, 200)->save(public_path('images/' . $filename));
                $app->cover = $filename;
            }
            $count_s = [];
            if ($request->hasFile('images')) {
                $screenshots = $request->file('images');
                foreach ($screenshots as $k => $v) {
                    $filename = $request->appid . '_up_' . $k . '.' . $v->extension();
                    $v->move(public_path() . '/images/', $filename);
                    $count_s[] = asset('public/images/') . '/' . $filename;
                }
            }
            if (isset($request->preScreenshots) && count($request->preScreenshots) > 0) {
                if ($this->screenshot_save->value == 1) {
                    foreach ($request->preScreenshots as $k => $v) {
                        $filename = $request->appid . '_' . $k . '.jpg';
                        Image::make($v)->save(public_path('images/' . $filename));
                        $count_s[] = asset('public/images/') . '/' . $filename;
                    }
                } else {
                    $count_s = $request->preScreenshots;
                }
            }
            $slug = Str::slug($request->get('title'), '-');
            if (empty($slug)) $slug = str_slug($request->get('title'));
            $app->title = $request->get('title');
            $app->slug = $slug;
            $app->screenshots = json_encode($count_s);
            $app->appid = $request->get('appid');
            $app->category = $this->cate[$request->get('category')];
            $app->score = $request->get('score');
            $app->price = '';
            $app->developer = $request->get('developer');
            $app->installs = $request->get('installs');
            $app->five = $request->get('five');
            $app->four = $request->get('four');
            $app->three = $request->get('three');
            $app->two = $request->get('two');
            $app->one = $request->get('one');
            $app->releasedTimestamp = $request->get('releasedTimestamp');
            $app->updatedTimestamp = $request->get('updatedTimestamp');
            $app->numberVoters = $request->get('numberVoters');
            $app->url = $request->get('url_download');
            $app->votes = $request->get('votes');
            $appdata->title = $request->get('title');
            $appdata->description = $request->get('description');
            $appdata->slug = $slug;
            $appdata->appid = $request->get('appid');
            $appdata->summary = $request->get('summary');
            $appdata->recentChange = $request->get('recentChange');
            $appdata->size = $request->get('size');
            $appdata->appVersion = $request->get('appVersion');
            $appdata->androidVersion = $request->get('androidVersion');
            $appdata->locale = $this->lang;
            $appdata->country = $this->country;

            $app->save();
            $appdata->save();
            //$appdata->update(['title' => $appdata->title]);
            DB::commit();
            // Clear cache
            Cache::flush();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        // Redirect to application edit page
        return redirect()->route('apps.edit', $app->appid)->with('success', 'Add ' . $appdata->title . ' Successful!!!');
    }

    /** Show the form for editing the specified resource. */
    public function edit($id)
    {
        // Retrieve application details
        $app = Application::where('appid', $id)->first();
        $appsinfo = AppsInfo::where('appid', $id)->where('locale', $this->lang)->first();
        // Return 404 page if application not found
        if ($app == null) {
            abort(404);
        }
        $cate = json_decode(json_encode($this->cate), true);
        $app->category = array_search($app->category, $cate);
        if ($appsinfo == null) {
            $appsinfo['title'] = '';
            $appsinfo['description'] = '';
            $appsinfo['summary'] = '';
            $appsinfo['recentChange'] = '';
            $appsinfo['size'] = '';
            $appsinfo['appVersion'] = '';
            $appsinfo['androidVersion'] = '';
        } else {
            $appsinfo = json_decode(json_encode($appsinfo), true);
        }

        // Return view
        return view('apps.edit', compact('app', 'appsinfo', 'id'));
    }

    /**  Update the specified resource in storage. */
    public function update(Request $request, $id)
    {
        if (Auth::user()->email == 'demo@iapk.site') {
            return redirect()->back()->with("error", 'Demo acount only view.');
        }
        DB::beginTransaction();
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'category' => 'required',
            'developer' => 'required'
        ]);
        // Retrieve application details
        $app = Application::where('appid', $id)->first();
        $appdata = AppsInfo::where('appid', $id)->where('locale', $this->lang)->first();
        if ($appdata == null) {
            $appdata = new AppsInfo;
        }

        try {
            // Check if the picture has been uploaded
            if ($request->hasFile('cover')) {
                $image = $request->file('cover');
                $filename = $id . '.' . $image->extension();
                $location = public_path('images/' . $filename);
                Image::make($image)->resize(200, 200)->save($location);
                $app->cover = $filename;
            } else {
                //$path = $request->get('cover');
                $filename = $id . '.png';
                //Image::make($path)->resize(200, 200)->save(public_path('images/' . $filename));
                $app->cover = $filename;
            }
            $count_s = [];
            if ($request->hasFile('images')) {
                $screenshots = $request->file('images');
                foreach ($screenshots as $k => $v) {
                    $filename = $id . '_up_' . $k . '.' . $v->extension();
                    $v->move(public_path() . '/images/', $filename);
                    $count_s[] = asset('public/images/') . '/' . $filename;
                }
            }
            if (isset($request->preScreenshots) && count($request->preScreenshots) > 0) {
                foreach ($request->preScreenshots as $k => $v) {
                    $count_s[] = $v;
                    //Image::make($v)->save(public_path('images/' . $filename));
                }

            }
            $slug = Str::slug($request->get('title'), '-');
            if (empty($slug)) $slug = str_slug($request->get('title'));
            $app->title = $request->get('title');
            $app->slug = $slug;
            $app->screenshots = json_encode($count_s);
            $app->category = $this->cate[$request->get('category')];
            $app->score = $request->get('score');
            $app->developer = $request->get('developer');
            $app->installs = $request->get('installs');
            $app->five = $request->get('five');
            $app->four = $request->get('four');
            $app->three = $request->get('three');
            $app->two = $request->get('two');
            $app->one = $request->get('one');
            $app->releasedTimestamp = $request->get('releasedTimestamp');
            $app->updatedTimestamp = $request->get('updatedTimestamp');
            $app->numberVoters = $request->get('numberVoters');
            $app->url = $request->get('url_download');
            $app->votes = $request->get('votes');
            $appdata->title = $request->get('title');
            $appdata->description = $request->get('description');
            $appdata->slug = $slug;
            $appdata->appid = $id;
            $appdata->summary = $request->get('summary');
            $appdata->recentChange = $request->get('recentChange');
            $appdata->size = $request->get('size');
            $appdata->appVersion = $request->get('appVersion');
            $appdata->androidVersion = $request->get('androidVersion');
            $appdata->locale = $this->lang;
            $appdata->country = $this->country;

            $app->save();
            $appdata->save();
            //$appdata->update(['title' => $appdata->title]);
            DB::commit();
            // Clear cache
            Cache::flush();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

        // Redirect to application edit page
        return redirect()->route('apps.edit', $app->appid)->with('success', 'Update ' . $appdata->title . ' Successful!!!');
    }

    public function show($id)
    {

    }

    public function createplay(Request $request)
    {
        if (Auth::user()->email == 'demo@iapk.site') {
            return redirect()->back()->with("error", 'Demo acount only view.');
        }
        if ($request->ajax()) {
            $id = $request->appid;
            $appdata = Application::where('appid', $id)->first();
            if ($appdata == null) {
                $gplay = new GPlayApps();
                $gplay
                    ->setDefaultLocale($this->lang)
                    ->setDefaultCountry($this->country);
                if ($gplay->existsApp($id)) {
                    $app = $gplay->getAppInfo($id);
                    $app = json_decode(json_encode($app), true);
                    $app['description'] = nl2br(e($app['description']));
                    $app['score'] = round($app['score'], 1);
                    $appinsert = new Application;
                    $appdata = new AppsInfo;
                    DB::beginTransaction();
                    try {
                        $filename = $id . '.png';
                        $location = public_path('images/' . $filename);
                        Image::make($app['icon'])->resize(200, 200)->save($location);
                        $appinsert->cover = $filename;
                        $count_s = [];
                        if (isset($app['screenshots']) && count($app['screenshots']) > 0) {
                            if ($this->screenshot_save->value == 1) {
                                foreach ($app['screenshots'] as $k => $v) {
                                    $filename = $id . '_' . $k . '.jpg';
                                    $count_s[] = asset('public/images/') . '/' . $filename;
                                    Image::make($v)->save(public_path('images/' . $filename));
                                }
                            } else $count_s = $app['screenshots'];
                        }
                        $slug = Str::slug($app['name'], '-');
                        if (empty($slug)) $slug = str_slug($app['name']);
                        $appinsert->title = $app['name'];
                        $appinsert->slug = $slug;
                        $appinsert->appid = $id;
                        $appinsert->screenshots = json_encode($count_s);
                        $appinsert->category = $this->cate[$app['category']['id']];
                        $appinsert->score = $app['score'];
                        $appinsert->developer = (!empty($app['developer']['name'])) ? $app['developer']['name'] : $app['developer']['id'];
                        $appinsert->installs = $app['installs'];
                        $appinsert->five = $app['histogramRating']['five'];
                        $appinsert->four = $app['histogramRating']['four'];
                        $appinsert->three = $app['histogramRating']['three'];
                        $appinsert->two = $app['histogramRating']['two'];
                        $appinsert->one = $app['histogramRating']['one'];
                        $appinsert->releasedTimestamp = $app['releasedTimestamp'];
                        $appinsert->updatedTimestamp = $app['updatedTimestamp'];
                        $appinsert->numberVoters = $app['numberVoters'];
                        $appdata->title = $app['name'];
                        $appdata->description = $app['description'];
                        $appdata->slug = $slug;
                        $appdata->appid = $id;
                        $appdata->summary = $app['summary'];
                        $appdata->recentChange = $app['recentChange'];
                        $appdata->size = $app['size'];
                        $appdata->appVersion = $app['appVersion'];
                        $appdata->androidVersion = $app['androidVersion'];
                        $appdata->locale = $this->lang;
                        $appdata->country = $this->country;

                        $appinsert->save();
                        $appdata->save();
                        DB::commit();
                        $data['message'] = 'Successful!';
                        $data['status'] = true;
                    } catch (\Exception $e) {
                        DB::rollback();
                        $data['message'] = $e->getMessage();
                        $data['status'] = false;
                    }
                } else {
                    $data['message'] = 'App not found!';
                    $data['status'] = false;
                }
            } else {
                $data['message'] = 'Already exists!';
                $data['status'] = false;
            }

            $data['appid'] = $id;
            return $data;
        }
    }

    /** Remove the specified resource from storage. */
    public function destroy(Request $request)
    {
        if (Auth::user()->email == 'demo@iapk.site') {
            return response()->json([
                'status' => false,
                'message' => 'Demo acount only view.'
            ]);
        }
        if ($request->ajax()) {
            $id = $request->id;
            $app = Application::where('appid', $id)->first();
            if (!empty($app->cover)) {
                if (file_exists(public_path() . '/images/' . $app->cover)) {
                    @unlink(public_path() . '/images/' . $app->cover);
                }
            }
            if (!empty($app->screenshots)) {
                $screenshots = json_decode($app->screenshots);
                foreach ($screenshots as $v) {
                    if (file_exists(public_path() . '/images/' . $v)) {
                        @unlink(public_path() . '/images/' . $v);
                    }
                }
            }
            Application::where('appid', $id)->delete();
            AppsInfo::where('appid', $id)->delete();
            // Clear cache
            Cache::flush();
            return response()->json([
                'status' => true,
                'message' => 'Data deleted successfully!'
            ]);
        }
    }

    public function apkupload(Request $request)
    {
        if (Auth::user()->email == 'demo@iapk.site') {
            echo 'Demo acount only view.';
            die;
        }
        if ($request->hasFile('apkfile')) {
            $apk = $request->file('apkfile');
            $filename = time() . '.' . $apk->getClientOriginalExtension();
            if ($apk->getClientOriginalExtension() != 'apk') {
                echo "Apk file invalid!";
            } else {
                if ($apk->move(public_path() . '/apk/', $filename)) {
                    echo $filename;
                }
            }
        }

    }

}
