@extends('layouts.app')
@section('content')
@section('content_header', 'Create Application')
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
                    <a href="{{action('ApplicationController@index')}}"><i class="notika-icon notika-app"></i> Apps</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Create new app</li>
            </ol>
            <form method="POST" enctype="multipart/form-data" action="{{url('/admin/apps')}}">
                @csrf @method('POST')
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="inbox-left-sd">
                        <img src="{{ asset('public/theme/backend/img/default-app.png') }}" id="appimg" alt="App Cover"
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
                                <input type="text" class="form-control" id="AppId" name="appid"
                                       placeholder="App ID* eg: Enter unique app id here.">
                                <button class="btn search-ib waves-effect" id="getinfo">Get Info</button>
                            </div>
                        </div>
                        <!-- box-body -->
                        <div class="box-body">

                            <div class="form-group">
                                <label>App Name <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control"
                                       placeholder="eg: Enter app title here"/>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Select App Category <span class="text-danger">*</span></label>
                                        <select title="Select App Category" id="category" name="category"
                                                class="form-control selectpicker" data-live-search="true">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->slug }}">
                                                    {{ $category->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Developer <span class="text-danger">*</span></label>
                                        <input type="text" id="developer" name="developer" class="form-control"
                                               placeholder="Developer"/>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>size</label>
                                        <input type="text" id="size" name="size" class="form-control"
                                               placeholder="Ex: 50M"/>
                                    </div>
                                </div>

                            </div>
                            <!-- /.row -->
                            <div class="form-group">
                                <label>Recent Change</label>
                                <textarea class="form-control" id="recentChange" name="recentChange"
                                          placeholder="Recent Change"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Summary</label>
                                <textarea class="form-control" id="summary" name="summary"
                                          placeholder="summary"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Description <span class="text-danger">*</span></label>
                                <textarea class="form-control html-editor-cm" id="description" name="description"
                                          placeholder="description"></textarea>
                            </div>
                            <!-- row -->
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Installs</label>
                                        <input type="text" id="installs" name="installs" class="form-control"
                                               placeholder="Ex:100000"/>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Android Version</label>
                                        <input type="text" id="androidVersion" name="androidVersion"
                                               class="form-control"
                                               placeholder="Ex:4.1 and up"/>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>App Version</label>
                                        <input type="text" id="appVersion" name="appVersion" class="form-control"
                                               placeholder="Ex:18.7.5"/>
                                    </div>
                                </div>

                            </div>
                            <!-- /.row -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Number Voters</label>
                                        <input type="text" id="numberVoters" name="numberVoters" class="form-control"
                                               placeholder="Ex: 1000000"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Score</label>
                                        <input type="text" id="score" name="score" class="form-control"
                                               placeholder="Ex: 4.5"/>
                                    </div>
                                </div>
                            </div>
                            <!-- row -->
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>5 Star</label>
                                        <input type="text" id="five" name="five" class="form-control"
                                               placeholder="Ex: 5000"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>4 Star</label>
                                        <input type="text" name="four" id="four" class="form-control"
                                               placeholder="Ex:5000"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>3 Star</label>
                                        <input type="text" name="three" id="three" class="form-control"
                                               placeholder="Ex:5000"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>2 Star</label>
                                        <input type="text" name="two" id="two" class="form-control"
                                               placeholder="Ex:5000"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>1 Star</label>
                                        <input type="text" name="one" id="one" class="form-control"
                                               placeholder="Ex:5000"/>
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
                                               placeholder="Ex: https://apkstore.biz/facebook.apk"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Upload apk Download</label>
                                        <div class="custom-file">
                                            <input type="file" name="apkfile" class="custom-file-input" id="apkfile">
                                            <p id="status" class="text-danger py-3"></p>
                                        </div>
                                        <div class="progress mt-3">
                                            <progress id="progressBar" value="0" max="100"
                                                      class="progress-bar progress-bar-striped bg-success"
                                                      style="width:100%;"></progress>
                                            {{--                                        <div id="progressBar" class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 0%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>--}}
                                        </div>
                                        <button type="button" onclick="uploadFile()"
                                                class="btn btn-warning text-white mt-2">Upload apk file
                                        </button> <label>(Max size Upload: {{ini_get('upload_max_filesize')}})</label>
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
                        <!-- /.box-body -->
                        <div class="image-uploader" style="border: 0;">
                            <div class="uploaded" id="screen">
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btncus btn_blue">Create App</button>
                        </div>
                        <!-- /.form -->
                    </div>
                </div>
            </form>
            {{--            <form id="upload_form" enctype="multipart/form-data" method="post">--}}
            {{--                <input type="file" name="apkfile" id="apkfile" onchange="uploadFile()"><br>--}}
            {{--                <progress id="progressBar" value="0" max="100" style="width:300px;"></progress>--}}
            {{--                <h3 id="status"></h3>--}}
            {{--                <p id="loaded_n_total"></p>--}}
            {{--            </form>--}}
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        {{--function onSetFilename(data) {--}}
        {{--    let fileName = data.value.split("\\").pop();--}}
        {{--    document.getElementById("custom-file-label").innerText=fileName;--}}
        {{--    document.getElementById("progressBar").style.width="0%";--}}
        {{--    document.getElementById("progressBar").classList.add("bg-success");--}}
        {{--}--}}
        {{--function uploadFile() {--}}
        {{--    const image_files = document.getElementById('customFile').files;--}}
        {{--    if(image_files.length) {--}}
        {{--        var token = $("meta[name='csrf-token']").attr("content");--}}
        {{--        let formData = new FormData();--}}
        {{--        formData.append('apkfile', image_files[0]);--}}
        {{--        formData.append('_token', token);--}}
        {{--        let xhr = new XMLHttpRequest();--}}
        {{--        xhr.open("POST", '{{ route('admin.apkupload') }}', true);--}}
        {{--        xhr.addEventListener("progress", function (e) {--}}
        {{--            if(e.lengthComputable) {--}}
        {{--                let percentComplete = e.loaded / e.total * 100;--}}
        {{--                alert(percentComplete);--}}
        {{--                document.getElementById("progressBar").style.width=percentComplete + '%';--}}
        {{--            }--}}
        {{--        }, false);--}}
        {{--        xhr.onreadystatechange = function () {--}}
        {{--            if (xhr.readyState === 4 && xhr.status === 200) {--}}
        {{--                const data = JSON.parse(this.responseText);--}}
        {{--                document.getElementById("custom-file-label").innerText=this.responseText;--}}
        {{--                if(data.success === 1) {--}}
        {{--                    document.getElementById("progressBar").classList.remove("bg-success");--}}
        {{--                    document.getElementById("progressBar").classList.add("bg-danger");--}}
        {{--                    alert("Apk File Uploading failed. Try again..")--}}
        {{--                }--}}
        {{--            }--}}
        {{--        };--}}
        {{--        xhr.send(formData);--}}
        {{--    } else {--}}
        {{--        alert("No File APK selected");--}}
        {{--    }--}}
        {{--}--}}
        function _(el) {
            return document.getElementById(el);
        }

        function uploadFile() {
            const files = document.getElementById('apkfile').files;
            if (files.length) {
                var file = files[0];
                var token = $("meta[name='csrf-token']").attr("content");
                // alert(file.name+" | "+file.size+" | "+file.type);
                var formData = new FormData();
                formData.append("apkfile", file);
                formData.append('_token', token);
                var ajax = new XMLHttpRequest();
                ajax.upload.addEventListener("progress", progressHandler, false);
                ajax.addEventListener("load", completeHandler, false);
                ajax.addEventListener("error", errorHandler, false);
                ajax.addEventListener("abort", abortHandler, false);
                ajax.open("POST", "{{ route('admin.apkupload') }}"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP
                //use file_upload_parser.php from above url
                ajax.send(formData);
            } else {
                _("status").innerHTML = "No File APK selected";
            }
        }

        function progressHandler(event) {
            var percent = (event.loaded / event.total) * 100;
            _("progressBar").value = Math.round(percent);
        }

        function completeHandler(event) {
            _("apkfile").value = null;
            if (event.target.responseText.includes('.apk')) {
                _("url_download").value = event.target.responseText;
                _("status").innerHTML = '';
            } else {
                _("status").innerHTML = event.target.responseText;
            }
            _("progressBar").value = 0; //wil clear progress bar after successful upload
        }

        function errorHandler(event) {
            _("status").innerHTML = "Upload Failed";
        }

        function abortHandler(event) {
            _("status").innerHTML = "Upload Aborted";
        }

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
                $(this).parent('.uploaded-image').remove();
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
