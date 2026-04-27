@extends('layouts.app')

@section('content')

@section('content_header', __('admin.create_slider'))

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
                <div class="box box-primary normal-table-list">
                    <ol class="breadcrumb breadcrumb-alt push">
                        <li class="breadcrumb-item">
                            <a href="{{action('SliderController@index')}}"><i class="notika-icon notika-windows"></i>
                                Slider</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Create Slider</li>
                    </ol>
                    <div class="row">
                        <div class="col-lg-3"><p class="text-muted">Page Information</p></div>
                        <!-- form -->
                        <div class="col-lg-9">

                            <!-- form -->
                            <form method="POST" enctype="multipart/form-data" action="{{url('/admin/sliders')}}">
                            @csrf @method('POST')

                            <!-- box-body -->
                                <div class="box-body">

                                    <div class="form-group">
                                        <label>@lang('admin.title') <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control"
                                               placeholder="@lang('admin.category_title')"/>
                                    </div>

                                    <div class="form-group">
                                        <label>Link <span class="text-danger">*</span></label>
                                        <input type="text" name="link" class="form-control"
                                               placeholder="#"/>
                                    </div>

                                    <div class="form-group">
                                        <label>@lang('admin.image') <span class="text-danger">*</span></label>
                                        <input type="file" name="image">
                                    </div>

                                    <div class="form-group">
                                        <label>@lang('admin.active')</label><br/>
                                        <input type="checkbox" name="active" checked>
                                    </div>

                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <button type="submit" class="btn btncus btn_blue">@lang('admin.submit')</button>
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
