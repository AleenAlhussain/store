@extends('layouts.main')
@section('title',__('web.sitetitle'))
@section('content')
    <div class="block_left col-sm-9 col-xs-12">
        @if(count($sliders)>0)
            <div class="block block_slide">
                <div class="owl-carousel dotsData" data-nav="true" data-margin="0" data-items='1'
                     data-autoplayTimeout="700" data-autoplay="false" data-loop="true" data-dots="true">
                    @foreach($sliders as $k=>$slider)
                        <div class="item-slide" data-dot="{{$k+1}}">
                            <a href="{{$slider->link}}">
                                <img src="{{ asset('public/images/sliders') }}/{{$slider->image}}" alt="{{$slider->title}}">
                            </a>
                            <div class="figcaption">
                                <a href="{{$slider->link}}" style="color: #FFF;">
                                    {{$slider->title}}</a>
                            </div>

                        </div><!-- item-slide -->
                    @endforeach
                </div>
            </div><!-- /block_slide -->
        @endif
        <div class="block">{!! $ad['below_header'] !!}</div>
        @if(count($toppic)>0)
            @foreach($toppic as $k=>$app)
                <div class="block block_products block_commom">
                    <div class="block_title">
                        {{$app['title']}}
                    </div>
                    <div class="block-content" id="hometopgame">
                        @if(isset($app['data']) && count($app['data'])>0)
                            <ul class="product_items clearfix">
                                @foreach($app['data'] as $top)
                                    <li class="col-sm-4 col-xs-6 product_item">
                                        <div class="product_img">
                                            <a title="{{ $top['title'] }}"
                                               href="{{route('home.detail', [app()->getLocale(),$top['slug'], $top['id']]) }}">
                                                <img alt="{{ $top['title'] }}" width="75px" height="75px"
                                                     src="{{ asset('public/images/') }}/{{$top['cover']}}">
                                            </a>
                                        </div>
                                        <div class="description">
                                            <h3>
                                                <a title="{{ $top['title'] }}"
                                                   href="{{route('home.detail', [app()->getLocale(),$top['slug'], $top['id']]) }}">{{$top['title'] }}</a>
                                            </h3>
                                            <div class="stars">
                                    <span title="{{ $top['title'] }} average rating {{ $top['score'] }}"
                                          style="width:{{ (((int)$top['score'] / 5) * 100) }}%;"></span>
                                            </div>
                                            <div class="rating_info"> votes <span class="rating"><span
                                                        class="average">{{ round($top['score'], 1) }}</span>/<span
                                                        class="best"> 5</span></span></div>
                                            <div class="down_btn">
                                                <p> Download {{ $top['title'] }}</p>
                                                <a href="{{route('home.detail', [app()->getLocale(),$top['slug'], $top['id']]) }}"
                                                   class="btn btn_down" title="Download {{ $top['title'] }}"> {{
                                            __('web.installapk') }} </a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="product_items clearfix"><h6 class="alert alert-danger">No App Selected.</h6>
                            </div>
                        @endif
                    </div>
                </div><!-- /block_products -->
            @endforeach
        @endif
            <div class="block">{!! $ad['above_footer'] !!}</div>
    </div><!-- /block_left -->
@endsection
