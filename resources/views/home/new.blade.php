@extends('layouts.main')
@section('title', 'Top new free android '.$title)
@section('content')
<div class="block_left col-sm-9 col-xs-12">
  <div class="block block_search_results">
    <div class="block block-content clearfix">
      <ul class="product_list clearfix">
        @foreach ($search as $top)
          @php $top = json_decode(json_encode($top), true);@endphp
          <li class="col-sm-5ths col-xs-6">
            <div class="product_item">
              <div class="product_img">
                <a title="{{$top['name']}}" href="{{ route('home.detail', [app()->getLocale(),str_slug($top['name'],'-'),$top['id']]) }}">
                  <img alt="{{$top['name']}}" src="{{ $top['icon'] }}">
                </a>
              </div>
              <div class="description">
                <h3>
                  <a title="{{$top['name']}}" href="{{ route('home.detail', [app()->getLocale(),str_slug($top['name'],'-'),$top['id']]) }}">{{$top['name']}}</a>
                </h3>
                <div class="stars">
                  <span title="{{$top['name']}} average rating {{$top['score']}}" style="width:@php echo ((int)$top['score']/5)*100; @endphp%;"></span>
                </div>
                <div class="down_btn">
                  <a href="{{ route('home.detail', [app()->getLocale(),str_slug($top['name'],'-'),$top['id']]) }}" class="btn btn_down" title="Download {{$top['name']}}">
                    {{__('web.installapk')}}
                </a>
                </div>
              </div>
            </div>
          </li><!-- li -->

        @endforeach
      </ul>
    </div>
  </div>
</div><!-- /block_left -->
@endsection
