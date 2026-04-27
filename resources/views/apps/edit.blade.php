@extends('layouts.app')

@section('content')

@section('content_header', 'Update Application')
<div class="form-element-area">
    <div class="container">
        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif @if(Session::has('success'))
            <div class="alert alert-success">
                <p>{{ Session::get('success') }}</p>
            </div>
        @endif
        <div class="row" style="background: #FFF;margin:0 5px;border-radius:5px; ">
            <ol class="breadcrumb breadcrumb-alt push m-15px">
                <li class="breadcrumb-item">
                    <a href="{{action('ApplicationController@index')}}"><i class="notika-icon notika-app"></i>  Apps</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit App</li>
            </ol>
            <form method="POST" enctype="multipart/form-data" action="{{action('ApplicationController@update', $id)}}">
                @csrf @method('PUT')
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="inbox-left-sd">
                        <img src="{{ asset('public/images/') }}/{{$app->cover}}" id="appimg" alt="App Cover"
                             class="img-fluid app_cover">
                        <input type="hidden" name="cover" id="cover">
                        <p class="text-center pt-3">App Image</p>

                        <div class="form-group">
                            <label for="exampleFormControlFile1">Example file input</label>
                            <input type="file" name="cover" class="form-control-file" id="cover_input">
                        </div>

                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    <div class="form-element-list">
                        <!-- form -->
                        <div class="form-group">
                            <label>App ID <span class="text-danger">*</span></label>
                            <div class="nk-int-st search-input search-overt">
                                <input type="text" class="form-control" id="AppId" name="appid" disabled readonly
                                       placeholder="App ID* eg: Enter unique app id here." value="{{$app->appid}}">
                                <button class="btn search-ib waves-effect" id="getinfo">Get Info</button>
                            </div>
                        </div>
                        <!-- box-body -->
                        <div class="box-body">

                            <div class="form-group">
                                <label>App Name <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control"
                                       placeholder="eg: Enter app title here" value="{{$appsinfo['title']}}"/>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Select App Category <span class="text-danger">*</span></label>
                                        <select title="Select App Category" id="category" name="category"
                                                class="form-control selectpicker" data-live-search="true">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->slug }}" {{($app->category == $category->slug)? "selected":''}}>
                                                {{ $category->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Developer <span class="text-danger">*</span></label>
                                        <input type="text" id="developer" name="developer" class="form-control"
                                               placeholder="Developer" value="{{$app->developer}}"/>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>size</label>
                                        <input type="text" id="size" name="size" class="form-control"
                                               placeholder="Ex: 50M" value="{{$appsinfo['size']}}"/>
                                    </div>
                                </div>

                            </div>
                            <!-- /.row -->
                            <div class="form-group">
                                <label>Recent Change</label>
                                <textarea class="form-control" id="recentChange" name="recentChange"
                                          placeholder="Recent Change">{{$appsinfo['recentChange']}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Summary</label>
                                <textarea class="form-control" id="summary" name="summary"
                                          placeholder="summary">{{$appsinfo['summary']}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Description <span class="text-danger">*</span></label>
                                <textarea class="form-control html-editor-cm" id="description" name="description"
                                          placeholder="description">{{$appsinfo['description']}}</textarea>
                            </div>
                            <!-- row -->
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Installs</label>
                                        <input type="text" id="installs" name="installs" class="form-control"
                                               placeholder="Ex:100000" value="{{$app->installs}}"/>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Android Version</label>
                                        <input type="text" id="androidVersion" name="androidVersion"
                                               class="form-control"
                                               placeholder="Ex:4.1 and up" value="{{$appsinfo['androidVersion']}}"/>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>App Version</label>
                                        <input type="text" id="appVersion" name="appVersion" class="form-control"
                                               placeholder="Ex:18.7.5" value="{{$appsinfo['appVersion']}}"/>
                                    </div>
                                </div>

                            </div>
                            <!-- /.row -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Number Voters</label>
                                        <input type="text" id="numberVoters" name="numberVoters" class="form-control"
                                               placeholder="Ex: 1000000" value="{{$app->numberVoters}}"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Score</label>
                                        <input type="text" id="score" name="score" class="form-control"
                                               placeholder="Ex: 4.5" value="{{$app->score}}"/>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>5 Star</label>
                                        <input type="text" id="five" name="five" class="form-control"
                                               placeholder="Ex: 5000" value="{{$app->five}}"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>4 Star</label>
                                        <input type="text" name="four" id="four" class="form-control"
                                               placeholder="Ex:5000" value="{{$app->four}}"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>3 Star</label>
                                        <input type="text" name="three" id="three" class="form-control"
                                               placeholder="Ex:5000" value="{{$app->three}}"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>2 Star</label>
                                        <input type="text" name="two" id="two" class="form-control"
                                               placeholder="Ex:5000" value="{{$app->two}}"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>1 Star</label>
                                        <input type="text" name="one" id="one" class="form-control"
                                               placeholder="Ex:5000" value="{{$app->one}}"/>
                                    </div>
                                </div>

                            </div>
                            <!-- /.row -->
                            <!-- row -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Url Download</label>
                                        <input type="text" id="url_download" name="url_download" class="form-control"
                                               placeholder="Ex: https://apkstore.biz/facebook.apk"
                                               value="{{$app->url}}"/>
                                    </div>
                                </div>

                            </div>
                            <!-- /.row -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="input-field">
                                            <label class="active">App Screenshots</label>
                                            <div id="screenshots" class="screenshots" style="padding-top: .5rem;"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @if($app->screenshots !== '')
                        <!-- /.box-body -->
                            <div class="image-uploader" style="border: 0;">
                                <div class="uploaded" id="screen">
                                    @php $screenshots = json_decode($app->screenshots) @endphp
                                    @foreach($screenshots as $k=>$v)
                                        <div class="uploaded-image"><img src="{{$v}}"> <a
                                                class="delete-image remove-img"><i class="notika-icon notika-close"></i></a><input
                                                type="hidden" name="preScreenshots[]" value="{{$v}}"></div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div class="box-footer">
                            <button type="submit" class="btn btncus btn_blue">Update App</button>
                        </div>


                        <!-- /.form -->

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
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

        $(document).ready(function () {
            $("#cover_input").change(function () {
                readURL(this);
            });
            $('#screenshots').imageUploader();
            $(document).on('click', '.remove-img', function () {
                $(this).parent('.uploaded-image').remove()
            });
            $(document).on('click', '#getinfo', function (event) {
                event.preventDefault();
                var text = $('#AppId').val();
                $.ajax({
                    url: '{{ route('admin.getappid') }}?appid=' + text,
                    success: function (data) {
                        if (data.status == true) {
                            //alert(data.data.category.id);
                            $('#appicon').val(data.data.icon);
                            $('#cover').val(data.data.icon);
                            $('#appimg').attr("src", data.data.icon);
                            $('#title').val(data.data.name);
                            $('#developer').val(data.data.developer.name);
                            $('#size').val(data.data.size);
                            $('#summary').val(data.data.summary);
                            $('#score').val(data.data.score);
                            $('#recentChange').val(data.data.recentChange);
                            $('#installs').val(data.data.installs);
                            $('#numberVoters').val(data.data.numberVoters);
                            $('#five').val(data.data.histogramRating.five);
                            $('#four').val(data.data.histogramRating.four);
                            $('#three').val(data.data.histogramRating.three);
                            $('#two').val(data.data.histogramRating.two);
                            $('#one').val(data.data.histogramRating.one);
                            $('#appVersion').val(data.data.appVersion);
                            $('#androidVersion').val(data.data.androidVersion);
                            $('#description').summernote('pasteHTML', data.data.description);
                            $('#category').selectpicker('val', data.data.category.id);
                            var html = '';
                            data.data.screenshots.forEach(function (image) {
                                html += '<div class="uploaded-image"><img src="' + image + '"> <a class="delete-image remove-img"><i class="notika-icon notika-close"></i></a><input type="hidden" name="preScreenshots[]" value="' + image + '"></div>';
                            });
                            $('#screen').html(html);
                        }
                    }
                });
            });
        });
    </script>
@endsection
