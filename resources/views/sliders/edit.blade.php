@extends('layouts.app')

@section('content')

@section('content_header', __('admin.edit_slider'))

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
                        <li class="breadcrumb-item active" aria-current="page">Edit Slider</li>
                    </ol>
                    <div class="row">
                        <div class="col-lg-3"><p class="text-muted">Page Information</p></div>
                        <!-- form -->
                        <div class="col-lg-9">
                            <form method="POST" enctype="multipart/form-data"
                                  action="{{action('SliderController@update', $id)}}">
                            @csrf @method('PUT')

                            <!-- box-body -->
                                <div class="box-body">

                                    <div class="form-group">
                                        <label>@lang('admin.title') <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control" value="{{$slider->title}}"
                                               placeholder="@lang('admin.slider_title')"/>
                                    </div>

                                    <div class="form-group">
                                        <label>@lang('admin.application_name') <span
                                                class="text-danger">*</span></label>
                                        <div class="form-group">
                                            <label>Link <span class="text-danger">*</span></label>
                                            <input type="text" name="link" class="form-control"
                                                   placeholder="#" value="{{$slider->link}}"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>@lang('admin.image')</label>
                                        <input type="file" name="image">
                                    </div>

                                    <div class="form-group">
                                        <label>@lang('admin.active')</label><br/>
                                        <input type="checkbox"
                                               name="active" {{ $slider->active == 1 ? 'checked' : '' }}>
                                    </div>

                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">@lang('admin.submit') </button>
                                </div>

                            </form>

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
