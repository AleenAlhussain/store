@extends('layouts.main')
@section('title', $title)
@section('content')
    <div class="block_left col-sm-9 col-xs-12">
        <div class="block">{!! $ad['below_header'] !!}</div>
        <div class="block block_products block_commom">
            <div class="block_title">
                <div class="block_breadcrumb">
                    <ul class="breadcrumb">
                        <li><a href="{{ route('home.index',app()->getLocale()) }}">{{__('web.home')}}</a></li>
                        <li><a href="{{ route('home.toppic',app()->getLocale()) }}">{{ __('web.Toppic') }}</a></li>
                        <li class="active">{{$title}}</li>
                    </ul>
                </div>
            </div>
            <div class="block block-content clearfix">
                @if(count($apps)>0)
                    <ul class="product_list clearfix">
                        @foreach ($apps as $top)
                            @php $top = json_decode(json_encode($top), true);@endphp
                            <li class="col-sm-5ths col-xs-6">
                                <div class="product_item">
                                    <div class="product_img">
                                        <a title="{{$top['title']}}"
                                           href="{{ route('home.detail', [app()->getLocale(),$top['slug'],$top['appid']]) }}">
                                            <img alt="{{$top['title']}}"
                                                 src="{{ asset('public/images/') }}/{{ $top['cover'] }}">
                                        </a>
                                    </div>
                                    <div class="description">
                                        <h3>
                                            <a title="{{$top['title']}}"
                                               href="{{ route('home.detail', [app()->getLocale(),$top['slug'],$top['appid']]) }}">{{$top['title']}}</a>
                                        </h3>
                                        <div class="stars">
                                        <span title="{{$top['title']}} average rating {{$top['score']}}"
                                              style="width:@php echo ((int)$top['score']/5)*100; @endphp%;"></span>
                                        </div>
                                        <div class="down_btn">
                                            <a href="{{ route('home.detail', [app()->getLocale(),$top['slug'],$top['appid']]) }}"
                                               class="btn btn_down" title="Download {{$top['title']}}">
                                                {{__('web.installapk')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li><!-- li -->
                        @endforeach
                    </ul>
                @else
                    <div class="product_items clearfix"><h6 class="alert alert-danger">No App Display.</h6>
                    </div>
                @endif
            </div>
        </div>
        <div class="block">{!! $ad['above_footer'] !!}</div>
    </div><!-- /block_left -->
@endsection
{{--@section('scripts')--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>--}}
{{--    </script>--}}
{{--    <script type="text/javascript">--}}
{{--        $('ul.pagination').hide();--}}
{{--        $(function() {--}}
{{--            $('.scrolling-pagination').jscroll({--}}
{{--                loadingHtml : '<div class="loading" style="padding: 10px;width: 100%;text-align: center"><i class="fa fa-spinner fa-spin" style="font-size: 60px;color: #DE4C34"></i></div>' ,--}}
{{--                autoTrigger: true,--}}
{{--                padding: 0,--}}
{{--                nextSelector: '.pagination li.active + li a',--}}
{{--                contentSelector: 'div.scrolling-pagination',--}}
{{--                callback: function() {--}}
{{--                    $('ul.pagination').remove();--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}
