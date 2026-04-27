@extends('layouts.app')

@section('content')

@section('content_header', 'Dashboard')
<!-- Start Status area -->
<div class="notika-status-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30">
                    <div class="website-traffic-ctn">
                        <h2><span class="counter">{{number_format($totalapp)}}</span></h2>
                        <p>Total Apps</p>
                    </div>
                    <div class="sparkline-bar-stats1">9,4,8,6,5,6,4,8,3,5,9,5</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30">
                    <div class="website-traffic-ctn">
                        <h2><span class="counter">{{number_format($totallang)}}</span></h2>
                        <p>Total Language Install</p>
                    </div>
                    <div class="sparkline-bar-stats2">1,4,8,3,5,6,4,8,3,3,9,5</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30 dk-res-mg-t-30">
                    <div class="website-traffic-ctn">
                        <h2><span class="counter">{{number_format($totaltoppic)}}</span></h2>
                        <p>Total Toppics</p>
                    </div>
                    <div class="sparkline-bar-stats3">4,2,8,2,5,6,3,8,3,5,9,5</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30 dk-res-mg-t-30">
                    <div class="website-traffic-ctn">
                        <h2><span class="counter">{{number_format($totalpage)}}</span></h2>
                        <p>Total Pages</p>
                    </div>
                    <div class="sparkline-bar-stats4">2,4,8,4,5,7,4,7,3,5,7,5</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="breadcomb-area">

</div>
<!-- End Status area-->

<div class="contact-area">
    <div class="container">
        <div class="normal-table-list p-3" style="margin-top: 20px;">
            <div class="basic-tb-hd clearfix">
                <h2 class="panel-title pull-left" style="padding-top: 7.5px;">New Apps</h2>
                <div class="btn-group pull-right">
                    <a href="{{action('ApplicationController@create')}}" class="btn btncus btn_blue"><i
                            class="notika-icon notika-draft"></i> Add New App</a>
                </div>
            </div>
            <div class="row">
                @foreach($apps as $row)
                    <div class="col-lg-2 col-md-3 col-sm-12" id="{{$row->appid}}">
                        <div class="card product_item">
                            <div class="body">
                                <div class="cp_img">
                                    <a href="{{action('ApplicationController@edit', $row->appid)}}"> <img src="{{ asset('public/images/') }}/{{$row->cover}}" alt="Product" class="img-fluid"></a>
                                </div>
                                <div class="product_details">
                                    <h5 class="trunc"><a href="{{action('ApplicationController@edit', $row->appid)}}">{{$row->stitle??$row->title}}</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
