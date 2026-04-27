@extends('layouts.main')
@section('title', $_GET['q'].' search results' ?? 'search')
@section('content')
    <div class="block_left col-sm-9 col-xs-12">
        <div class="block">{!! $ad['below_header'] !!}</div>
        <div class="block block_search_results">
            <div class="block_title">
                {{ csrf_field() }}
                <form class="form_search" style="margin:10px;">
                    <input type="text" name="q" id="text_search" class="search_input"
                           placeholder="Enter App Name, Package Name, Package ID"
                           value="@php echo isset($_GET['q'])?$_GET['q']:''; @endphp" required="">
                    <button type="button" id="btn_search" class="btn_search"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <div class="block block-content clearfix" id="search_content">
            </div>
        </div>
        <div class="block">{!! $ad['above_footer'] !!}</div>
    </div><!-- /block_left -->
@endsection
@section('scripts')
    <script type='text/javascript'>
        $(document).ready(function () {
            var _token = $('input[name="_token"]').val();
            var q = $('#text_search').val();
            search_data(q, _token);
            $("#btn_search").click(function () {
                var _token = $('input[name="_token"]').val();
                var q = $('#text_search').val();
                search_data(q, _token);
            });

            function search_data(q = "", _token) {
                if (q !== "") {
                    $('#search_content').html('<div class="loading" style="padding: 50px;width: 100%;text-align: center"><i class="fa fa-spinner fa-spin" style="font-size: 60px;color: #DE4C34"></i></div>');
                    $.ajax({
                        url: "{{ route('ajax.getSearch',app()->getLocale()) }}",
                        method: "POST",
                        data: {q: q, _token: _token},
                        success: function (data) {
                            $('#search_content').html(data);
                        }
                    })
                } else {
                    $('#search_content').html('<div class="loading" style="padding: 50px;width: 100%;text-align: center"></div>');
                }
            }
        });
    </script>
@endsection
