<?php

namespace App\Providers;

use App\Http\Controllers\SettingController;
use App\Translation;
use App\Setting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //\URL::forceScheme('https');
        Schema::defaultStringLength(191);
        $translations = Translation::orderBy('language', 'ASC')->get();
        $site = Setting::orderBy('id', 'desc')->get();
        foreach ($site as $setting) {
            $setting_data[$setting->name] = $setting->value;
        }
        $domain = (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
        if (!isset($_COOKIE['country'])) {
            setcookie('country', $setting_data['default_country'], time() + 60 * 60 * 24 * 365, '/', $domain);
        }
        if (!isset($_COOKIE['lang'])) {
            setcookie('lang', $setting_data['default_language'], time() + 60 * 60 * 24 * 365, '/', $domain);
        }
        if (isset($_COOKIE['lang'])) {
            $local = $_COOKIE['lang'];
        } else $local = $setting_data['default_language'];

        App::setLocale($local);
        $country = isset($_COOKIE['country']) ? $_COOKIE['country'] : $setting_data['default_country'];
        $lang = isset($_COOKIE['lang']) ? $_COOKIE['lang'] : $setting_data['default_language'];
        $language = Translation::where('locale_code', $country)->pluck('language', 'locale_code');
        $languages = Translation::pluck('language', 'code');
        $dlang = Translation::where('locale_code', $setting_data['default_country'])->pluck('language', 'locale_code');
        View::share(['translations' => $translations, 'site' => $setting_data, 'country' => $country, 'dlang' => $dlang,'lang' => $lang, 'language' => $language,'languages' => $languages]);
    }
}
