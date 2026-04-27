<?php

namespace App\Http\Middleware;

use App\Setting;
use App\Translation;
use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $seting_lang = Setting::where('name', 'default_language')->first()->value;
        $code = Translation::where('code', '!=', $seting_lang)->pluck('code')->toArray();
        $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
        if (in_array($request->segment(1), $code)) {
            $country = Translation::where('code', $request->segment(1))->first()->locale_code;
            setcookie('lang', $request->segment(1), time() + 60 * 60 * 24 * 365, '/', $domain);
            setcookie('country', $country, time() + 60 * 60 * 24 * 365, '/', $domain);
            app()->setLocale($request->segment(1));
            App::setLocale($request->segment(1));
        } else {
            abort(404);
        }
        return $next($request);
    }
}
