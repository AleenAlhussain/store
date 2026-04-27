@extends('layouts.main')
@section('title', 'Toppics ')
@section('content')
    <div class="block_left col-sm-9 col-xs-12">
        <div class="block">{!! $ad['below_header'] !!}</div>
        <div class="block block_products block_commom">
            <div class="block_title">
                <div class="block_breadcrumb">
                    <ul class="breadcrumb">
                        <li><a href="{{ route('home.index',app()->getLocale()) }}">{{__('web.home')}}</a></li>
                        <li class="active">{{ __('web.Toppic') }}</li>
                    </ul>
                </div>
            </div>
            <div class="block-topics block block-content">
                @if(count($toppic)>0)
                    <ul class="topics_list clearfix pt-lg-2">
                        @foreach ($toppic as $top)
                            <li class="col-sm-4 col-xs-12">
                                <div class="topics_item">
                                    <a href="{{route('home.toppicDetail',[app()->getLocale(),$top['slug']])}}" title="">
                                        <div class="topics_img">
                                            <img src="{{ asset('public/images/toppics/') }}/{{ $top['images'] }}" alt="">
                                        </div>
                                        <div class="description">
                                            <div class="topics_name">{{$top['title']}}</div>
                                            <div class="topics_description">{{ Str::limit($top['details'], 100) }}</div>
                                        </div>
                                    </a>
                                </div>
                            </li><!-- /li -->
                        @endforeach
                    </ul>
                    <div class="pagination-inbox text-center">
                        {!! $toppic->links() !!}
                    </div>
                @else
                    <div class="product_items clearfix"><h6 class="alert alert-danger">No App Display.</h6>
                    </div>
                @endif
            </div>
        </div>
        <div class="block">{!! $ad['above_footer'] !!}</div>
    </div><!-- /block_left -->
@endsection
