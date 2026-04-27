@extends('layouts.main')
@section('title', __('web.detailDesc').' '.$app['name'] ?? '404 – Page Not Found')
@section('description', __('web.detailDesc').' '.$app['name'].' - '.Str::words(strip_tags($app['description']),30) ?? '')
@section('content')
    <div class="block_left col-sm-9 col-xs-12">
        <div class="block">{!! $ad['below_header'] !!}</div>
        @if(isset($app['name']))
            <div class="block_product_detail"  itemscope itemtype="http://schema.org/MobileApplication">
                <div class="block block_commom block_shadow">
                    <div class="block_title">
                        <div class="block_breadcrumb">
                            <ul class="breadcrumb">
                                <li><a href="{{ route('home.index',app()->getLocale()) }}">{{__('web.home')}}</a></li>
                                <li>
                                    <a href="{{route('home.category', [app()->getLocale(),$app['category']['id']]) }}">{{$app['category']['name']}}</a>
                                </li>
                                <li class="active">{{$app['name']}}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="block_content">
                        <div class="product_box">
                            <div class="row">
                                <div class="col-sm-3 pro_detail_img">
                                    <img src="{{$app['icon']}}" alt="{{$app['name']}}">
                                </div>
                                <div class="col-sm-9 pro_detail_info">
                                    <h1 itemprop="name">{{$app['name']}}</h1>
                                    <!-- 											<div class="pro_detail_share">
                                                    Share fb, g+, instagram
                                                  </div> -->
                                    <div class="pro_detail_rating">
                                        <div class="stars"><span
                                                    style="width:@php echo ((int)$app['score']/5)*100; @endphp%"></span>
                                        </div>
                                        <div class="rating_info">{{__('web.votes')}}, <span class="rating"><span
                                                        class="average">{{round($app['score'],1)}}</span>/<span
                                                        class="best">5</span></span></div>
                                    </div>
                                    <div class="pro_detail_version">
                                        <div class="table-responsive">
                                            <table class="table table-no-border">
                                                <tr>
                                                    <th>{{__('web.author')}}:</th>
                                                    <th>{{__('web.latestversion')}}:</th>
                                                    <th>{{__('web.updatedate')}}:</th>
                                                </tr>
                                                <tr>
                                                    <td itemprop="publisher"><a href="#" title="">{{$app['developer']['name']}}.</a></td>
                                                    <td  itemprop="version">{{$app['appVersion']}}</td>
                                                    <td>@php echo date('d/m/Y',$app['updatedTimestamp'])@endphp</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <div class="down_btn">
                                            <a target="_blank"
                                               href="{{route('home.download', [app()->getLocale(),str_slug($app['name'], '-'), $app['id']])}}"
                                               class="btn btn_down" title="Download {{$app['name']}}">
                                                {{__('web.installapk')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="clearfix">
                              <div class="down_btn">
                                <a href="#" class="btn btn_down" title="For iOS"><i class="fa fa-apple"></i> iOS</a>
                                <a href="#" class="btn btn_down" title="For Android"><i class="fa fa-android"></i> Android</a>
                                <a href="#" class="btn btn_down" title="For Window"><i class="fa fa-windows"></i> Window</a>
                              </div>
                            </div> -->
                            <!-- <div class="block_safe-link">
                              <a title="Using APKPure App to upgrade Digital World, fast, free and save your internet data." href="#">Using APKPure App to upgrade, fast, free and save your internet data.</a>
                            </div> -->
                        </div><!-- /product_box -->
                        <div class="block">{!! $ad['below_top_downloads'] !!}</div>
                        <div class="product_box">
                            <div class="slide_pro_detail">
                                <div class="owl-carousel" data-nav="true" data-margin="10" data-items="4"
                                     data-autoplay="false" data-loop="false">
                                    @foreach($app['screenshots'] as $screenshots)
                                        <div class="item-slide">
                                            <a href="{{$screenshots}}" data-lightbox="roadtrip">
                                                <img src="{{$screenshots}}" alt="">
                                            </a>
                                        </div><!-- item-slide -->
                                    @endforeach
                                </div>
                            </div>
                        </div><!-- /product_box -->
                        <div class="product_box">
                            <div class="pro_detail_description" itemprop="description">
                                {!! $app['description'] !!}</div>
                            <a class="btn-overflow" href="javascript:void(0);">{{__('web.more')}}</a>
                        </div><!-- /product_box -->
                        <div class="product_box">
                            <div class="block_whatnew">
                                <h2>{{__('web.whatnew')}}</h2>
                                <div>{!! nl2br(e($app['recentChange'])) !!}</div>
                            </div>
                        </div><!-- /product_box -->
                        <div class="product_box">
                            <div class="block_additional">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p><strong>{{__('web.category')}}:</strong></p>
                                        <p><a title="Download more Role Playing games"
                                              href="{{route('home.category', [app()->getLocale(),$app['category']['id']])}}"><span>{{$app['category']['name']}}</span></a>
                                            <meta itemprop="applicationCategory" content="{{$app['category']['name']}}"/>
                                        </p>
                                    </div>
                                    <div class="col-sm-3">
                                        <p><strong>{{__('web.getiton')}}:</strong></p>
                                        <p>
                                            <a class="ga" title="{{$app['name']}} on Google Play"
                                               href="https://play.google.com/store/apps/details?id={{$app['id']}}"
                                               target="_blank">
                                                <img alt="{{$app['name']}} on Google Play"
                                                     src="{{ asset('public/theme/images/gp_logo.png') }}" height="16">
                                            </a>
                                        </p>
                                    </div>
                                    <div class="col-sm-3">
                                        <p><strong>{{__('web.size')}}:</strong></p>
                                        <p>{{$app['size']}}</p>
                                    </div>
                                    <div class="col-sm-3">
                                        <p><strong>{{__('web.publishdate')}}:</strong></p>
                                        <p itemprop="datePublished">@php echo date('d/m/Y',$app['releasedTimestamp'])@endphp</p>
                                        <meta itemprop="operatingSystem" content="ANDROID"/>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /product_box -->
                    </div>
                </div><!-- /block -->
                <span itemscope itemprop="offers" itemtype="https://schema.org/Offer"><meta itemprop="price" content="0.00"/><meta itemprop="priceCurrency" content="USD"/></span>
                <div class="block">{!! $ad['above_top_downloads'] !!}</div>
                <div class="block block_commom block_shadow" id="getapk">
                    <div class="block_title text-center">
                        <p class="block_title_small">{{$app['name']}} {{__('web.installapk')}}</p>
                    </div>
                    <div class="block_content">
                        <div class="product_box">
                            <div class="clearfix block_faq">
                                <div class="box-header accordion-header text-center">
                                    <a target="_blank"
                                       href="{{route('home.download', [app()->getLocale(),str_slug($app['name'], '-'), $app['id']])}}"
                                       class="btn btn_down" style="width:100%;max-width:300px;"
                                       title="Download {{$app['name']}}">
                                        {{__('web.installapk')}}
                                    </a>
                                </div>
                            </div>
                        </div><!-- /product_box -->
                    </div>
                </div><!-- /block -->
                <script>
                    /**
                    *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                    *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */

                    var disqus_config = function () {
                    this.page.url = "{{url()->current()}}";  // Replace PAGE_URL with your page's canonical URL variable
                    this.page.identifier = "{{$app['id']}}"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                    };

                    (function() { // DON'T EDIT BELOW THIS LINE
                    var d = document, s = d.createElement('script');
                    s.src = 'https://apkstore-1.disqus.com/embed.js';
                    s.setAttribute('data-timestamp', +new Date());
                    (d.head || d.body).appendChild(s);
                    })();
                </script>
                <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                <div class="block block_commom block_shadow block_related">
                    <div class="block_title">
                        <p class="block_title_small">{{__('web.review')}}</p>

                    </div>
                    <div class="block-content" style="padding: 20px;">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="rating-block" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                                    <h4>{{__('web.averagerating')}}</h4>
                                    <h2 class="bold padding-bottom-7" itemprop="ratingValue">{{round($app['score'],1)}} <small>/ 5</small></h2>
                                    <div class="stars" style="margin: 0;">
                                        <span style="width:@php echo ((int)$app['score']/5)*100; @endphp%;"></span>
                                    </div>
                                    <meta itemprop="ratingCount" content="{{$app['numberVoters']}}" />
                                    <meta itemprop="bestRating" content="5" />
                                    <meta itemprop="worstRating" content="1"/>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <h4>{{__('web.ratingbreakdown')}} ({{number_format($app['numberVoters'], 0)}})</h4>
                                <div class="pull-left">
                                    <div class="pull-left" style="width:35px; line-height:1;">
                                        <div style="height:9px; margin:5px 0;">5 <span class="fa fa-star"></span></div>
                                    </div>
                                    @if($app['histogramRating']['five']>0)
                                        <div class="pull-left" style="width:180px;">
                                            <div class="progress" style="height:9px; margin:8px 0;">
                                                <div class="progress-bar progress-bar-success" role="progressbar"
                                                     aria-valuenow="5" aria-valuemin="0" aria-valuemax="5"
                                                     style="width: {{round((($app['histogramRating']['five']*100)/$app['numberVoters']),0)}}%">
                                                    <span class="sr-only"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pull-right"
                                             style="margin-left:10px;">{{number_format($app['histogramRating']['five'],0)}}</div>
                                    @endif
                                </div>
                                <div class="pull-left">
                                    <div class="pull-left" style="width:35px; line-height:1;">
                                        <div style="height:9px; margin:5px 0;">4 <span class="fa fa-star"></span></div>
                                    </div>
                                    @if($app['histogramRating']['four']>0)
                                        <div class="pull-left" style="width:180px;">
                                            <div class="progress" style="height:9px; margin:8px 0;">
                                                <div class="progress-bar progress-bar-primary" role="progressbar"
                                                     aria-valuenow="4" aria-valuemin="0" aria-valuemax="5"
                                                     style="width: {{round((($app['histogramRating']['four']*100)/$app['numberVoters']),0)}}%">
                                                    <span class="sr-only"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pull-right"
                                             style="margin-left:10px;">{{number_format($app['histogramRating']['four'],0)}}</div>
                                    @endif
                                </div>
                                <div class="pull-left">
                                    <div class="pull-left" style="width:35px; line-height:1;">
                                        <div style="height:9px; margin:5px 0;">3 <span class="fa fa-star"></span></div>
                                    </div>
                                    @if($app['histogramRating']['three']>0)
                                        <div class="pull-left" style="width:180px;">
                                            <div class="progress" style="height:9px; margin:8px 0;">
                                                <div class="progress-bar progress-bar-info" role="progressbar"
                                                     aria-valuenow="3" aria-valuemin="0" aria-valuemax="5"
                                                     style="width: {{round((($app['histogramRating']['three']*100)/$app['numberVoters']),0)}}%">
                                                    <span class="sr-only"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pull-right"
                                             style="margin-left:10px;">{{number_format($app['histogramRating']['three'],0)}}</div>
                                    @endif
                                </div>
                                <div class="pull-left">
                                    <div class="pull-left" style="width:35px; line-height:1;">
                                        <div style="height:9px; margin:5px 0;">2 <span class="fa fa-star"></span></div>
                                    </div>
                                    @if($app['histogramRating']['two']>0)
                                        <div class="pull-left" style="width:180px;">
                                            <div class="progress" style="height:9px; margin:8px 0;">
                                                <div class="progress-bar progress-bar-warning" role="progressbar"
                                                     aria-valuenow="2" aria-valuemin="0" aria-valuemax="5"
                                                     style="width: {{round((($app['histogramRating']['two']*100)/$app['numberVoters']),0)}}%">
                                                    <span class="sr-only"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pull-right"
                                             style="margin-left:10px;">{{number_format($app['histogramRating']['two'],0)}}</div>
                                    @endif
                                </div>
                                <div class="pull-left">
                                    <div class="pull-left" style="width:35px; line-height:1;">
                                        <div style="height:9px; margin:5px 0;">1 <span class="fa fa-star"></span></div>
                                    </div>
                                    @if($app['histogramRating']['one']>0)
                                        <div class="pull-left" style="width:180px;">
                                            <div class="progress" style="height:9px; margin:8px 0;">
                                                <div class="progress-bar progress-bar-danger" role="progressbar"
                                                     aria-valuenow="1" aria-valuemin="0" aria-valuemax="5"
                                                     style="width: {{round((($app['histogramRating']['one']*100)/$app['numberVoters']),0)}}%">
                                                    <span class="sr-only"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pull-right"
                                             style="margin-left:10px;">{{number_format($app['histogramRating']['one'],0)}}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div id="disqus_thread"></div>
                        @if(count($app['reviews'])>0)
                            <div class="row">
                                <div class="col-sm-12">
                                    @foreach($app['reviews'] as $v)
                                        <hr/>
                                        <div class="review-block">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="review-block-name"><a href="#">{{$v['userName']}}</a>
                                                        ({{date('d-m-Y H:i:s',$v['timestamp'])}})
                                                    </div>
                                                    <div class="review-block-rate">
                                                        <div class="stars" style="margin: 0;">
                                                        <span
                                                                title="{{$app['name']}} average rating {{round($app['score'],1)}}"
                                                                style="width:@php echo ((int)$v['score']/5)*100; @endphp%;"></span>
                                                        </div>
                                                    </div>
                                                    <div class="review-block-description">{{$v['text']}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="block block_commom block_shadow block_related">
                    <div class="block_title">
                        <p class="block_title_small">{{__('web.similar')}} {{$app['name']}}</p>
                    </div>
                    <div class="block-content">
                        <div class="product_box">
                            <ul class="product_items clearfix" id="similar">
                            </ul>
                        </div>
                    </div>
                </div><!-- /block -->
                <div class="block block_commom block_shadow block_related">
                    <div class="block_title">
                        <p class="block_title_small">{{__('web.moreappsfrom')}} {{$app['developer']['name']}}</p>
                    </div>
                    <div class="block-content">
                        <div class="product_box">
                            <ul class="product_items clearfix" id="developer">
                            </ul>
                        </div>
                    </div>
                </div><!-- /block -->

            </div>
            <div class="block">{!! $ad['above_footer'] !!}</div>
        @else
            <div class="block_product_detail">
                <div class="block block_commom block_shadow">
                    <div class="block_content">
                        <div class="product_box" style="padding: 30px;"><h3>404 – Page Not Found</h3><br>
                            It seems that page you are looking for no longer exists.<br>
                            Try searching again, or explore more Android Games and Apps below!
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div><!-- /block_left -->
@endsection
@section('scripts')
    <!-- ===== LightBox ===== -->
    <script src="{{ asset('public/theme/lib/lightbox/js/lightbox.js') }}"></script>
    <script>
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'showImageNumberLabel': false,
        })
        var text = $('.pro_detail_description'),
            btn = $('.btn-overflow'),
            h = text[0].scrollHeight;
        angle = $('<i class="fa"></i>')

        if (h > 200) {
            btn.addClass('less');
            btn.css('display', 'block');
        }
        btn.click(function (e) {
            e.stopPropagation();

            if (btn.hasClass('less')) {
                btn.removeClass('less');
                btn.addClass('more');
                btn.text('{{__('web.showless')}}');
                text.animate({'height': h});
            } else {
                btn.addClass('less');
                btn.removeClass('more');
                btn.text('{{__('web.more')}}');
                text.animate({'height': '200px'});
            }
        });
        // Accordion has icon arrow
        $(document).on('click', '.box-accordion > .accordion-header', function (event) {
            $(this).toggleClass('active');
            $(this).toggleClass('opened');
            $(this).next('.box-collapse').slideToggle(200);
        });
        $(document).ready(function () {
            var _token = $('input[name="_token"]').val();
            $('#similar', '#developer').html('<div class="loading" style="padding: 50px;width: 100%;text-align: center"><i class="fa fa-spinner fa-spin" style="font-size: 60px;color: #DE4C34"></i></div>');
            $.ajax({
                url: "{{ route('ajax.getData',app()->getLocale()) }}",
                method: "POST",
                data: {key: 'similar', val: '{{$app['id']}}', _token: _token},
                success: function (data) {
                    $('#similar').html(data);
                }
            })
            $.ajax({
                url: "{{ route('ajax.getData',app()->getLocale()) }}",
                method: "POST",
                data: {key: 'developer', val: '{{$app['developer']['name']}}', _token: _token},
                success: function (data) {
                    $('#developer').html(data);
                }
            })
            $.ajax({
                url: "{{ route('ajax.updateApp',app()->getLocale()) }}",
                method: "POST",
                data: {appid: '{{$app['id']}}', _token: _token},
                success: function (data) {
                }
            })
        });
    </script>
@endsection
