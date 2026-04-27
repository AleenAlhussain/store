<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Application;
use App\AppsInfo;
use App\Category;
use App\Page;
use App\Setting;
use App\Slider;
use App\Toppics;
use App\Translation;
use Demowebtv\GPlay\GPlayApps;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;
use Illuminate\Support\Facades\App;
class SiteController extends Controller
{
    private $country;
    private $lang;
    private $cate_time;
    private $site;

    public function __construct()
    {

        $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
        $seting_country = Setting::where('name', 'default_country')->first()->value;
        $seting_lang = Setting::where('name', 'default_language')->first()->value;
        App::setLocale($seting_lang);
        $this->country = $seting_country;
        $this->lang = $seting_lang;
        setcookie('lang', $seting_lang, time() + 60 * 60 * 24 * 365, '/', $domain);
        setcookie('country', $seting_country, time() + 60 * 60 * 24 * 365, '/', $domain);
        $this->cate_time = env('APP_CAHCE_TIME');
        $pages = Page::where('local', $this->lang)->orderBy('sort', 'ASC')->get();
        if (count($pages) <= 0) {
            $pages = Page::where('local', 'en')->orderBy('sort', 'ASC')->get();
        }
        $ads = Ad::orderBy('title', 'asc')->get();
        $ad = [];
        foreach ($ads as $r) {
            $ad[$r->title] = $r->code;
        }
        $this->site = 'iapk';
        View::share(['pages' => $pages, 'ad' => $ad]);
    }

    public function index()
    {
      $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
      $seting_lang = Setting::where('name', 'default_language')->first()->value;
      $seting_country = Setting::where('name', 'default_country')->first()->value;
      setcookie('lang', $seting_lang, time() + 60 * 60 * 24 * 365, '/', $domain);
      setcookie('country', $seting_country, time() + 60 * 60 * 24 * 365, '/', $domain);
        $content = Cache::remember($this->site . 'home_index' . '_' . $this->country . '_' . $this->lang, $this->cate_time, function () {
            $toppics = [];
            $toppic = Toppics::where('status', 1)->where('home', 1)->where('local', $this->lang)->orderBy('sort', 'ASC')->limit('4')->get();
            if (count($toppic) <= 0) $toppic = Toppics::where('status', 1)->where('home', 1)->where('local', 'en')->orderBy('sort', 'ASC')->limit('4')->get();
            // $toppic = Toppics::where('status', 1)->where('home', 1)->where('local', $this->lang)->get();
            foreach ($toppic as $j => $top) {
                $appid = explode(',', $top->apps);
                $toppics[$j]['title'] = $top->title;
                $toppics[$j]['slug'] = $top->slug;
                $toppics[$j]['id'] = $top->id;
                //$appid = array_reverse($appid);
                //dd($appid);
                foreach ($appid as $k => $app) {
                    if ($k < 18) {
                        $info = AppsInfo::where('appid', $app)->where('locale', $this->lang)->first();
                        $apps = Application::where('appid', $app)->first();
                        if ($apps != NULL) {
                            $toppics[$j]['data'][$k]['id'] = $app;
                            $toppics[$j]['data'][$k]['cover'] = $apps->cover;
                            $toppics[$j]['data'][$k]['title'] = empty($info->title) ? $apps->title : $info->title;
                            $toppics[$j]['data'][$k]['slug'] = empty($info->slug) ? $apps->slug : $info->slug;
                            $toppics[$j]['data'][$k]['score'] = $apps->score;
                        }
                    }
                }
            }
            $sliders = Slider::orderBy('sort', 'ASC')->get();
            $content['slider'] = $sliders;
            $content['toppics'] = $toppics;
            return $content;
        });
        return view('site.index', ['toppic' => $content['toppics'], 'sliders' => $content['slider']]);
    }

    public function detail($name, $id)
    {
        if(isset($_GET['xoaapp'])){
            $txt = file_get_contents(base_path('app.txt'));
            $txt .=','.$id;
            @file_put_contents(base_path('app.txt'), stripslashes($txt));
        }
        $txt = @file_get_contents(base_path('app.txt'));
        $noapp = explode(',',$txt);
        if(in_array($id,$noapp)){
            return view('home.error');
        }
        $content = Cache::remember($this->site . 'detail' . $id . '_' . $this->country . '_' . $this->lang, $this->cate_time, function () use ($id, $name) {
            $app = [];
            $catecahce = Cache::get('iapkget_cate_name' . $this->country . '_' . $this->lang);
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
                }
            } else {
                $cate = $this->getCate($appdata->category);
                $app['id'] = $appdata->appid;
                $app['url'] = $appdata->url;
                $app['developer']['name'] = $appdata->developer;
                $app['icon'] = asset('public/images/') . '/' . $appdata->cover;
                $app['score'] = $appdata->score;
                $app['screenshots'] = json_decode($appdata->screenshots);
                $app['category']['id'] = $cate->slug;
                $app['category']['name'] = ($catecahce) ? $catecahce[$cate->slug] : $cate->title;
                $app['installs'] = $appdata->installs;
                $app['numberVoters'] = $appdata->numberVoters;
                $app['histogramRating']['five'] = $appdata->five;
                $app['histogramRating']['four'] = $appdata->four;
                $app['histogramRating']['three'] = $appdata->three;
                $app['histogramRating']['two'] = $appdata->two;
                $app['histogramRating']['one'] = $appdata->one;
                $app['releasedTimestamp'] = $appdata->releasedTimestamp;
                $app['updatedTimestamp'] = $appdata->updatedTimestamp;
                $app['reviews'] = [];
                $appinfo = AppsInfo::where('appid', $id)->where('locale', $this->lang)->first();
                if ($appinfo == null) {
                    $gplay = new GPlayApps();
                    $gplay
                        ->setDefaultLocale($this->lang)
                        ->setDefaultCountry($this->country);
                    if ($gplay->existsApp($id)) {
                        $data = $gplay->getAppInfo($id);
                        $data = json_decode(json_encode($data), true);
                        $data['description'] = nl2br(e($data['description']));
                        DB::beginTransaction();
                        try {
                            $appinfo = new AppsInfo;
                            $slug = Str::slug($data['name'], '-');
                            if (empty($slug)) $slug = str_slug($data['name']);
                            $appinfo->title = $data['name'];
                            $appinfo->description = $data['description'];
                            $appinfo->slug = $slug;
                            $appinfo->appid = $data['id'];
                            $appinfo->summary = $data['summary'];
                            $appinfo->recentChange = $data['recentChange'];
                            $appinfo->size = $data['size'];
                            $appinfo->appVersion = $data['appVersion'];
                            $appinfo->androidVersion = $data['androidVersion'];
                            $appinfo->locale = $this->lang;
                            $appinfo->country = $this->country;
                            $appinfo->save();
                            DB::commit();
                        } catch (\Exception $e) {
                            DB::rollback();
                        }
                    } else {
                        $appinfo = AppsInfo::where('appid', $id)->first();
                    }
                }
                $app['name'] = $appinfo->title;
                $app['summary'] = $appinfo->summary;
                $app['description'] = $appinfo->description;
                $app['recentChange'] = $appinfo->recentChange;
                $app['size'] = $appinfo->size;
                $app['appVersion'] = $appinfo->appVersion;
                $app['androidVersion'] = $appinfo->androidVersion;
            }
            $content['app'] = $app;
            return $content;
        });
        if (!isset($content['app']['id'])) {
            return view('site.error');
        }
        return view('site.detail', ['app' => $content['app']]);
    }

    public function download($name, $id)
    {
        $txt = @file_get_contents(base_path('app.txt'));
        $noapp = explode(',',$txt);
        if(in_array($id,$noapp)){
            return view('home.error');
        }
        $content = Cache::remember($this->site . 'detail' . $id . '_' . $this->country . '_' . $this->lang, $this->cate_time, function () use ($id, $name) {
            $gplay = new GPlayApps();
            $gplay
                ->setDefaultLocale($this->lang)
                ->setDefaultCountry($this->country);
            $gplay->setCacheTtl(\DateInterval::createFromDateString('24 hour'));
            if ($gplay->existsApp($id)) {
                $app = $gplay->getAppInfo($id);

                $app = json_decode(json_encode($app), true);
            } else {
                $app = [];

            }
            $content['app'] = $app;
            return $content;
        });
        if (!isset($content['app']['id'])) {
            return view('site.error');
        }
        return view('site.download', ['app' => $content['app']]);
    }

    public function downloading($id)
    {
        $txt = @file_get_contents(base_path('app.txt'));
        $noapp = explode(',',$txt);
        if(in_array($id,$noapp)){
            return view('home.error');
        }
        $appdata = Application::where('appid', $id)->first();
        if ($appdata !== null && !empty($appdata->url)) {
            return redirect($appdata->url);
        }
        $url = 'https://apkstore.biz/downloader/?appid=' . $id;
        $data = file_get_contents($url);
        $datas = explode(',', $data);
        if (count($datas) > 0 && $datas[0] == 'success') {
            // header('Content-Description: File Transfer');
            // header('Content-Type: application/vnd.android.package-archive');
            // header('Content-Disposition: attachment; filename="'.$id.'.apk"');
            // header('Expires: 0');
            // header("Content-Length: ".$datas['1']);
            // header('Cache-Control: must-revalidate');
            // header('Pragma: public');
            // readfile(trim($datas['2']));
            return redirect(trim($datas['2']));
        } else {
            return redirect('https://play.google.com/store/apps/details?id=' . $id);
        }
    }

    public function search()
    {
        return view('site.search');
    }

    public function page($slug)
    {
        $page = Page::where('slug', $slug)->first();
        return view('site.page', ['page' => $page]);
    }

    public function toppic()
    {
        $toppic = Toppics::where('local', $this->lang)->orderBy('sort', 'ASC')->paginate(30);
        return view('site.toppic', ['toppic' => $toppic]);
    }

    public function toppicDetail($slug)
    {
        $toppic = Toppics::where('slug', $slug)->first();
        $appid = explode(',', $toppic->apps);
        $title = $toppic->title;
        $list = [];
        if (count($appid) > 0) {
            foreach ($appid as $k => $app) {
                $info = AppsInfo::where('appid', $app)->where('locale', $this->lang)->first();
                $apps = Application::where('appid', $app)->first();
                if ($apps != NULL) {
                    $list[$app]['appid'] = $app;
                    $list[$app]['cover'] = $apps->cover;
                    $list[$app]['title'] = empty($info->title) ? $apps->title : $info->title;
                    $list[$app]['slug'] = empty($info->slug) ? $apps->slug : $info->slug;
                    $list[$app]['score'] = $apps->score;
                }
            }
        }
        return view('site.toppicDetail', ['apps' => $list, 'title' => $title]);

    }

    public function category($cat)
    {
        $cat = strtoupper($cat);
        $cat = str_replace('-', '_', $cat);
        $currentPage = request()->get('page', 1);
        $cate = Category::where('slug', $cat)->first();
        $content = Cache::remember($this->site . 'category' . $cat . '_' . $this->country . '_' . $this->lang . '_page' . $currentPage, $this->cate_time, function () use ($cat, $cate) {
            $apps = Application::where('category', $cate->id)->orderBy('id', 'desc')->paginate(50);
//            $apps = DB::table("applications")
//                ->select("applications.*",
//                    DB::raw("(SELECT apps_info.title FROM apps_info
//                                WHERE apps_info.appid = applications.appid AND apps_info.country='" . $this->country . "') as stitle"))
//                ->where('applications.category', $cate->id)
//                ->orderBy('id', 'desc')->paginate(50);
            return $apps;
        });

        return view('site.category', ['apps' => $content, 'title' => $cate->title]);
    }

    public function top($name)
    {
        $content = Cache::remember($this->site . 'list_top_100' . $name . '_' . $this->country . '_' . $this->lang, $this->cate_time, function () use ($name) {
            $gplay = new GPlayApps();
            $gplay
                ->setDefaultLocale($this->lang)
                ->setDefaultCountry($this->country);
            if ($name == 'games') {
                $apps = $gplay->getTopApps(\Demowebtv\GPlay\Enum\CategoryEnum::GAME(), null, 100);
            } else {
                $apps = $gplay->getTopApps(null, null, 100);
            }

            return $apps;
        });

        return view('site.top', ['search' => $content, 'title' => $name]);
    }

    public function new($name)
    {
        $content = Cache::remember($this->site . 'list_new_100' . $name . '_' . $this->country . '_' . $this->lang, $this->cate_time, function () use ($name) {
            $gplay = new GPlayApps();
            $gplay
                ->setDefaultLocale($this->lang)
                ->setDefaultCountry($this->country);
            if ($name == 'games') {
                $apps = $gplay->getNewApps(\Demowebtv\GPlay\Enum\CategoryEnum::GAME(), null, 100);
            } else {
                $apps = $gplay->getNewApps(null, null, 100);
            }

            return $apps;
        });

        return view('site.new', ['search' => $content, 'title' => $name]);
    }

    private function getCate($id)
    {
        return DB::table('categories')->where('id', $id)->first();
    }
}
