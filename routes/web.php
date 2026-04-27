<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Site route
Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => '[a-zA-Z]{2}'],
    'middleware' => 'setlocale'], function () {
    Route::get('/', 'HomeController@index')->name('home.index');
    Route::get('/detail/{name}/{id}', 'HomeController@detail')->name('home.detail');
    Route::get('/category/{name}', 'HomeController@category')->name('home.category');
    Route::get('/top/{name}', 'HomeController@top')->name('home.top');
    Route::get('/new/{name}', 'HomeController@new')->name('home.new');
    Route::get('/page/{name}', 'HomeController@page')->name('home.page');
    Route::get('/search', 'HomeController@search')->name('home.search');
    Route::post('/getData', 'AjaxController@getData')->name('ajax.getData');
    Route::post('/getSearch', 'AjaxController@getSearch')->name('ajax.getSearch');
    Route::post('/updateApp', 'AjaxController@updateApp')->name('ajax.updateApp');
    Route::get('/download/{name}/{id}', 'HomeController@download')->name('home.download');
    Route::get('/downloading/{id}', 'HomeController@downloading')->name('home.downloading');
    Route::get('/toppics', 'HomeController@toppic')->name('home.toppic');
    Route::get('/toppic/{slug}', 'HomeController@toppicDetail')->name('home.toppicDetail');
});
Route::get('/lang/{local}/{country}', 'HomeController@lang')->name('home.lang');
Route::get('/', 'SiteController@index')->name('site.index');
Route::get('/detail/{name}/{id}', 'SiteController@detail')->name('site.detail');
Route::get('/category/{name}', 'SiteController@category')->name('site.category');
Route::get('/top/{name}', 'SiteController@top')->name('site.top');
Route::get('/new/{name}', 'SiteController@new')->name('site.new');
Route::get('/page/{name}', 'SiteController@page')->name('site.page');
Route::get('/search', 'SiteController@search')->name('site.search');
Route::get('/download/{name}/{id}', 'SiteController@download')->name('site.download');
Route::get('/downloading/{id}', 'SiteController@downloading')->name('site.downloading');
Route::get('/toppics', 'SiteController@toppic')->name('site.toppic');
Route::get('/toppic/{slug}', 'SiteController@toppicDetail')->name('site.toppicDetail');
Route::post('/getData', 'DataController@getData')->name('data.getData');
Route::post('/getSearch', 'DataController@getSearch')->name('data.getSearch');
Route::post('/updateApp', 'DataController@updateApp')->name('data.updateApp');
//admin route
Auth::routes();
Route::prefix('admin')->group(function () {
    // Dashboard route
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    // Login routes
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    // Logout route
    Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    // Register routes
    Route::get('/register', 'Auth\AdminRegisterController@showRegistrationForm')->name('admin.register');
    Route::post('/register', 'Auth\AdminRegisterController@register')->name('admin.register.submit');
    // Password reset routes
    Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset')->name('admin.password.update');
    //Route::get('/apps', 'ApplicationController@index')->name('admin.apps');
    Route::resource('/apps', 'ApplicationController');
    Route::get('/apps', 'ApplicationController@index')->name('admin.apps');
    Route::get('/playstore', 'ApplicationController@playstore')->name('admin.play');
    Route::get('/get_ajax_data', 'ApplicationController@get_ajax_data')->name('admin.getappdata');
    Route::get('/get_data_toppic', 'ApplicationController@get_data_toppic')->name('admin.getapptoppic');
    Route::get('/get_app_info', 'ApplicationController@get_app_info')->name('admin.getappid');
    Route::delete('/delete/{id}', 'ApplicationController@destroy')->name('apps.destroy');
    Route::post('/getApps', 'AjaxController@getApps')->name('ajax.getApps');
    Route::post('/createplay', 'ApplicationController@createplay')->name('apps.createplay');
    Route::resource('/translations', 'TranslationController');
    Route::resource('/pages', 'PageController');
    Route::resource('/toppics', 'ToppicsController');
    Route::get('/pageorder', 'PageController@order');
    Route::get('/toppicsorder', 'ToppicsController@order');
    Route::post('/toppicsgetapps', 'ToppicsController@getapps');
    Route::get('/settings', 'SettingController@index');
    Route::post('/settings', 'SettingController@update');
    Route::get('/account_settings', 'SettingController@accountsettingsform');
    Route::post('/account_settings', 'SettingController@accountsettings')->name('accountsettings');
    Route::resource('/news', 'NewsController');
    Route::resource('/ads', 'AdController');
    Route::resource('/sliders', 'SliderController');
    Route::get('/slidersort', 'SliderController@order');
    Route::post('/apkupload', 'ApplicationController@apkupload')->name('admin.apkupload');
    Route::get('/sitemap', 'SettingController@siteMap')->name('admin.siteMap');
    Route::get('/genSitemap', 'SettingController@genSitemap')->name('admin.genSitemap');

});
