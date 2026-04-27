@extends('layouts.site')
@section('title', $page->title)
@section('description', strip_tags(Illuminate\Support\Str::words($page->details,30)) ?? '')
@section('content')
    <div class="block_left col-sm-9 col-xs-12">
        <div class="block block_search_results">
            <div class="block block-content product_box" style="padding: 20px;line-height:24px;font-size: 16px">
                <div class="pure-ui">
                    <h1>{{$page->title}}</h1>
                    <div>{!! $page->details !!}</div>
                </div>
            </div>
        </div>
    </div><!-- /block_left -->
@endsection

