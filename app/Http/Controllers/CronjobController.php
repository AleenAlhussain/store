<?php

namespace App\Http\Controllers;

use App\Application;
use App\AppsInfo;
use App\Category;
use App\Setting;
use App\Toppics;
use App\Translation;
use Demowebtv\GPlay\GPlayApps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class CronjobController extends Controller
{
    private $cate;

    public function __construct()
    {
        $this->cate = DB::table('categories')->pluck('id', 'slug');

    }

    public function appCate()
    {
        $cates = Category::get();
        $site_lang = Translation::get();
        foreach ($cates as $r) {
            $cat = $r->slug;
            foreach ($site_lang as $lang) {
                $gplay = new GPlayApps();
                $gplay
                    ->setDefaultLocale($lang->code)
                    ->setDefaultCountry($lang->locale_code);
                $apps = $gplay->getListApps(\Demowebtv\GPlay\Enum\CategoryEnum::$cat());
                foreach ($apps as $id=>$game) {
                    $this->createplay($id, $lang->locale_code, $lang->code);
                }
            }
        }
        dd('done');
    }

    public function insertApps()
    {
        $site_lang = Translation::get();
        foreach ($site_lang as $r) {
            $gplay = new GPlayApps();
            $gplay->setDefaultLocale($r->code)
                ->setDefaultCountry($r->locale_code);
            $topGame = $gplay->getTopApps(\Demowebtv\GPlay\Enum\CategoryEnum::GAME(), null, 20);
            $topApp = $gplay->getTopApps(null, null, 20);
            $newGame = $gplay->getNewApps(\Demowebtv\GPlay\Enum\CategoryEnum::GAME(), null, 20);
            $newApp = $gplay->getNewApps(null, null, 20);
            $listGametop = [];
            $listApptop = [];
            $listGamenew = [];
            $listAppnew = [];
            foreach ($topGame as $game) {
                $game = json_decode(json_encode($game), true);
                $slug = Str::slug($game['name'], '-');
                if (empty($slug)) $slug = str_slug($game['name']);
                $listGametop[] = $game['id'];
                $id = $this->createplay($game['id'], $r->locale_code, $r->code);
                echo 'inserted ' . $id;
            }
            echo $this->createToppic('Top Games', 'Top Games', $listGametop, $r->code);
            foreach ($topApp as $game) {
                $game = json_decode(json_encode($game), true);
                $slug = Str::slug($game['name'], '-');
                if (empty($slug)) $slug = str_slug($game['name']);
                $listApptop[] = $game['id'];
                $id = $this->createplay($game['id'], $r->locale_code, $r->code);
                echo 'inserted ' . $id;
            }
            echo $this->createToppic('Top Apps', 'Top Apps', $listApptop, $r->code);
            foreach ($newGame as $game) {
                $game = json_decode(json_encode($game), true);
                $slug = Str::slug($game['name'], '-');
                if (empty($slug)) $slug = str_slug($game['name']);
                $listGamenew[] = $game['id'];
                $id = $this->createplay($game['id'], $r->locale_code, $r->code);
                echo 'inserted ' . $id;
            }
            echo $this->createToppic('New Games', 'New Games', $listGamenew, $r->code);
            foreach ($newApp as $game) {
                $game = json_decode(json_encode($game), true);
                $slug = Str::slug($game['name'], '-');
                if (empty($slug)) $slug = str_slug($game['name']);
                $listAppnew[] = $game['id'];
                $id = $this->createplay($game['id'], $r->locale_code, $r->code);
                echo 'inserted ' . $id;
            }
            echo $this->createToppic('New Apps', 'New Apps', $listAppnew, $r->code);
        }
    }

    private function createToppic($title, $detail, $list, $lang)
    {
        $list = implode(',', $list);
        $page = new Toppics;
        $page->title = $title;
        $page->details = $detail;
        $page->status = 1;
        $page->slug = null;
        $page->local = $lang;
        $page->apps = $list;
        $page->home = '1';
        $page->sort = Toppics::max('sort') + 1;
        $page->images = 'default-image.png';
        $page->save();
        $page->update(['title' => $page->title]);
        return true;
    }

    private function createplay($id, $country, $lang)
    {
        $appdata = Application::where('appid', $id)->first();
        if ($appdata == null) {
            $gplay = new GPlayApps();
            $gplay->setDefaultLocale($lang)
                ->setDefaultCountry($country);
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
                        $count_s = $app['screenshots'];
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
                    $appdata->locale = $lang;
                    $appdata->country = $country;

                    $appinsert->save();
                    $appdata->save();
                    DB::commit();
                    return $id;
                } catch (\Exception $e) {
                    DB::rollback();
                    return false;
                }
            }
        } else {
            if (AppsInfo::where('appid', $id)->where('country', $country)->count() <= 0) {
                $gplay = new GPlayApps();
                $gplay
                    ->setDefaultLocale($lang)
                    ->setDefaultCountry($country);
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
                        $data->locale = $lang;
                        $data->country = $country;
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
