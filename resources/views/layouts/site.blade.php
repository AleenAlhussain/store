<!DOCTYPE html>
<html lang="{{$lang}}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/theme/images/favicon.png') }}">
    <meta name="keywords" content="">
    <meta name="robots" content="index,follow"/>
    <!-- <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon"> -->
    <!-- ===== Style CSS ===== -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/theme/css/style.css') }}">
    <!-- ===== Responsive CSS ===== -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/theme/css/responsive.css') }}">
    {!! $site['before_head_tag'] !!}
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "WebSite",
            "name": "APKStore",
            "url": "{{url('/')}}",
            "potentialAction": {
                "@type": "SearchAction",
                "target": "{{url('/')}}/search?q={search_term_string}",
                "query-input": "required name=search_term_string"
            }
        }
    </script>
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "Corporation",
            "name": "APKStore",
            "url": "{{url('/')}}",
            "logo": "{{url('/')}}/public/theme/images/logo.png"
        }
    </script>
</head>
<body>
{!! $site['after_head_tag'] !!}
<div class="wrapper">

    <header class="block header fixed">
        <div class="container">
            <div class="block_logo">
                <a href="{{ route('site.index') }}" title="{{$site['site_title']}}">
                    <img alt="{{ config('app.name', 'Laravel') }}" src="{{ asset('public/theme/images/logo.png') }}">
                </a>
            </div><!-- /block-logo -->
            <div class="block_search_top">
                <div class="block_search">
                    <form action="{{ route('site.search') }}" method="GET" class="form_search">
                        <input type="text" name="q" class="search_input"
                               placeholder="Enter App Name, Package Name, Package ID" required="">
                        <button type="submit" class="btn_search"><i class="fa fa-search"></i></button>
                    </form>
                </div><!-- /block_search -->
            </div><!-- /block_search_top-logo -->
            <div class="block_menu_top">
                <div class="nav-toogle">
                    <i class="fa"></i>
                </div>
                <ul class="nav_menu">
                    <li class="nav_menu_item">
                        <a title="hot game" href="{{ route('site.index') }}"><i class="fa fa-site.
                                                                                style="font-size:20px;color:#ec2c3e"></i> {{ __('web.home') }}
                        </a>
                    </li>
                    <li class="nav_menu_item">
                        <a title="hot game" href="{{ route('site.toppic') }}"><i class="fa fa-archive"
                                                                                 style="font-size:20px;color:#ec2c3e"></i> {{ __('web.Toppic') }}
                        </a>
                    </li>
                    <li class="nav_menu_item parent">
                        <a title="select country" href="javascript:void(0);"><i class="fa fa-globe"
                                                                                style="font-size:20px;color:#ec2c3e"></i> {{$dlang[$site['default_country']]}}
                        </a>
                        <ul class="nav_submenu">
                            @foreach($translations as $row)
                                @if($row->locale_code !=$site['default_country'])
                                    <li>
                                        <a @php if($country==$row->locale_code) echo 'class="active"'; @endphp href="{{ route('home.lang', [$row->code,$row->locale_code]) }}">{{$row->language}}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                </ul>

            </div><!-- /block_menu_top-logo -->
        </div>
    </header><!-- /header -->

    <main id="main" class="container">
        <div class="row">
            @yield('content')
            <div class="block_right col-sm-3 col-xs-12">
                <div class="block block_sidebar block_search-tags">
                    <div class="block_pad">
                        <div class="block_content">
                            <div class="block_search">
                                <form action="{{ route('site.search') }}" method="GET" class="form_search">
                                    <input type="text" name="q" class="search_input"
                                           placeholder="Enter App Name, Package Name, Package ID" required="">
                                    <button type="submit" class="btn_search"><i class="fa fa-search"></i></button>
                                </form>

                            </div><!-- /block_search -->
                            {{--                            <div class="block_tags">--}}
                            {{--                                <a href="{{ route('site.search') }}?q=lucky">lucky</a>--}}
                            {{--                                <a href="{{ route('site.search') }}?q=youtube">youtube</a>--}}
                            {{--                                <a href="{{ route('site.search') }}?q=gta">gta</a>--}}
                            {{--                                <a href="{{ route('site.search') }}?q=snapchat">snapchat</a>--}}
                            {{--                                <a href="{{ route('site.search') }}?q=brawl stars">brawl stars</a>--}}
                            {{--                                <a href="{{ route('site.search') }}?q=pokemon">pokemon</a>--}}
                            {{--                                <a href="{{ route('site.search') }}?q=instagram">instagram</a>--}}
                            {{--                                <a href="{{ route('site.search') }}?q=gta san andreas">gta san andreas</a>--}}
                            {{--                                <a href="{{ route('site.search') }}?q=minecraft pocket edition">minecraft pocket--}}
                            {{--                                    edition</a>--}}
                            {{--                                <a href="{{ route('site.search') }}?q=clash royale">clash royale</a>--}}
                            {{--                                <a href="{{ route('site.search') }}?q=google play services">google play services</a>--}}
                            {{--                                <a href="{{ route('site.search') }}?q=리니지m">리니지m</a>--}}
                            {{--                                <a href="{{ route('site.search') }}?q=facebook">facebook</a>--}}
                            {{--                            </div><!-- /block_tags -->--}}
                        </div>
                    </div><!-- block_search-tags -->
                </div><!-- block_sidebar -->
                <div class="block">{!! $ad['above_right_column'] !!}</div>
                <div class="block block_sidebar block_hot_day">
                    <div class="blokck_pad_content">
                        <div class="block_title block_tab">
                            TOP »
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#Game" aria-controls="Game" role="tab"
                                                                          data-toggle="tab">{{ __('web.games') }}</a>
                                </li>
                                <li role="presentation"><a href="#Apps" aria-controls="Apps" role="tab"
                                                           data-toggle="tab">{{ __('web.apps') }}</a></li>
                            </ul>
                        </div>
                        <div class="block_content clearfix">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="Game">
                                    <ul class="hot_day_list" id="topgame">
                                    </ul>
                                    <div class="block_more"><a
                                                href="{{ route('site.top', ['games']) }}">{{ __('web.more') }} »</a>
                                    </div>
                                </div><!-- Game -->
                                <div role="tabpanel" class="tab-pane" id="Apps">
                                    <ul class="hot_day_list" id="topapp">
                                    </ul>
                                    <div class="block_more"><a
                                                href="{{ route('site.top', ['apps']) }}">{{ __('web.more') }} »</a>
                                    </div>
                                </div><!-- Apps -->

                            </div>
                        </div>
                    </div>
                </div><!-- block_sidebar -->
                <div class="block block_sidebar block_popular_categories">
                    <div class="blokck_pad_content">
                        <div class="block_title">
                            <div class="title">{{ __('web.gamescate') }}</div>
                            {{ csrf_field() }}
                        </div>
                        <div class="block_content clearfix">
                            <ul class="popular_categories_list location" id="categoriesgame">

                            </ul>
                        </div>
                    </div>
                </div><!-- block_sidebar -->
                <div class="block block_sidebar block_popular_categories">
                    <div class="blokck_pad_content">
                        <div class="block_title">
                            <div class="title">{{ __('web.appscate') }}</div>
                        </div>
                        <div class="block_content clearfix">
                            <ul class="popular_categories_list location" id="categoriesapp">
                            </ul>
                        </div>
                    </div>
                </div><!-- block_sidebar -->
                <div class="block">{!! $ad['below_right_column'] !!}</div>
            </div><!-- /block_right -->
        </div>
    </main><!-- /#main -->

    <footer class="footer">
        <div class="footer_main">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 list_menu_footer">
                        <div class="menu_footer_items">
                            <p class="list_menu_footer_title">{{__('web.solutions')}}</p>
                            @if(count($pages)>0)
                                <ul>
                                    @foreach($pages as $r)
                                        <li><a href="{{ route('site.page', [$r->slug]) }}"
                                               title="{{$r->title}}">{{$r->title}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div><!-- /list_menu_footer -->

                    <div class="col-sm-3 list_menu_footer">
                        <div class="menu_footer_items">
                            <p class="list_menu_footer_title">{{ __('web.follow') }}</p>
                            <ul class="follow">
                                <li>
                                    <a href="{{$site['facebook']}}" title="Facebook">
                                        <i class="fa fa-facebook"></i> Facebook
                                    </a>
                                </li>
                                <li>
                                    <a href="{{$site['twitter']}}" title="Twitter">
                                        <i class="fa fa-twitter"></i> Twitter
                                    </a>
                                </li>
                                <li>
                                    <a href="{{$site['google']}}" title="Google">
                                        <i class="fa fa-google-plus"></i> Google+
                                    </a>
                                </li>
                                <li>
                                    <a href="{{$site['instagram']}}" title="Instagram">
                                        <i class="fa fa-instagram"></i> Instagram
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- /list_menu_footer -->
                    <div class="col-sm-3 list_menu_footer">
                        <div class="menu_footer_items">
                            <p class="list_menu_footer_title">TOP {{ __('web.apps') }}</p>
                            <ul id="footerapp">
                            </ul>
                        </div>
                    </div><!-- /list_menu_footer -->
                    <div class="col-sm-3 list_menu_footer">
                        <div class="menu_footer_items">
                            <p class="list_menu_footer_title">TOP {{ __('web.games') }}</p>
                            <ul id="footergame">

                            </ul>
                        </div>
                    </div><!-- /list_menu_footer -->
                </div>
            </div>
        </div><!-- /footer_main -->
        <div class="footer_bot">
            <div class="container">
                <div class="row">
                    <div class="copyright">
                        Copyright © 2021-2025. All rights reserved.
                        {{--                        <a href="{{ route('site.page', ['dmca']) }}" rel="nofollow">DMCA Disclaimer</a>--}}
                        {{--                        <a href="{{ route('site.page', ['privacy-policy']) }}" rel="nofollow">Privacy Policy</a>--}}
                        {{--                        <a href="{{ route('site.page', ['terms']) }}" rel="nofollow">Term of Use</a>--}}
                    </div>
                </div>
            </div>
        </div><!-- /footer_main -->
    </footer><!-- /footer -->

    <a id="return-to-top" class="td-scroll-up" href="javascript:void(0)">
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </a>
    <!-- Return To Top -->

</div><!-- /wrapper -->

<!-- ===== JS ===== -->
<script src="{{ asset('public/theme/js/jquery.min.js') }}"></script>
<!-- ===== JS Bootstrap ===== -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- ===== JS Owl ===== -->
<script src="{{ asset('public/theme/lib/owl/owl.carousel.min.js') }}"></script>
<!-- ===== JS Sticky ===== -->
<script src="{{ asset('public/theme/lib/sticky/jquery.sticky.js') }}"></script>
<!-- Js Common -->
<script src="{{ asset('public/theme/js/common.js') }}"></script>
<script type='text/javascript'>
    $(document).ready(function () {
        var _token = $('input[name="_token"]').val();
        load_data('footer', 'game', _token);
        load_data('footer', 'app', _token);
        load_data('top', 'game', _token);
        load_data('top', 'app', _token);
        load_data('categories', 'game', _token);
        load_data('categories', 'app', _token);

        function load_data(key = "", val = '', _token) {
            $('#' + key + val).html('loading...');
            $.ajax({
                url: "{{ route('data.getData') }}",
                method: "POST",
                data: {key: key, val: val, _token: _token},
                success: function (data) {
                    $('#' + key + val).html(data);
                }
            })
        }
    });
</script>
@yield('scripts')
{!! $site['before_body_end_tag'] !!}
</body>
</html>
