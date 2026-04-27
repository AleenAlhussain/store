<?php

namespace App\Http\Controllers;

use App\Application;
use App\AppsInfo;
use App\Setting;
use App\Translation;
use Illuminate\Http\Request;
use Demowebtv\GPlay\GPlayApps;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\ImageManagerStatic as Image;


class DataController extends Controller
{
    private $country;
    private $lang;
    private $cate_time;
    private $cate;
    private $screenshot_save;
    private $search_in;
    private $site;

    public function __construct()
    {
        $seting_country = Setting::where('name', 'default_country')->first()->value;
        $seting_lang = Setting::where('name', 'default_language')->first()->value;
        $this->country = $seting_country;
        $this->lang = $seting_lang;
        $this->cate_time = env('APP_CAHCE_TIME');
        $this->cate = DB::table('categories')->pluck('id', 'slug');
        $this->screenshot_save = Setting::where('name', 'screenshot_save')->first();
        $this->search_in = Setting::where('name', 'search_in')->first();
        $this->site = 'iapk';
    }

    public function getData(Request $request)
    {
        $country = $this->country;
        $lang = $this->lang;
        $cate_time = $this->cate_time;
        if ($request->ajax()) {
            $output = '';
            if ($request->key == 'categories') {
                $content = Cache::rememberForever('data'.$this->lang . $this->site . $request->key . '-' . $request->val . '-' . $country . '_' . $lang, function () use ($request, $output, $country, $lang) {
                    $gplay = new GPlayApps();
                    $gplay->setDefaultLocale($lang)
                        ->setDefaultCountry($country);
                    $categories = $gplay->getCategories();
                    if ($request->val == 'app') {
                        $cate = [];
                        foreach ($categories as $cat) {
                            $cat = json_decode(json_encode($cat), true);
                            $cate[$cat['id']] = $cat['name'];
                            if (strpos($cat['id'], 'GAME') === false) {
                                $cat_url = strtolower($cat['id']);
                                $cat_url = str_replace('_', '-', $cat_url);
                                $output .= ' <li><a href="' . route('site.category', [$cat_url]) . '" title="' . $cat['name'] . '"><i class="' . strtolower(str_replace('_', '-', str_replace(['_AND', 'FAMYLY_', 'FAMILY_'], '', $cat['id']))) . '"></i>' . $cat['name'] . '</a></li>';
                            }
                        }
                        Cache::put($this->site . 'get_cate_name' . $country . '_' . $lang, $cate);
                    } else {
                        foreach ($categories as $cat) {
                            $cat = json_decode(json_encode($cat), true);
                            if (strpos($cat['id'], 'GAME') !== false && $cat['id'] !== 'GAME') {
                                $cat_url = strtolower($cat['id']);
                                $cat_url = str_replace('_', '-', $cat_url);
                                $output .= ' <li><a href="' . route('site.category', [$cat_url]) . '" title="' . $cat['name'] . '"><i class="' . strtolower(str_replace('GAME_', '', $cat['id'])) . '"></i>' . $cat['name'] . '</a></li>';
                            }
                        }
                    }
                    return $output;
                });
            } else {
                $content = Cache::remember('data'.$this->lang . $this->site . $request->key . '_' . $request->val . '_' . $country . '_' . $lang, $cate_time, function () use ($request, $output, $country, $lang) {
                    $gplay = new GPlayApps();
                    $gplay->setDefaultLocale($lang)
                        ->setDefaultCountry($country);

                    if ($request->key == 'top') {
                        if ($request->val == 'game') {
                            $topGame = $gplay->getTopApps(\Demowebtv\GPlay\Enum\CategoryEnum::GAME(), null, 5);
                            $i = 0;
                            foreach ($topGame as $top) {
                                $i++;
                                $top = json_decode(json_encode($top), true);
                                $slug = Str::slug($top['name'], '-');
                                if (empty($slug)) $slug = str_slug($top['name']);
                                $output .= '<li>
                                                <div class="hot_day_img_number">
                                                    <div class="hot_day_number">' . $i . '</div>
                                                    <div class="hot_day_img">
                                                        <a title="' . $top['name'] . ' APK"
                                                           href="' . route('site.detail', [$slug, $top['id']]) . '">
                                                            <img alt="' . $top['name'] . '" src="' . $top['icon'] . '"  width="60px" height="60px">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="description">
                                                    <h3>
                                                        <a title="' . $top['name'] . ' APK"
                                                           href="' . route('site.detail', [$slug, $top['id']]) . '">' . $top['name'] . '</a>
                                                    </h3>
                                                    <p class="rating_info">votes <span class="rating"><span
                                                                class="average">' . round($top['score'], 1) . '</span>/<span
                                                                class="best">5</span></span></p>
                                                    <div class="down_btn">
                                                        <p>Download ' . $top['name'] . '</p>
                                                        <a href="' . route('site.detail', [$slug, $top['id']]) . '"
                                                           class="btn btn_down" title="Download ' . $top['name'] . '">
                                                            ' . __('web.installapk') . '
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>';
                            }
                        } else {
                            $topApp = $gplay->getTopApps(null, null, 5);
                            $i = 0;
                            foreach ($topApp as $top) {
                                $i++;
                                $top = json_decode(json_encode($top), true);
                                $slug = Str::slug($top['name'], '-');
                                if (empty($slug)) $slug = str_slug($top['name']);
                                $output .= '<li>
                                                <div class="hot_day_img_number">
                                                    <div class="hot_day_number">' . $i . '</div>
                                                    <div class="hot_day_img">
                                                        <a title="' . $top['name'] . ' APK"
                                                           href="' . route('site.detail', [$slug, $top['id']]) . '">
                                                            <img alt="' . $top['name'] . '" src="' . $top['icon'] . '" width="60px" height="60px">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="description">
                                                    <h3>
                                                        <a title="' . $top['name'] . ' APK"
                                                           href="' . route('site.detail', [$slug, $top['id']]) . '">' . $top['name'] . '</a>
                                                    </h3>
                                                    <p class="rating_info">votes <span class="rating"><span
                                                                class="average">' . round($top['score'], 1) . '</span>/<span
                                                                class="best">5</span></span></p>
                                                    <div class="down_btn">
                                                        <p>Download ' . $top['name'] . '</p>
                                                        <a href="' . route('site.detail', [$slug, $top['id']]) . '"
                                                           class="btn btn_down" title="Download ' . $top['name'] . '">
                                                            ' . __('web.installapk') . '
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>';
                            }
                        }
                    }
                    if ($request->key == 'footer') {
                        if ($request->val == 'game') {
                            $topGame = $gplay->getTopApps(\Demowebtv\GPlay\Enum\CategoryEnum::GAME(), null, 10);
                            foreach ($topGame as $top) {
                                $top = json_decode(json_encode($top), true);
                                $slug = Str::slug($top['name'], '-');
                                if (empty($slug)) $slug = str_slug($top['name']);
                                $output .= '<li><a title="' . $top['name'] . ' APK"  href="' . route('site.detail', [$slug, $top['id']]) . '">' . $top['name'] . '</a></li>';
                            }
                        } else {
                            $topApp = $gplay->getTopApps(null, null, 10);
                            foreach ($topApp as $top) {
                                $top = json_decode(json_encode($top), true);
                                $slug = Str::slug($top['name'], '-');
                                if (empty($slug)) $slug = str_slug($top['name']);
                                $output .= '<li><a title="' . $top['name'] . ' APK"  href="' . route('site.detail', [$slug, $top['id']]) . '">' . $top['name'] . '</a></li>';
                            }
                        }
                    }
                    if ($request->key == 'site.op') {
                        if ($request->val == 'game') {
                            $topGame = $gplay->getTopApps(\Demowebtv\GPlay\Enum\CategoryEnum::GAME(), null, 15);
                            $i = 0;
                            foreach ($topGame as $top) {
                                $i++;
                                $top = json_decode(json_encode($top), true);
                                $slug = Str::slug($top['name'], '-');
                                if (empty($slug)) $slug = str_slug($top['name']);
                                $output .= '';
                                $output .= '<li class="col-sm-4 col-xs-6 product_item" >
                            <div class="product_img" >
                                <a title = "' . $top['name'] . '"
                                   href = "' . route('site.detail', [$slug, $top['id']]) . '" >
                                    <img alt = "' . $top['name'] . '" src = "' . $top['icon'] . '" >
                                </a >
                            </div >
                            <div class="description" >
                                <h3 >
                                    <a title = "' . $top['name'] . '"
                                       href = "' . route('site.detail', [$slug, $top['id']]) . '" >' . $top['name'] . '</a >
                                </h3 >
                                <div class="stars" >
                                    <span title = "' . $top['name'] . ' average rating ' . $top['score'] . '"
                                          style = "width:' . (((int)$top['score'] / 5) * 100) . '%;" ></span >
                                </div >
                                <div class="rating_info" > votes <span class="rating" ><span class="average" >' . round($top['score'], 1) . '</span >/<span
                                            class="best" > 5</span ></span ></div >
                                <div class="down_btn" >
                                    <p > Download ' . $top['name'] . '</p >
                                    <a href = "' . route('site.detail', [$slug, $top['id']]) . '"
                                       class="btn btn_down" title = "Download ' . $top['name'] . '" > ' . __('web.installapk') . ' </a >
                                </div >
                            </div >
                        </li >';
                            }
                        } else {
                            $topApp = $gplay->getTopApps(null, null, 15);
                            $i = 0;
                            foreach ($topApp as $top) {
                                $i++;
                                $top = json_decode(json_encode($top), true);
                                $slug = Str::slug($top['name'], '-');
                                if (empty($slug)) $slug = str_slug($top['name']);
                                $output .= '';
                                $output .= '<li class="col-sm-4 col-xs-6 product_item" >
                            <div class="product_img" >
                                <a title = "' . $top['name'] . '"
                                   href = "' . route('site.detail', [$slug, $top['id']]) . '" >
                                    <img alt = "' . $top['name'] . '" src = "' . $top['icon'] . '" >
                                </a >
                            </div >
                            <div class="description" >
                                <h3 >
                                    <a title = "' . $top['name'] . '"
                                       href = "' . route('site.detail', [$slug, $top['id']]) . '" >' . $top['name'] . '</a >
                                </h3 >
                                <div class="stars" >
                                    <span title = "' . $top['name'] . ' average rating ' . $top['score'] . '"
                                          style = "width:' . (((int)$top['score'] / 5) * 100) . '%;" ></span >
                                </div >
                                <div class="rating_info" > votes <span class="rating" ><span class="average" >' . round($top['score'], 1) . '</span >/<span
                                            class="best" > 5</span ></span ></div >
                                <div class="down_btn" >
                                    <p > Download ' . $top['name'] . '</p >
                                    <a href = "' . route('site.detail', [$slug, $top['id']]) . '"
                                       class="btn btn_down" title = "Download ' . $top['name'] . '" > ' . __('web.installapk') . ' </a >
                                </div >
                            </div >
                        </li >';
                            }
                        }
                    }
                    if ($request->key == 'site.ew') {
                        if ($request->val == 'game') {
                            $topGame = $gplay->getNewApps(\Demowebtv\GPlay\Enum\CategoryEnum::GAME(), null, 15);
                            $i = 0;
                            foreach ($topGame as $top) {
                                $i++;
                                $top = json_decode(json_encode($top), true);
                                $slug = Str::slug($top['name'], '-');
                                if (empty($slug)) $slug = str_slug($top['name']);
                                $output .= '';
                                $output .= '<li class="col-sm-4 col-xs-6 product_item" >
                            <div class="product_img" >
                                <a title = "' . $top['name'] . '"
                                   href = "' . route('site.detail', [$slug, $top['id']]) . '" >
                                    <img alt = "' . $top['name'] . '" src = "' . $top['icon'] . '" >
                                </a >
                            </div >
                            <div class="description" >
                                <h3 >
                                    <a title = "' . $top['name'] . '"
                                       href = "' . route('site.detail', [$slug, $top['id']]) . '" >' . $top['name'] . '</a >
                                </h3 >
                                <div class="stars" >
                                    <span title = "' . $top['name'] . ' average rating ' . $top['score'] . '"
                                          style = "width:' . (((int)$top['score'] / 5) * 100) . '%;" ></span >
                                </div >
                                <div class="rating_info" > votes <span class="rating" ><span class="average" >' . round($top['score'], 1) . '</span >/<span
                                            class="best" > 5</span ></span ></div >
                                <div class="down_btn" >
                                    <p > Download ' . $top['name'] . '</p >
                                    <a href = "' . route('site.detail', [$slug, $top['id']]) . '"
                                       class="btn btn_down" title = "Download ' . $top['name'] . '" > ' . __('web.installapk') . ' </a >
                                </div >
                            </div >
                        </li >';
                            }
                        } else {
                            $topApp = $gplay->getNewApps(null, null, 15);
                            $i = 0;
                            foreach ($topApp as $top) {
                                $i++;
                                $top = json_decode(json_encode($top), true);
                                $slug = Str::slug($top['name'], '-');
                                if (empty($slug)) $slug = str_slug($top['name']);
                                $output .= '';
                                $output .= '<li class="col-sm-4 col-xs-6 product_item" >
                            <div class="product_img" >
                                <a title = "' . $top['name'] . '"
                                   href = "' . route('site.detail', [$slug, $top['id']]) . '" >
                                    <img alt = "' . $top['name'] . '" src = "' . $top['icon'] . '" >
                                </a >
                            </div >
                            <div class="description" >
                                <h3 >
                                    <a title = "' . $top['name'] . '"
                                       href = "' . route('site.detail', [$slug, $top['id']]) . '" >' . $top['name'] . '</a >
                                </h3 >
                                <div class="stars" >
                                    <span title = "' . $top['name'] . ' average rating ' . $top['score'] . '"
                                          style = "width:' . (((int)$top['score'] / 5) * 100) . '%;" ></span >
                                </div >
                                <div class="rating_info" > votes <span class="rating" ><span class="average" >' . round($top['score'], 1) . '</span >/<span
                                            class="best" > 5</span ></span ></div >
                                <div class="down_btn" >
                                    <p > Download ' . $top['name'] . '</p >
                                    <a href = "' . route('site.detail', [$slug, $top['id']]) . '"
                                       class="btn btn_down" title = "Download ' . $top['name'] . '" > ' . __('web.installapk') . ' </a >
                                </div >
                            </div >
                        </li >';
                            }
                        }
                    }
                    if ($request->key == 'similar') {
                        $similarApps = $gplay->getSimilarApps($request->val, 12);
                        $output = '';
                        foreach ($similarApps as $top) {
                            $top = json_decode(json_encode($top), true);
                            $slug = Str::slug($top['name'], '-');
                            if (empty($slug)) $slug = str_slug($top['name']);
                            $output .= '<li class="col-sm-4 col-xs-6 product_item" >
                                        <div class="product_img" >
                                            <a title="Digital World"
                                               href ="' . route('site.detail', [$slug, $top['id']]) . '" >
                                                <img alt = "Digital World" src = "' . $top['icon'] . '" >
                                            </a >
                                        </div >
                                        <div class="description" >
                                            <h3 >
                                                <a title="' . $top['name'] . '"
                                                   href="' . route('site.detail', [$slug, $top['id']]) . '" >' . $top['name'] . '</a >
                                            </h3 >
                                            <div class="stars" >
                                                <span title="' . $top['name'] . ' average rating ' . round($top['score'], 1) . '"
                                                      style="width:' . (((int)$top['score'] / 5) * 100) . '%;" ></span >
                                            </div >
                                            <div class="rating_info">votes <span class="rating"><span
                                            class="average">' . round($top['score'], 1) . '</span>/<span
                                            class="best">5</span></span></div>
                                            <div class="down_btn" >
                                                <p> Download ' . $top['name'] . '</p >
                                                <a href ="' . route('site.detail', [$slug, $top['id']]) . '" class="btn btn_down" title = "Download ' . $top['name'] . '" >' . __('web.installapk') . '</a >
                                            </div>
                                        </div >
                                    </li >';
                        }
                    }
                    if ($request->key == 'developer') {
                        $apps = $gplay->getDeveloperApps($request->val);
                        $output = '';
                        foreach ($apps as $top) {
                            $top = json_decode(json_encode($top), true);
                            $slug = Str::slug($top['name'], '-');
                            if (empty($slug)) $slug = str_slug($top['name']);
                            $output .= '<li class="col-sm-4 col-xs-6 product_item" >
                                        <div class="product_img" >
                                            <a title = "Digital World"
                                               href = "' . route('site.detail', [$slug, $top['id']]) . '" >
                                                <img alt = "Digital World" src = "' . $top['icon'] . '" >
                                            </a >
                                        </div >
                                        <div class="description" >
                                            <h3 >
                                                <a title = "' . $top['name'] . '"
                                                   href="' . route('site.detail', [$slug, $top['id']]) . '" >' . $top['name'] . '</a >
                                            </h3 >
                                            <div class="stars" >
                                                <span title = "' . $top['name'] . ' average rating ' . round($top['score'], 1) . '"
                                                      style = "width:' . (((int)$top['score'] / 5) * 100) . '%;" ></span >
                                            </div >
                                            <div class="rating_info">votes <span class="rating"><span
                                            class="average">' . round($top['score'], 1) . '</span>/<span
                                            class="best">5</span></span></div>
                                            <div class="down_btn" >
                                                <p > Download ' . $top['name'] . '</p >
                                                <a href ="' . route('site.detail', [$slug, $top['id']]) . '" class="btn btn_down" title = "Download ' . $top['name'] . '" >' . __('web.installapk') . '</a >
                                            </div >
                                        </div >
                                    </li >';
                        }
                    }
                    if ($request->key == 'developer') {
                        $apps = $gplay->getDeveloperApps($request->val);
                        $output = '';
                        foreach ($apps as $top) {
                            $top = json_decode(json_encode($top), true);
                            $slug = Str::slug($top['name'], '-');
                            if (empty($slug)) $slug = str_slug($top['name']);
                            $output .= '<li class="col-sm-4 col-xs-6 product_item" >
                                        <div class="product_img" >
                                            <a title = "Digital World"
                                               href = "' . route('site.detail', [$slug, $top['id']]) . '" >
                                                <img alt = "Digital World" src = "' . $top['icon'] . '" >
                                            </a >
                                        </div >
                                        <div class="description" >
                                            <h3 >
                                                <a title = "' . $top['name'] . '"
                                                   href = "' . route('site.detail', [$slug, $top['id']]) . '" >' . $top['name'] . '</a >
                                            </h3 >
                                            <div class="stars" >
                                                <span title = "' . $top['name'] . ' average rating ' . round($top['score'], 1) . '"
                                                      style = "width:' . (((int)$top['score'] / 5) * 100) . '%;" ></span >
                                            </div >
                                            <div class="rating_info">votes <span class="rating"><span
                                            class="average">' . round($top['score'], 1) . '</span>/<span
                                            class="best">5</span></span></div>
                                            <div class="down_btn" >
                                                <p > Download ' . $top['name'] . '</p >
                                                <a href="' . route('site.detail', [$slug, $top['id']]) . '" class="btn btn_down" title = "Download ' . $top['name'] . '" >' . __('web.installapk') . '</a >
                                            </div >
                                        </div >
                                    </li >';
                        }
                    }
                    $content = $output;
                    return $content;
                });
            }
            return $content;
        }
    }

    public function getSearch(Request $request)
    {
        $country = $this->country;
        $lang = $this->lang;
        $cate_time = $this->cate_time;
        $search_cf = $this->search_in->value;
        if ($request->ajax()) {
            $content = Cache::remember('data'.$this->site . $search_cf . $request->q . '_' . $country . '_' . $lang, $cate_time, function () use ($request, $country, $lang, $search_cf) {
                $output = '';
                if ($search_cf == 'play') {
                    $gplay = new GPlayApps();
                    $gplay
                        ->setDefaultLocale($lang)
                        ->setDefaultCountry($country);
                    $search = $gplay->search(
                        $query = $request->q,
                        $limit = 60);
                    $output .= '<ul class="product_list clearfix">';
                    foreach ($search as $top) {
                        $top = json_decode(json_encode($top), true);
                        $slug = Str::slug($top['name'], '-');
                        if (empty($slug)) $slug = str_slug($top['name']);
                        $output .= '<li class="col-sm-5ths col-xs-6">
                                <div class="product_item">
                                  <div class="product_img">
                                    <a title="' . $top['name'] . '" href="' . route('site.detail', [$slug, $top['id']]) . '">
                                      <img alt="' . $top['name'] . '" src="' . $top['icon'] . '">
                                    </a>
                                  </div>
                                  <div class="description">
                                    <h3>
                                      <a title="' . $top['name'] . '" href="' . route('site.detail', [$slug, $top['id']]) . '">' . $top['name'] . '</a>
                                    </h3>
                                    <div class="down_btn">
                                      <a href="' . route('site.detail', [$slug, $top['id']]) . '" class="btn btn_down" title="Download ' . $top['name'] . '">
                                        ' . __('web.installapk') . '
                                    </a>
                                    </div>
                                  </div>
                                </div>
                              </li>';
                    }
                    $output .= '</ul>';
                } else {
                    if ($request->q !== '') {
                        $apps = DB::table("applications")
                            ->select("applications.*",
                                DB::raw("(SELECT apps_info.title FROM apps_info
                                WHERE apps_info.appid = applications.appid AND apps_info.country='" . $country . "') as stitle"))
                            ->where('applications.title', 'LIKE', "%$request->q%")
                            ->orWhere('applications.appid', '=', $request->q)
                            ->orderBy('id', 'desc')->limit(60)->get()->toArray();
                        //$apps = Application::where('title', 'LIKE', "%$request->q%")->orWhere('appid', '=', $request->q)->orderBy('id', 'desc')->limit(60)->get()->toArray();
                    } else {
                        $apps = Application::orderBy('id', 'desc')->limit(60)->get()->toArray();
                    }
                    $output .= '<ul class="product_list clearfix">';
                    foreach ($apps as $top) {
                        $top = json_decode(json_encode($top), true);
                        $top['title'] = !empty($top['stitle']) ? $top['stitle'] : $top['title'];
                        $output .= '<li class="col-sm-5ths col-xs-6">
                                <div class="product_item">
                                  <div class="product_img">
                                    <a title="' . $top['title'] . '" href="' . route('site.detail', [$top['slug'], $top['appid']]) . '">
                                      <img alt="' . $top['title'] . '" src="' . asset('public/images/') . '/' . $top['cover'] . '">
                                    </a>
                                  </div>
                                  <div class="description">
                                    <h3>
                                      <a title="' . $top['title'] . '" href="' . route('site.detail', [$top['slug'], $top['appid']]) . '">' . $top['title'] . '</a>
                                    </h3>
                                    <div class="down_btn">
                                      <a href="' . route('site.detail', [str_slug($top['title'], '-'), $top['appid']]) . '" class="btn btn_down" title="Download ' . $top['title'] . '">
                                        ' . __('web.installapk') . '
                                    </a>
                                    </div>
                                  </div>
                                </div>
                              </li>';
                    }
                    $output .= '</ul>';
                }
                return $output;
            });
            return $content;
        }
    }

    public function getApps(Request $request)
    {
        $country = $this->country;
        $lang = $this->lang;
        $cate_time = $this->cate_time;
        $limit = isset($request->limit) ? $request->limit : 100;
        if ($request->ajax()) {
            $content = Cache::remember('data'.$this->site . 'getApps_' . $limit . $request->type . $request->q . '_' . $country . '_' . $lang, $cate_time, function () use ($request, $country, $lang, $limit) {
                $output = '';
                $gplay = new GPlayApps();
                $gplay
                    ->setDefaultLocale($lang)
                    ->setDefaultCountry($country);
                $q = empty($request->q) ? Null : $request->q;
                if ($request->type == 'cate_top') {
                    $search = $gplay->getTopApps(
                        $q,
                        null,
                        $limit);
                } elseif ($request->type == 'cate_new') {
                    $search = $gplay->getNewApps(
                        $q,
                        null,
                        $limit);
                } else {
                    if ($q != null)
                        $search = $gplay->search(
                            $q,
                            $limit);
                    else $search = [];

                }
                $output .= '<table class="table table-striped mb-5">
                    <thead>
                    <tr>
                        <th><label><input type="checkbox" id="select-all" value="all" class="i-checks"></label></th>
                        <th>Cover</th>
                        <th>AppId</th>
                        <th>Name</th>
                    </tr>
                    </thead>
                    <tbody>';
                foreach ($search as $top) {
                    $top = json_decode(json_encode($top), true);
                    $output .= '<tr>
                        <td class="col-md-1">
                            <label id="' . $top['id'] . '"><input type="checkbox"  value="' . $top['id'] . '" class="i-checks"></label>
                        </td>
                        <td class="col-md-2"><img src="' . $top['icon'] . '" style="max-width: 50px;" /></td>
                        <td class="col-md-3"><a target="_blank" href="https://play.google.com/store/apps/details?id=' . $top['id'] . '">' . $top['id'] . '</a></td >
                        <td class="col-md-6">' . $top['name'] . '</td >
                    </tr>';
                }
                $output .= '</tbody>
                </table>';
                return $output;
            });
            return $content;
        }
    }

    public function updateApp(Request $request)
    {
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
                    } catch (\Exception $e) {
                        DB::rollback();
                    }
                }
            } else {
                if (AppsInfo::where('appid', $id)->where('country', $this->country)->count() <= 0) {
                    $gplay = new GPlayApps();
                    $gplay
                        ->setDefaultLocale($this->lang)
                        ->setDefaultCountry($this->country);
                    if ($gplay->existsApp($id)) {
                        $app = $gplay->getAppInfo($id);
                        $app = json_decode(json_encode($app), true);
                        $app['description'] = nl2br(e($app['description']));
                        $app['score'] = round($app['score'], 1);
                        $data = new AppsInfo;
                        DB::beginTransaction();
                        try {
                            $slug = Str::slug($app['name'], '-');
                            if (empty($slug)) $slug = str_slug($app['name']);
                            $data->title = $app['name'];
                            $data->description = $app['description'];
                            $data->slug = $slug;
                            $data->appid = $id;
                            $data->summary = $app['summary'];
                            $data->recentChange = $app['recentChange'];
                            $data->size = $app['size'];
                            $data->appVersion = $app['appVersion'];
                            $data->androidVersion = $app['androidVersion'];
                            $data->locale = $this->lang;
                            $data->country = $this->country;
                            $data->save();
                            DB::commit();
                        } catch (\Exception $e) {
                            DB::rollback();
                        }
                    }
                }
            }
        }
    }
}
