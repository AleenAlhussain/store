<!doctype html>
<html class="no-js') }}" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('content_header') {{$site['site_title']}}</title>

    <meta name="description" content="{{$site['site_description']}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
		============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/theme/images/favicon.png') }}">
    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/bootstrap.min.css') }}">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/font-awesome.min.css') }}">
    <!-- owl.carousel CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/owl.transitions.css') }}">
    <!-- meanmenu CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/meanmenu/meanmenu.min.css') }}">
    <!-- animate CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/summernote/summernote.css') }}">
    <!-- Range Slider CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/themesaller-forms.css') }}">

    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/normalize.css') }}">
    <!-- mCustomScrollbar CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/scrollbar/jquery.mCustomScrollbar.min.css') }}">
    <!-- jvectormap CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/jvectormap/jquery-jvectormap-2.0.3.css') }}">
    <!-- notika icon CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/notika-custom-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/bootstrap-select/bootstrap-select.css') }}">
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/datapicker/datepicker3.css') }}">
    <!-- Color Picker CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/color-picker/farbtastic.css') }}">
    <!-- main CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/chosen/chosen.css') }}">
    <!-- notification CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/notification/notification.css') }}">
    <!-- dropzone CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/image-upload/image-uploader.min.css') }}">
    <!-- wave CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/wave/waves.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/dialog/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/dialog/dialog.css') }}">
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/wave/button.css') }}">
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/jquery.dataTables.min.css') }}">
    <!-- main CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/main.css') }}">
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('public/theme/backend/style.css') }}">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="{{ asset('public/theme/backend/css/responsive.css') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- modernizr JS
		============================================ -->
    <script src="{{ asset('public/theme/backend/js/vendor/modernizr-2.8.3.min.js') }}"></script>
</head>

<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->
<!-- Start Header Top Area -->
<div class="header-top-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="logo-area">
                    <a href="{{ url('/admin') }}"> <img style="max-height: 30px;"
                                                        alt="{{ config('app.name', 'Laravel') }}"
                                                        src="{{ asset('public/theme/images/admin_logo.png') }}"></a>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="header-top-menu">
                    <ul class="nav navbar-nav notika-top-nav">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"
                               style="font-size: 18px;"> {{$language[$_COOKIE['country']]}}
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                @foreach($translations as $row)
                                    @if($row->locale_code !=$_COOKIE['country'])
                                        <li @php if(isset($_COOKIE['country']) && $_COOKIE['country']==$row->locale_code) echo 'class="active"'; @endphp>
                                            <a href="{{ route('home.lang', [$row->code,$row->locale_code]) }}">{{$row->language}}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a
                                target="_blank" style="color: #FFF;font-size: 18px;" href="{{ url('/') }}"><i
                                    class="notika-icon notika-alarm"></i> View Site</a>
                        </li>
                        <!-- Authentication Links -->
                        <li class="nav-item">
                            @if(\Illuminate\Support\Facades\Auth::guard('admin')->check())

                                <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                   style="padding-left: 10px;font-size: 18px;"
                                   onclick="event.preventDefault();
                                                     document.getElementById('admin-logout-form').submit();">
                                    <i class="notika-icon notika-support"></i> {{ __('Logout') }}
                                </a>

                                <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            @else
                                <a class="dropdown-item" href="{{ route('user.logout') }}"
                                   style="padding-left: 10px;font-size: 18px;"
                                   onclick="event.preventDefault();
                                                     document.getElementById('user-logout-form').submit();">
                                    <i class="notika-icon notika-support"></i> {{ __('Logout') }}
                                </a>

                                <form id="user-logout-form" action="{{ route('user.logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Header Top Area -->
<!-- Mobile Menu start -->
<div class="mobile-menu-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="mobile-menu">
                    <nav id="dropdown">
                        <ul class="mobile-menu-nav">
                            <li><a href="{{action('AdminController@index')}}">Home</a>
                            </li>
                            <li><a data-toggle="collapse" data-target="#Appviewsmb"
                                   href="{{action('ApplicationController@index')}}">Apps</a>
                                <ul id="Appviewsmb" class="collapse dropdown-header-top">
                                    <li><a href="{{action('ApplicationController@index')}}">All Apps</a>
                                    </li>
                                    <li><a href="{{action('ApplicationController@create')}}">New App</a>
                                    </li>

                                </ul>
                            </li>
                            <li><a data-toggle="collapse" data-target="#languagemb"
                                   href="{{action('TranslationController@index')}}">Language</a>
                                <ul id="languagemb" class="collapse dropdown-header-top">
                                    <li><a href="{{action('TranslationController@index')}}">List Language</a></li>
                                    <li><a href="{{action('TranslationController@index')}}">Create New</a></li>
                                </ul>
                            </li>
                            <li><a data-toggle="collapse" data-target="#Pagemob"
                                   href="{{action('PageController@index')}}">Pages</a>
                                <ul id="Pagemob" class="collapse dropdown-header-top">
                                    <li><a href="{{action('PageController@index')}}">All Page</a>
                                    </li>
                                    <li><a href="{{action('PageController@create')}}">Create Page</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a data-toggle="collapse" data-target="#settingb"
                                   href="{{action('SettingController@index')}}">Setting</a>
                                <ul id="settingb" class="collapse dropdown-header-top">
                                    <li><a href="{{action('SettingController@index')}}">Site Configurations</a>
                                    </li>
                                    <li><a href="{{action('SettingController@accountsettingsform')}}">Admin
                                            Configurations</a>
                                    </li>
                                    <li><a href="{{action('SettingController@genSitemap')}}">
                                            GenSiteMap</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Mobile Menu end -->
<!-- Main Menu area start-->
<div class="main-menu-area mg-tb-40">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro">
                    <li class="{{ (\Request::is('admin')) ? 'active' : '' }}">
                        <a href="{{action('AdminController@index')}}"><i class="notika-icon notika-house"></i> Home</a>
                    </li>
                    <li class="{{ (\Request::is('admin/apps/*') || \Request::is('admin/apps') || \Request::is('admin/playstore')) ? 'active' : '' }}">
                        <a href="{{action('ApplicationController@index')}}"><i class="notika-icon notika-app"></i> Apps</a>
                    </li>
                    <li class="{{ (\Request::is('admin/translations/*') || \Request::is('admin/translations')) ? 'active' : '' }}">
                        <a href="{{action('TranslationController@index')}}"><i class="notika-icon notika-edit"></i>
                            Language</a>
                    </li>
                    <li class="{{ (\Request::is('admin/pages/*') || \Request::is('admin/pages')) ? 'active' : '' }}">
                        <a href="{{action('PageController@index')}}"><i class="notika-icon notika-windows"></i>
                            Pages</a>
                    </li>
                    <li class="{{ (\Request::is('admin/sliders/*') || \Request::is('admin/sliders')) ? 'active' : '' }}">
                        <a href="{{action('SliderController@index')}}"><i class="notika-icon notika-credit-card"></i>
                            Sliders</a>
                    </li>
                    <li class="{{ (\Request::is('admin/toppics/*') || \Request::is('admin/toppics')) ? 'active' : '' }}">
                        <a href="{{action('ToppicsController@index')}}"><i
                                class="notika-icon notika-file"></i>Toppics</a>
                    </li>
                    <li class="{{ (\Request::is('admin/ads/*') || \Request::is('admin/ads')) ? 'active' : '' }}">
                        <a href="{{action('AdController@index')}}"><i class="notika-icon notika-dollar"></i>Advertisement</a>
                    </li>
                    <li class="{{ (\Request::is('admin/account_settings') || \Request::is('admin/settings')) ? 'active' : '' }}">
                        <a data-toggle="tab" href="#settings"><i class="notika-icon notika-settings"></i> Setting</a>
                    </li>
                </ul>
                <div class="tab-content custom-menu-content">
                    <div id="Home"
                         class="tab-pane {{ (\Request::is('admin')) ? 'in active' : '' }} notika-tab-menu-bg animated flipInX">
                        <ul class="notika-main-menu-dropdown">
                            <li><a href="{{action('AdminController@index')}}">Dashboard</a>
                            </li>
                        </ul>
                    </div>
                    <div id="Appviews"
                         class="tab-pane {{ (\Request::is('admin/apps/*') || \Request::is('admin/apps') || \Request::is('admin/playstore')) ? 'in active' : '' }} notika-tab-menu-bg animated flipInX">
                        <ul class="notika-main-menu-dropdown">
                            <li><a href="{{action('ApplicationController@index')}}">All Apps</a>
                            </li>
                            <li><a href="{{action('ApplicationController@create')}}">New App</a>
                            </li>
                            <li><a href="{{action('ApplicationController@playstore')}}">New Apps From Google Play</a>
                            </li>
                        </ul>
                    </div>
                    <div id="language"
                         class="tab-pane {{ (\Request::is('admin/translations/*') || \Request::is('admin/translations')) ? 'in active' : '' }} notika-tab-menu-bg animated flipInX">
                        <ul class="notika-main-menu-dropdown">
                            <li><a href="{{action('TranslationController@index')}}">List Language</a>
                            </li>
                            <li><a href="{{action('TranslationController@create')}}">New Language</a>
                            </li>
                        </ul>
                    </div>

                    <div id="Page"
                         class="tab-pane  {{ (\Request::is('admin/pages/*') || \Request::is('admin/pages')) ? 'in active' : '' }} notika-tab-menu-bg animated flipInX">
                        <ul class="notika-main-menu-dropdown">
                            <li><a href="{{action('PageController@index')}}">All Page</a>
                            </li>
                            <li><a href="{{action('PageController@create')}}">Create Page</a>
                            </li>
                        </ul>
                    </div>
                    <div id="settings"
                         class="tab-pane  {{ (\Request::is('admin/account_settings') || \Request::is('admin/settings') || \Request::is('admin/genSitemap')) ? 'in active' : '' }} notika-tab-menu-bg animated flipInX">
                        <ul class="notika-main-menu-dropdown">
                            <li><a href="{{action('SettingController@index')}}">Site Configurations</a>
                            </li>
                            <li><a href="{{action('SettingController@accountsettingsform')}}">Admin Configurations</a>
                            </li><li><a href="{{action('SettingController@genSitemap')}}">Gen Sitemaps</a>
                            </li>
                        </ul>
                    </div>
                    <div id="slider"
                         class="tab-pane  {{ (\Request::is('admin/sliders/*') || \Request::is('admin/sliders')) ? 'in active' : '' }} notika-tab-menu-bg animated flipInX">
                        <ul class="notika-main-menu-dropdown">
                            <li><a href="{{action('SliderController@index')}}">All Slider</a>
                            </li>
                            <li><a href="{{action('SliderController@create')}}">Create Slider</a>
                            </li>
                        </ul>
                    </div>
                    <div id="ad"
                         class="tab-pane {{ (\Request::is('admin/toppics') || \Request::is('admin/toppics/*')) ? 'in active' : '' }} notika-tab-menu-bg animated flipInX">
                        <ul class="notika-main-menu-dropdown">
                            <li><a href="{{action('ToppicsController@index')}}">All Toppics</a>
                            </li>
                            <li><a href="{{action('ToppicsController@create')}}">Create Toppic</a>
                            </li>
                        </ul>
                    </div>
                    <div id="ad"
                         class="tab-pane {{ (\Request::is('admin/ads') || \Request::is('admin/ads/*')) ? 'in active' : '' }} notika-tab-menu-bg animated flipInX">
                        <ul class="notika-main-menu-dropdown">
                            <li><a href="{{action('AdController@index')}}">Advertisement Informations</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main Menu area End-->
@yield('content')
<!-- Start Footer area-->
<div class="footer-copyright-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="footer-copy-right">
                    <p>Copyright © 2021
                        . All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Footer area-->
<!-- jquery
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/vendor/jquery-1.12.4.min.js') }}"></script>

<!-- bootstrap JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/bootstrap.min.js') }}"></script>
<!-- wow JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/wow.min.js') }}"></script>
<!-- price-slider JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/jquery-price-slider.js') }}"></script>
<!-- owl.carousel JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/owl.carousel.min.js') }}"></script>
<!-- scrollUp JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/jquery.scrollUp.min.js') }}"></script>
<!-- meanmenu JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/meanmenu/jquery.meanmenu.js') }}"></script>
<!-- counterup JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/counterup/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('public/theme/backend/js/counterup/waypoints.min.js') }}"></script>
<script src="{{ asset('public/theme/backend/js/counterup/counterup-active.js') }}"></script>
<!-- mCustomScrollbar JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<!-- jvectormap JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('public/theme/backend/js/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('public/theme/backend/js/jvectormap/jvectormap-active.js') }}"></script>
<!-- sparkline JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('public/theme/backend/js/sparkline/sparkline-active.js') }}"></script>
<!-- sparkline JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('public/theme/backend/js/flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('public/theme/backend/js/flot/curvedLines.js') }}"></script>
<script src="{{ asset('public/theme/backend/js/flot/flot-active.js') }}"></script>
<!-- datapicker JS
      ============================================ -->
<script src="{{ asset('public/theme/backend/js/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('public/theme/backend/js/datapicker/datepicker-active.js') }}"></script>
<!-- bootstrap select JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/bootstrap-select/bootstrap-select.js') }}"></script>
<!--  color-picker JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/color-picker/farbtastic.min.js') }}"></script>
<script src="{{ asset('public/theme/backend/js/color-picker/color-picker.js') }}"></script>
<!--  notification JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/notification/bootstrap-growl.min.js') }}"></script>
<script src="{{ asset('public/theme/backend/js/notification/notification-active.js') }}"></script>
<!--  summernote JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/summernote/summernote-updated.min.js') }}"></script>
<script src="{{ asset('public/theme/backend/js/summernote/summernote-active.js') }}"></script>
<!-- dropzone JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/image-upload/image-uploader.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!--  chosen JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/chosen/chosen.jquery.js') }}"></script>
<!-- knob JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/knob/jquery.knob.js') }}"></script>
<script src="{{ asset('public/theme/backend/js/knob/jquery.appear.js') }}"></script>
<script src="{{ asset('public/theme/backend/js/knob/knob-active.js') }}"></script>
<!--  wave JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/wave/waves.min.js') }}"></script>
<script src="{{ asset('public/theme/backend/js/wave/wave-active.js') }}"></script>
<!--  todo JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/todo/jquery.todo.js') }}"></script>
<script src="{{ asset('public/theme/backend/js/dialog/sweetalert2.min.js') }}"></script>
<script src="{{ asset('public/theme/backend/js/dialog/dialog-active.js') }}"></script>
<!-- plugins JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/plugins.js') }}"></script>
<script src="{{ asset('public/theme/backend/js/data-table/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/theme/backend/js/data-table/data-table-act.js') }}"></script>
<!--  Chat JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/chat/moment.min.js') }}"></script>
<script src="{{ asset('public/theme/backend/js/chat/jquery.chat.js') }}"></script>
<!-- main JS
    ============================================ -->
<script src="{{ asset('public/theme/backend/js/main.js') }}"></script>
@yield('scripts')
<script>function ChangeLanguage(selected) {
        alert(selected.value()); // Do whatever you want in here.
    }
</script>
</body>

</html>
