@extends('layouts.app')

@section('content')
@section('content_header', 'Create Application From Google Play Store')
<div class="contact-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mg-b-15">
                @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{$message}}</p>
                    </div>
                @endif
                <div class="inbox-text-list sm-res-mg-t-30">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#name">Search By Name</a></li>
                        <li><a data-toggle="tab" href="#topCategory">Get Top By Category</a></li>
                        <li><a data-toggle="tab" href="#newCategory">Get New By Category</a></li>
                    </ul>
                    <div class="tab-content p-5" style="padding: 30px 0;">
                        <div id="name" class="tab-pane fade in active">
                            <div class="form-group">
                                <div class="nk-int-st search-input search-overt">
                                    <input type="text" id="txtsearch" class="form-control" placeholder="Search ...">
                                    <button class="btn search-ib waves-effect" id="search-ib">Search</button>
                                </div>
                            </div>
                        </div>
                        <div id="topCategory" class="tab-pane fade">
                            <div class="form-group">
                                <div class="col-lg-10">
                                    <select title="Select App Category" id="txt_cate_top"
                                            class="form-control selectpicker" data-live-search="true">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->slug }}">
                                                {{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-1">
                                    <select class="form-control" id="top_limit">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="150">150</option>
                                        <option value="200">200</option>
                                        <option value="300">300</option>
                                    </select>
                                </div>
                                <div class="col-lg-1">
                                    <a class="btn btncus btn_blue" id="btn_cate_top">Search</a></div>
                            </div>
                        </div>
                        <div id="newCategory" class="tab-pane fade">
                            <div class="form-group">
                                <div class="col-lg-10">

                                    <select title="Select App Category" id="txt_cate_new"
                                            class="form-control selectpicker" data-live-search="true">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->slug }}">
                                                {{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-1">
                                    <select class="form-control" id="new_limit">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="150">150</option>
                                        <option value="200">200</option>
                                        <option value="300">300</option>
                                    </select>
                                </div>
                                <div class="col-lg-1">

                                    <a class="btn btncus btn_blue" id="btn_cate_new">Search</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="button-icon-btn sm-res-mg-t-30 text-right"><a href="{{action('ApplicationController@index')}}"
                                                                  class="btn btn-dark mr-1"><i
                    class="fa fa-arrow-left"></i> Back</a>
            <button type="button" class="btn btn-success" id="create_apps"><i class="mr-1 fa fa-check-circle"></i>
                Create new app
            </button>
        </div>
        <div class="normal-table-list p-3" id="table_data" style="margin-top: 20px;">
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $(document).on('click', '#select-all', function () {
                if (this.checked) {
                    $(':checkbox').prop('checked', true);
                } else {
                    $(':checkbox').prop('checked', false);
                }
            });
            $(document).on('click', '#btn_cate_top', function () {
                var _token = $("meta[name='csrf-token']").attr("content");
                var q = $('#txt_cate_top').val();
                var limit = $('#top_limit').val();
                search_data(q, _token, 'cate_top', limit);
            });
            $(document).on('click', '#btn_cate_new', function () {
                var _token = $("meta[name='csrf-token']").attr("content");
                var q = $('#txt_cate_new').val();
                var limit = $('#new_limit').val();
                search_data(q, _token, 'cate_new', limit);
            });
            $(document).on('click', '#search-ib', function () {
                var _token = $("meta[name='csrf-token']").attr("content");
                var q = $('#txtsearch').val();
                search_data(q, _token);
            });
            $(document).on('click', '#create_apps', function () {
                @if(Auth::user()->email == 'demo@iapk.site')
                swal("Error!", 'Demo acount only view.', "error");
                @else
                $('#create_apps').html('<i class="mr-1 fa fa-check-circle"></i> Creating...');
                $('#create_apps').attr("disabled", true);
                var _token = $("meta[name='csrf-token']").attr("content");
                var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].value == 'all' || checkboxes[i].value == 'on') continue;
                    else {
                        var id = checkboxes[i].value;
                        $.ajax({
                            url: "{{ route('apps.createplay') }}",
                            method: "POST",
                            data: {appid: id, _token: _token},
                            beforeSend: function () {
                                document.getElementById(id).innerHTML = 'Inserting...';
                            },
                            success: function (data) {
                                document.getElementById(data.appid).innerHTML = data.message;
                            }
                        })
                    }
                }
                $('#create_apps').html('<i class="mr-1 fa fa-check-circle"></i> Create new app');
                $('#create_apps').attr("disabled", false);
                @endif
            });

            function search_data(q = "", _token, type = 'text', limit = 100) {
                $('#table_data').html('<div class="loading" style="padding: 50px;width: 100%;text-align: center"><i class="fa fa-spinner fa-spin" style="font-size: 60px;color: #DE4C34"></i></div>');
                $.ajax({
                    url: "{{ route('ajax.getApps') }}",
                    method: "POST",
                    data: {q: q, _token: _token, type: type, limit: limit},
                    success: function (data) {
                        $('#table_data').html(data);
                    }
                })
            }
        });
    </script>
@endsection
