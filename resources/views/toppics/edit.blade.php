@extends('layouts.app')

@section('content')

@section('content_header', 'Edit Page')
<div class="contact-area">
    <div class="container">
        <!-- box -->
        <div class="row">

            <!-- col -->
            <div class="col-md-12">
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
                @if(Session::has('success'))
                    <div class="alert alert-success">
                        <p>{{ Session::get('success') }}</p>
                    </div>
            @endif

            <!-- general form elements -->
                <div class="box normal-table-list">
                    <ol class="breadcrumb breadcrumb-alt push">
                        <li class="breadcrumb-item">
                            <a href="{{action('ToppicsController@index')}}"><i class="notika-icon notika-windows"></i>
                                Toppics</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Update Toppics</li>
                    </ol>
                    <div class="row">
                        <div class="col-lg-3"><p class="text-muted">Page Information</p></div>
                        <!-- form -->
                        <div class="col-lg-9">
                            <form method="POST" enctype="multipart/form-data"
                                  action="{{action('ToppicsController@update', $id)}}">
                            @csrf @method('PUT')
                            <!-- box-body -->
                                <div class="box-body">

                                    <div class="form-group">
                                        <label>Title<span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control" value="{{$page->title}}"
                                               placeholder="Page Title"/>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="fm-checkbox">
                                                <label><input type="checkbox"
                                                              {{($page->home == 1)?'checked':''}}  name="home"> <i></i>
                                                    Show
                                                    Home Page</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option {{($page->status == 0)?'selected':''}} value="0">In Active</option>
                                            <option {{($page->status == 1)?'selected':''}}  value="1">Active</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Content<span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="details"
                                                  placeholder="@lang('admin.page_content')">{{$page->details}}</textarea>
                                    </div>
                                    <img src="{{ asset('public/images/toppics') }}/{{$page->images}}" id="appimg"
                                         alt="App Cover"
                                         class="img-fluid" style="max-height: 100px;">
                                    <div class="form-group">
                                        <label>@lang('admin.image')</label>
                                        <input type="file" name="images" id="cover_input">
                                    </div>

                                </div>
                                <!-- /.box-body -->
                                <hr>
                                <div class="basic-tb-hd">
                                    <h2>App Collections</h2>
                                    <p>Select apps connected to this Toppic.</p>
                                </div>
                                <div class="form-group">
                                    <div class="nk-int-st search-input search-overt">
                                        <input type="text" id="txtsearch" class="form-control" placeholder="Search ...">
                                        <a class="btn search-ib waves-effect" id="search-ib">Search</a>
                                    </div>
                                    <i style="font-size: 12px;">Search apps that you want to connect</i>
                                </div>
                                <div id="table_data">
                                </div>

                                <div id="connected_app"></div>
                                <div class="box-footer pt-5">
                                    <button type="submit" class="btn btncus btn_blue">Update Page</button>
                                </div>

                            </form>
                            <!-- /.form -->

                        </div>
                    </div>
                </div>
                <!-- /.general form elements -->

            </div>
            <!-- /.col -->

        </div>
    </div>
</div>
<!-- /.box -->

@endsection

@section('scripts')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#appimg').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        function fetch_data(page, text = null) {
            if (text === null)
                $('#table_data').html('');
            else var url = "{{ route('admin.getapptoppic') }}?page=" + page + "&text=" + text;
            $.ajax({
                url: url,
                success: function (data) {
                    $('#table_data').html(data);
                }
            });
        }

        $(document).ready(function () {
            var _token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: "{{action('ToppicsController@getapps')}}",
                method: "POST",
                data: {id: {{$page->id}}, _token: _token, data: ''},
                success: function (data) {
                    $('#connected_app').html(data);
                }
            })
            $(document).on('click', '.remove_app', function () {
                @if(Auth::user()->email == 'demo@iapk.site')
                swal("Error!", 'Demo acount only view.', "error");
                @else
                var _token = $("meta[name='csrf-token']").attr("content");
                var id = $(this).data("id");
                $.ajax({
                    url: "{{action('ToppicsController@getapps')}}",
                    method: "POST",
                    data: {id: {{$page->id}}, _token: _token, data: id, remove: true},
                    success: function (data) {
                        $('#connected_app').html(data);
                    }
                })
                @endif
            });
            $(document).on('click', '#add-apps', function () {
                @if(Auth::user()->email == 'demo@iapk.site')
                swal("Error!", 'Demo acount only view.', "error");
                @else
                var _token = $("meta[name='csrf-token']").attr("content");
                const data = [...document.querySelectorAll('.i-checks:checked')].map(e => e.value);
                //console.log(data);
                //var checkboxes = document.querySelectorAll('input[class=i-checks]:checked')
                //console.log(data);
                $.ajax({
                    url: "{{action('ToppicsController@getapps')}}",
                    method: "POST",
                    data: {id: {{$page->id}}, _token: _token, data: data},
                    success: function (data) {
                        $('#connected_app').html(data);
                    }
                })
                @endif
            });
            $(document).on('click', '#select-all', function () {
                if (this.checked) {
                    $('.i-checks:checkbox').prop('checked', true);
                } else {
                    $('.i-checks:checkbox').prop('checked', false);
                }
            });
            $(document).on('click', '.page-link', function (event) {
                event.preventDefault();
                var text = $('#txtsearch').val();
                var page = $(this).attr('href').split('page=')[1];
                if (text !== '')
                    fetch_data(page, text);
                else fetch_data(page);
            });
            $(document).on('click', '#search-ib', function (event) {
                event.preventDefault();
                var text = $('#txtsearch').val();
                var page = 1;
                if (text === '') $('#table_data').html('');
                else
                    fetch_data(page, text);
            });
            $("#cover_input").change(function () {
                readURL(this);
            });
        });
    </script>
@endsection
