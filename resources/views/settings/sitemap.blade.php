@extends('layouts.app')

@section('content')

@section('content_header', 'GenSiteMaps')

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
                @if($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{$message}}</p>
                    </div>
                @endif
                <div class="box normal-table-list">
                    <ol class="breadcrumb breadcrumb-alt push">
                        <li class="breadcrumb-item">
                            <a href="{{action('AdminController@index')}}"><i class="notika-icon notika-house"></i>
                                Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Gen Sitemaps</li>
                    </ol>
                    <div class="row">
                        <div class="col-lg-3"><p class="text-muted">SiteMaps Configurations<br><small
                                        class="text-muted">
                                    General SiteMaps page.
                                </small></p></div>
                        <!-- form -->
                        <div class="col-lg-9">
                            <div class="box-body">
                                <div class="form-group">
                                    <label>SiteMap</label>
                                    <input type="text" name="site_title" class="form-control"
                                           value="{{url('/').'/sitemaps/sitemap-index.xml'}}"/>

                                </div>
                                <div class="box-footer">
                                    <a href="javascript:void(0)" id="gensiteMap" class="btn btncus btn_blue"><i
                                                class="mr-1 fa fa-check-circle"></i> Update SiteMaps</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->

            </div>
        </div>
    </div>
    <!-- /.box -->

    @endsection

    @section('scripts')
        <script>
            $(document).ready(function () {
                $(document).on('click', '#gensiteMap', function () {
                    $('#gensiteMap').html('<i class="mr-1 fa fa-check-circle"></i> Loadding...');
                    $('#gensiteMap').attr("disabled", true);
                    $.ajax({
                        url: '{{action('SettingController@siteMap')}}',
                        type: 'GET',
                        success: function () {
                            swal("Done!", 'GenSiteMap success', "success");
                            $('#gensiteMap').html('<i class="mr-1 fa fa-check-circle"></i> Update SiteMaps');
                            $('#gensiteMap').attr("disabled", false);
                        }
                    });

                });
            });

        </script>
@endsection